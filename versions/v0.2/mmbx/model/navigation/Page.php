<?php
require_once 'model/ModelFunctionality.php';
// require_once 'model/navigation/Event.php';
require_once 'model/navigation/Xhr.php';

/**
 * This class represente a web page visited by the Visitor
 */
class Page extends ModelFunctionality
{

    /**
     * Holds the type of the Page
     * @var string
     */
    private static $pageType;

    /**
     * Holds Page's id
     * @var string
     */
    private $pageID;

    /**
     * Holds Page's url
     * + url format: https://my.domain.com/my/webroot/my/path?my=param
     * @var string
     */
    protected $url;

    /**
     * Holds Page's web root
     * + i.e.: /my/webroot/
     * + Note: begin and end with slash
     * @var string
     */
    protected $webroot;

    /**
     * Holds Page's path
     * + i.e.: my/path?my=param
     * + Note: don't begin with slash
     * @var string
     */
    protected $path;

    /**
     * Holds url's $_GET parameters
     * @var Map
     */
    protected $paramsMap;

    /**
     * Holds the time that the Visitor spent on the Page in second
     * @var int
     */
    private $timeOn;

    /**
     * Holds the date Visitor visited this Page
     * @var string
     */
    protected $setDate;

    /**
     * Holds request done in this Page
     * @var Map
     */
    private $xhrMap;

    private const PREFIX_ID = "nav_";

    /**
     * Holds path used to send XHR request
     * @var string
     */
    public const PATH_XHR = "/qr/";

    /**
     * Holds separator for id
     * @var string
     */
    public const SEPARATOR = "|";

    /**
     * Holds access key to get url param
     * @var string
     */
    public const KEY_XHR = "xhr";
    /**
     * Holds access key to get $_SESSION param
     * @var string
     */
    public const KEY_LAST_LOAD = "last_load";
    /**
     * Holds access key to get url param
     * @var string
     */
    public const KEY_FROM_ERROR_PAGE = "from_erpg";

    /**
     * Holds Page's type
     * @var string
     */
    public const TYPE_XHR = "qr_xhr";
    public const TYPE_NAVIGATOR = "type_navigator";
    public const TYPE_NEWCOMER = "type_newcomer";

    /**
     * Constructor
     * @param $url  Page's url
     *              + url format: https://my.domain.com/my/webroot/my/path?my=param
     */
    public function __construct($url)
    {
        $this->url = $url;
        $this->pageID = self::PREFIX_ID . $this->generateDateCode(25);
        $this->setDate = $this->getDateTime();
    }

    /**
     * To set webroot
     */
    protected function setWebroot()
    {
        $this->webroot = Configuration::getWebRoot();
    }

    /**
     * To set path
     */
    protected function parseUrl()
    {
        $url = $this->getUrl();
        $webroot = $this->getWebroot();
        $parsedMap = new Map(parse_url($url));

        $webrootPath = $parsedMap->get(Map::path);
        $this->path = substr_replace($webrootPath, "", 0, strlen($webroot));

        $query = $parsedMap->get(Map::query);
        parse_str($query, $params);
        $this->paramsMap = new Map($params);
    }

    /**
     * To generate id for the Page
     * @return string id for the Page
     */
    public function getPageID()
    {
        return $this->pageID;
    }

    /**
     * To get Page's url
     * @return string Page's url
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * To get Page's web root
     * @return string Page's web root
     */
    protected function getWebroot()
    {
        (!isset($this->webroot)) ? $this->setWebroot() : null;
        return $this->webroot;
    }

    /**
     * To get Page's params
     * @return Map Page's params
     */
    protected function getParamsMap()
    {
        (!isset($this->paramsMap)) ? $this->parseUrl() : null;
        return $this->paramsMap;
    }

    /**
     * To get param at the given key
     * @param mixed key of the param to get
     * @return string|null param at the given key
     */
    // public function getParamsMap()
    public function getParam($key)
    {
        $paramsMap = $this->getParamsMap();
        return $paramsMap->get($key);
    }

    /**
     * To get Page's path
     * @return string Page's path
     */
    // public function getPath()
    protected function getPath()
    {
        (!isset($this->path)) ? $this->parseUrl() : null;
        return $this->path;
    }

    /**
     * To get the time that the Visitor spent on Page in second
     * @return int the time that the Visitor spent on the Page in second
     */
    private function getTimeOn()
    {
        return $this->timeOn;
    }

    /**
     * To get xhrMap
     * @return Map xhrMap
     */
    private function getXhrMap()
    {
        (!isset($this->xhrMap)) ? $this->xhrMap = new Map() : null;
        return $this->xhrMap;
    }

    /**
     * To get xhrMap
     * @return Xhr|null the last Xhr request added
     */
    private function getCurrentXhr()
    {
        // (!isset($this->xhrMap)) ? $this->xhrMap = new Map() : null;
        $xhrMap = $this->getXhrMap();
        $keys = $xhrMap->getKeys();
        return (!empty($keys)) ? $xhrMap->get($keys[0]) : null;
    }

    protected function getSetDate()
    {
        return $this->setDate;
    }

    /**
     * Convert setDate to seconde from UNIX.
     * @return int seconde from UNIX
     */
    public function getDateInSec()
    {
        return strtotime($this->getSetDate());
    }

    /**
     * To evaluate the Page's type
     * @param Session $session Visitor's Session
     * @return string Page's type
     */
    public function getPageType(Session $session)
    {
        // $pageType = null;
        if (!isset(self::$pageType)) {
            $isXHR = $this->isXHR();
            if ($isXHR) {
                $pageID = $this->getParam(self::KEY_XHR);
                $hasLast = isset($pageID);
            } else {
                $pageID = $session->get(Session::KEY_LAST_LOAD);
                $hasLast = isset($pageID);
            }
            if ($hasLast && $isXHR) {
                // $pageType = self::TYPE_XHR;
                self::$pageType = self::TYPE_XHR;
            } else if ($hasLast && (!$isXHR)) {
                // $pageType = self::TYPE_NAVIGATOR;
                self::$pageType = self::TYPE_NAVIGATOR;
            } else if ((!$hasLast) && (!$isXHR)) {
                // $pageType = self::TYPE_NEWCOMER;
                self::$pageType = self::TYPE_NEWCOMER;
            }
        }
        // return $pageType;
        return self::$pageType;
    }

    /**
     * To add a new Xhr request on the Page
     * @param Xhr   $xhr    Xhr to add
     */
    public function addXhr(Xhr $xhr)
    {
        $xhrMap = $this->getXhrMap();
        $unix = $xhr->getDateInSec();
        $xhrMap->put($xhr, $unix);
        $xhrMap->sortKeyDesc();
    }

    // /**
    //  * To add a new Event occured on the Page
    //  * + Note: also insert the Event in the database
    //  * @param Response  $response   where to strore results
    //  * @param string $eventCode code that refer to a Event
    //  * @param Map       $datasMap   holds datas submeted with the event
    //  *                              + Note: must be list of key value, so deep must be of 1
    //  */
    // public function addEvent(Response $response, $eventCode, Map $datasMap = null)
    // {
    //     // $event = (!empty($datasMap)) ? new Event($eventCode, $datasMap) : new Event($eventCode);
    //     // $unix = $event->getDateInSec();
    //     // $eventsMap = $this->getEvents();
    //     // $eventsMap->put($event, $unix);
    //     // $eventsMap->sortKeyDesc();
    //     // $pageID = $this->getPageID();
    //     // $event->insertEvent($response, $pageID);
    //     $xhr = $this->getCurrentXhr();
    //     (!empty($datasMap)) ? $xhr->addEvent($response, $eventCode, $datasMap) : $xhr->addEvent( $response, $eventCode);
    // }

    /**
     * Check if Page is a XHR request
     * + will check if Page has the param Page::KEY_XHR
     * @return bool true if Page is a XHR request else false
     */
    public function isXHR()
    {
        $paramsMap = $this->getParamsMap();
        // return key_exists(self::KEY_XHR, $params);
        $keys = $paramsMap->getKeys();
        return in_array(self::KEY_XHR, $keys);
    }

    /**
     * To extract url from the current request
     * @return string url from the current request
     * + url format: https://my.domain.com/my/webroot/my/path?my=param
     */
    public static function extractUrl()
    {
        $url = "";
        /** https:// */
        $url .= (isset($_SERVER["HTTP_X_FORWARDED_PROTO"]))
            ? $_SERVER["HTTP_X_FORWARDED_PROTO"] . "://" : null;
        /** domain => my.domain.com */
        $url .= $_SERVER["HTTP_HOST"];
        /** webroot + params => /webroot/my/path?my=param */
        $url .= $_SERVER["REQUEST_URI"];
        return $url;
    }

    /**
     * To get a Page in database
     * @param string $pageID id of a page
     * @return Page
     */
    public static function retreivePage($pageID)
    {
        // $pageIDMap = self::explodePageID($pageID);
        // $userID = $pageIDMap->get(Map::userID);
        // $setDate = $pageIDMap->get(Map::setDate);
        // $sql = "SELECT * FROM `Navigations` WHERE `userId`='$userID' AND `navDate`='$setDate'";
        $sql =
            "SELECT * FROM `Navigations` n
            LEFT JOIN `NavigationsParameters` np ON n.`navID`=np.`navId`
            WHERE n.`navID`='$pageID'";
        $tab = parent::select($sql);
        if (empty($tab)) {
            throw new Exception("This page id '$pageID' is not valid");
        }
        $tabLine = $tab[0];
        // $this->pageID = $pageID;
        $url = $tabLine["url"];
        $page = new Page($url);
        $page->pageID = $pageID;
        $page->webroot = $tabLine["webroot"];
        $page->path = $tabLine["path"];
        $page->setDate = $tabLine["navDate"];
        $page->timeOn = (!empty($tabLine["timeOn"])) ? ((int) $tabLine["timeOn"]) : null;
        $page->paramsMap = new Map();
        foreach ($tab as $tabLine) {
            if (isset($tabLine["paramKey"])) {
                $key = $tabLine["paramKey"];
                $value = $tabLine["paramValue"];
                // $page->params[$key] = $tabLine["paramValue"];
                $page->paramsMap->put($value, $key);
            }
        }
        // $page->setTimeOn($timeOn);
        return $page;
    }

    /*—————————————————— SCRUD DOWN —————————————————————————————————————————*/

    /**
     * To insert Page in database
     * @param Response  $response   where to strore results
     * @param string    $userID     Visitor's id
     */
    public function insertPage(Response $response, $userID)
    {
        $bracket = "(?,?,?,?,?,?,?)"; // regex \[value-[0-9]*\]
        $sql = "INSERT INTO `Navigations`(`navID`, `userId`, `navDate`, `url`, `webroot`, `path`, `timeOn`)
            VALUES " . $this->buildBracketInsert(1, $bracket);
        $values = [];
        $pageID = $this->getPageID();
        array_push(
            $values,
            $pageID,
            $userID,
            $this->getSetDate(),
            $this->getUrl(),
            $this->getWebroot(),
            $this->getPath(),
            $this->getTimeOn()
        );
        $this->insert($response, $sql, $values);
        if (!$response->containError()) {
            (!empty($this->getParamsMap()->getKeys())) ? $this->insertParams($response) : null;
            $xhr = $this->getCurrentXhr();
            (!empty($xhr)) ? $xhr->insertXhr($response, $userID, $pageID) : null;
        }
    }

    /**
     * To update Page
     * @param Response  $response   where to strore results
     * @param string    $timeOn     the time Visitor spent on the Page
     */
    public function updatePage($response, $timeOn = null)
    {
        $navDate = $this->getSetDate();
        $timeOn = (empty($timeOn)) ? (time() - strtotime($navDate)) : $timeOn;
        $pageID = $this->getPageID();
        $sql =
            "UPDATE `Navigations` SET
            `timeOn`= ? 
            WHERE `navID`= '$pageID'";
        $values = [];
        array_push(
            $values,
            $timeOn
        );
        $this->update($response, $sql, $values);
    }

    /**
     * To insert Page's params in database
     * @param Response  $response   where to strore results
     */
    public function insertParams(Response $response)
    {
        $params = $this->getParamsMap()->getMap();
        $nb = count($params);
        $bracket = "(?,?,?)"; // regex \[value-[0-9]*\]
        $sql = "INSERT INTO `NavigationsParameters`(`navId`, `paramKey`, `paramValue`)
            VALUES " . $this->buildBracketInsert($nb, $bracket);
        $values = [];
        $pageID = $this->getPageID();
        foreach ($params as $param => $value) {
            array_push(
                $values,
                $pageID,
                $param,
                $value
            );
        }
        $this->insert($response, $sql, $values);
    }
}
