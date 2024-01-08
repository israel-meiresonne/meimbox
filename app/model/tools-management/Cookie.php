<?php
// require_once 'model/special/Map.php';
// require_once 'framework/Configuration.php';
require_once 'model/ModelFunctionality.php';
require_once 'model/special/Response.php';

/**
 * Represent a cookie from $_COOKIE
 */
class Cookie extends ModelFunctionality
{

    /**
     * Holds cookie's id
     * @var string
     */
    private $cookieID;

    /**
     * Holds cookie's value
     * @var string
     */
    private $value;

    /**
     * Holds cookie's create date
     * @var string
     */
    private $setDate;

    /**
     * Holds availability period SETTED on the cookie
     * @var int
     */
    private $settedPeriod;

    // /**
    //  * Holds availability period of the cookie in second since unix time
    //  * + $lifeTime = unix($setDate) + $settedPeriod
    //  * @var int
    //  */
    // private $lifeTime;

    /**
     * Holds availability period TO SET on the cookie
     * @var int
     */
    private $period;

    /**
     * Holds the domain where the cookie will be available
     * + ex: iadnmeim.com
     * @var string
     */
    private $domain;

    /**
     * Holds the directory where the cookie will be available
     * + ex: /my/directory
     * @var string
     */
    private $path;

    /**
     * Indicate if this cookie can be given only in a secured connection (https)
     * + Set true to indicate that this cookie can be given only in a secured 
     * connection else false
     * @var boolean
     */
    private $secure;

    /**
     * Set true to indicate that this cookie can get only through a http 
     * protocol. Its mean that the cookie con't be get with a script language 
     * like Javascript
     * @var boolean
     */
    private $httponly;

    /**
     * Cookies supported
     * @var string
     */
    public const COOKIE_VIS = "VIS";
    public const COOKIE_CLT = "CLT";
    public const COOKIE_ADM = "ADM";
    public const COOKIE_ADRS = "ADRS";
    public const COOKIE_LCK = "LCK";
    public const COOKIE_CHKT_LNCHD = "CHKT_LNCHD";
    public const TT_SZTP = "TT_SZTP";
    public const TT_RFBRND = "TT_RFBRND";
    public const TT_MSRMNT_CT = "TT_MSRMNT_CT";

    /**
     * Holds cookies state
     * + its the dirrentts state takable by a cookie
     */
    public const STATE_GENERATE = "cookie_state_generate";
    public const STATE_UPDATE = "cookie_state_update";
    public const STATE_GIVE = "cookie_state_give";

    /**
     * Constructor
     * @param string $cookieID cookie's id
     * @param string $value cookie's value
     * @param string $setDate cookie's create date
     * @param int $settedPeriod availability period SETTED on the cookie
     */
    public function __construct($cookieID, $value, $setDate, $settedPeriod)
    {
        if (empty($value)) {
            throw new Exception("Can't Instantiate a Cookie with a empty value");
        }
        $this->cookieID = $cookieID;
        $this->value = $value;
        $this->setDate = $setDate;
        $this->settedPeriod = $settedPeriod;
    }

    /**
     * Constructor used to create and give a new cookie
     * @param string $userID Visitor's id
     * @param string $cookieID id of the cookie
     * @param mixed $value value of the cookie
     */
    public static function generateCookie($userID, $cookieID, $value)
    {
        $cookie = self::buildCompleteCookie($cookieID, $value);
        $cookie->createCookie($userID);
        return $cookie;
    }

    /**
     * To destroy a cookie from Visitor and from db(optional)
     * @param string $userID Visitor's id
     * @param string $cookieID id of the cookie
     * @param boolean $deleteDb set true to delete cookie from db else false or nothing
     */
    public static function destroyCookie($userID, $cookieID, $deleteDb = false)
    {
        $cookie = self::buildCompleteCookie($cookieID, "deleted");
        $cookie->removeCookie();
        if($deleteDb){
            $response = new Response();
            $cookie->deleteCookie($response, $userID);
        }
        // ($deleteDb) ? $cookie-> : null;
    }

    /**
     * To instanciate a cookie with all its attibut setted
     * @return Cookie a cookie with all its attibut setted
     */
    private static function buildCompleteCookie($cookieID, $value)
    {
        $cookiesMap  = parent::getCookiesMap();
        $cookieIDs = $cookiesMap->getKeys();
        if (!in_array($cookieID, $cookieIDs)) {
            throw new Exception("This cookie is not supported, cookieID: '$cookieID'");
        }
        $setDate = parent::getDateTime();
        $settedPeriod = $cookiesMap->get($cookieID, Map::period);
        $cookie = new Cookie($cookieID, $value, $setDate, $settedPeriod);
        $cookie->period = $cookiesMap->get($cookieID, Map::period);
        // $cookie->domain = $cookiesMap->get($cookieID, Map::domain);
        $domainDb = $cookiesMap->get($cookieID, Map::domain);
        $cookie->domain = (!empty($domainDb)) ? $domainDb : Configuration::get(Configuration::DOMAIN);
        $cookie->path = Configuration::getWebRoot() . $cookiesMap->get($cookieID, Map::path);
        $cookie->secure = $cookiesMap->get($cookieID, Map::secure);
        $cookie->httponly = $cookiesMap->get($cookieID, Map::httponly);
        return $cookie;
    }

    /**
     * To create a cookie on Visitor's session and save it in db
     * @param string $userID Visitor's id
     */
    private function createCookie($userID)
    {
        setcookie(
            $this->cookieID,
            $this->value,
            (time() + $this->period),
            $this->path,
            $this->domain,
            $this->secure,
            $this->httponly
        );
        $this->saveCookie($userID);
    }

    /**
     * To create a cookie on Visitor's session and save it in db
     */
    private function removeCookie()
    {
        setcookie(
            $this->cookieID,
            $this->value,
            (time()-$this->period),
            $this->path,
            $this->domain,
            $this->secure,
            $this->httponly
        );
        // $response = new Response();
        // $this->deleteCookie($response, $userID);
    }

    /**
     * To get cookie from $_COOKIE
     * @param string $cookieID id of a cookie
     * @return string|null a cookie
     */
    public static function getCookieValue($cookieID)
    {
        $cookie = null;
        if (key_exists($cookieID, $_COOKIE)) {
            $cookie = $_COOKIE[$cookieID];
        }
        return $cookie;
    }

    /**
     * To get cookie's id
     * @return string cookie's id
     */
    public function getCookieID()
    {
        return $this->cookieID;
    }

    /**
     * To get cookie's value
     * @return string cookie's value
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * To get cookie's available domain
     * @return string cookie's value
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * To get cookie's available path
     * @return string cookie's available path
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * To get cookie's setDate
     * @return string cookie's setDate
     */
    private function getSetDate()
    {
        return $this->setDate;
    }

    /**
     * To get cookie's setted period
     * @return string cookie's setted period
     */
    private function getSettedPeriod()
    {
        return $this->settedPeriod;
    }

    /*—————————————————— SCRUD DOWN —————————————————————————————————————————*/
    /**
     * To save cookie in db
     * + perform an insert if cookie never been setted
     * + perform an update if cookie already exist
     * @param string $userID Visitor's id
     */
    private function saveCookie($userID)
    {
        $response = new Response();
        $cookieID = $this->getCookieID();
        $sql = "SELECT * FROM `Users-Cookies` 
            WHERE `userId` = '$userID' 
            AND `cookieId` = '$cookieID'";
        $tab = $this->select($sql);
        if (empty($tab)) {
            $this->insertCookie($response, $userID);
        } else {
            $this->updateCookie($response, $userID);
        }
        // var_dump($response->getAttributs());
    }

    /**
     * To insert cookie in db
     * @param Response $response to push in results or accured errors
     * @param string $userID Visitor's id
     */
    private function insertCookie(Response $response, $userID)
    {
        $bracket = "(?,?,?,?,?,?,?)"; // regex \[value-[0-9]*\]
        $sql = "INSERT INTO `Users-Cookies`(`userId`, `cookieId`, `cookieValue`, `domain`, `path`, `setDate`, `settedPeriod`) 
                VALUES " . $this->buildBracketInsert(1, $bracket);
        $values = [];
        array_push($values, $userID);
        array_push($values, $this->getCookieID());
        array_push($values, $this->getValue());
        array_push($values, $this->getDomain());
        array_push($values, $this->getPath());
        array_push($values, $this->getSetDate());
        array_push($values, $this->getSettedPeriod());
        $this->insert($response, $sql, $values);
    }

    /**
     * To update cookie in db
     * @param Response $response to push in results or accured errors
     * @param string $userID Visitor's id
     */
    private function updateCookie(Response $response, $userID)
    {
        // $response = new Response();
        $cookieID = $this->getCookieID();
        $sql = "UPDATE `Users-Cookies` SET 
        `cookieValue`=?,
        `domain` =?, 
        `path` =?,
        `setDate`=?,
        `settedPeriod`=? 
        WHERE `Users-Cookies`.`userId` = '$userID' 
        AND `Users-Cookies`.`cookieId` = '$cookieID'";
        $values = [];
        array_push($values, $this->getValue());
        array_push($values, $this->getDomain());
        array_push($values, $this->getPath());
        array_push($values, $this->getSetDate());
        array_push($values, $this->getSettedPeriod());
        $this->update($response, $sql, $values);
    }

    /**
     * To delete Visitor's cookie from db
     * @param Response $response to push in results or accured errors
     * @param string $userID Visitor's id
     */
    private function deleteCookie(Response $response, $userID)
    {
        $cookieID = $this->getCookieID();
        $sql = "DELETE FROM `Users-Cookies` WHERE `userId` = '$userID' AND  `cookieId` = '$cookieID'";
        $this->delete($response, $sql);
    }
}
