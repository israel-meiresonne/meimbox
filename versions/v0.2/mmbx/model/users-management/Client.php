<?php

require_once 'model/users-management/User.php';

class Client extends User
{
    /**
     * Holds the class's name
     */
    public const CLASS_NAME = "Client";

    /**
     * Show if the Client is subcribed to the newsletter
     * @var boolean true if user is subcribed to the newsletter else false
     */
    private $newsletter;

    /**
     * List of orders passed by the Client.
     * Use the order's setDate in Unix time format (secondes) as access key 
     * like $orders[setDateUnix => Order]
     * @var Order[]
     */
    private $orders;


    /**
     * Constructor
     * @param string $CLT_VAL value of the user's Client  cookie (Cookie::COOKIE_CLT)
     */
    // function __construct($CLT_VAL)
    function __construct()
    {
        $CLT_VAL = Cookie::getCookie(Cookie::COOKIE_CLT);
        if (empty($CLT_VAL)) {
            throw new Exception("Client cookie don't exist");
        }
        parent::__construct($CLT_VAL);
        $this->newsletter = (bool) $this->userLine["newsletter"];
        $this->setMeasure();
        $this->manageCookie(Cookie::COOKIE_CLT);
    }

    // /**
    //  * To update Client's cookies
    //  */
    // private function updateCookies()
    // {
    //     $holdsCookie = $this->getCookie(Cookie::COOKIE_CLT);
    //     $cookieValue = $holdsCookie->getValue();
    //     $newCookie = Cookie::generateCookie($this->userID, Cookie::COOKIE_CLT, $cookieValue);
    //     $this->cookies->put($newCookie, Cookie::COOKIE_CLT);
    // }

    /**
     * Create an order once the Client has paid
     * @var array $dbMap of Database's tables
     * @var Basket $basket of the Client
     */
    public function order($basket, $dbMap)
    {
        $order = new Order($dbMap, $basket);
        $key =  $order->getDateInSec();
        $this->orders[$key] = $order;
        ksort($this->orders);
    }

    // public function __toString()
    // {
    //     parent::__toString();
    //     Helper::printLabelValue("newsletter", $this->newsletter);
    // }
}
