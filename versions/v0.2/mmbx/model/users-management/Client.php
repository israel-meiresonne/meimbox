<?php

require_once 'model/users-management/User.php';

class Client extends User
{
    /**
     * Show if the Client is subcribed to the newsletter
     * @var boolean true if user is subcribed to the newsletter else false
     */
    private $newsletter;

    // /**
    //  * List of orders passed by the Client.
    //  * Use the order's setDate in Unix time format (secondes) as access key 
    //  * like $orders[setDateUnix => Order]
    //  * @var Order[]
    //  */
    // private $orders;


    /**
     * Constructor
     * @param string $CLT_VAL value of the user's Client  cookie (Cookie::COOKIE_CLT)
     */
    function __construct($CLT_VAL = null, bool $track = true)
    {
        $CLT_VAL = (empty($CLT_VAL)) ? Cookie::getCookieValue(Cookie::COOKIE_CLT) : $CLT_VAL;
        if (empty($CLT_VAL)) {
            throw new Exception("Client cookie can't be empty");
        }
        parent::__construct($CLT_VAL);
        $this->newsletter = (bool) $this->userLine["newsletter"];
        // $this->setMeasure();
        $this->manageCookie(Cookie::COOKIE_CLT, true);
        ($track) ? $this->trackNavigation() : null;
    }

    /**
     * To manage Visitor's navigation
     * @param string $VIS_VAL Visitor's visitor cookie
     */
    protected function trackNavigation($VIS_VAL = null)
    {
        // $session = $this->getSession();
        $navigation = $this->getNavigation();
        $navigation->handleRequest();
        $navigation->locate();
        $navigation->saveResponseInFile();
        // (!isset($VIS_VAL)) ? $navigation->detectDevice() : null;
    }

    /**
     * To transfer Visitor's datas to the Client account matching the given email
     * @param Response  $response   to push in result or accured error
     * @param Visitor   $visitor    the Visitor to convert
     * @param string    $email      email of a Client account
     * @return Client   Client account of matching the given email
     */
    public static function visitorToClient($response, Visitor $visitor, $email)
    {
        $client = self::retreiveClient($email);
        self::transferToClient($response, $visitor, $client);
    }

    /**
     * To retreive from database the Clientt with the given email
     * @param string    $email      email of a Client account
     * @return  Client a Client account
     */
    private static function retreiveClient($email)
    {
        $sql = "SELECT * 
        FROM `Users` u
        JOIN `Users-Cookies` uc ON u.`userID` = uc.`userId`
        WHERE u.`mail` = '$email' AND uc.`cookieId` = '" . Cookie::COOKIE_CLT . "'";
        $tab = parent::select($sql);
        if (count($tab) != 1) {
            throw new Exception("There any client cookie for this email '$email'");
        }
        $tabLine = $tab[0];
        $CLT_VAL = $tabLine["cookieValue"];
        $client = new Client($CLT_VAL, false);
        return $client;
    }

      /**
     * To addition Visitor's datas with datas from his Client account
     * @param Response $response to push in result or accured error
     * @param Client $client Visitor's Client account
     */
    private static function transferToClient(Response $response, Visitor $visitor, Client $client)
    {
        $userID_VIS = $visitor->getUserID();
        $userID_CLT = $client->getUserID();
        $visitor->updateVisitorToClient($response, $userID_VIS, $userID_CLT);
        if (!$response->containError()) {
            $visitor->deleteVisitorToClient($response, $userID_VIS);
            if (!$response->containError()) {
                (count($visitor->getMeasures()) > 0) ? $visitor->mergeMeasures($response, $client) : null;
                // if(!$response->containError()){ put this method in basket
                //     (count($this->getBasket()->getBasketProducts()) > 0) ? $this->getBasket()->mergeBasket($response, $client) : null;
                // }
            }
        }
    }
}
