<?php
require_once 'model/ModelFunctionality.php';
require_once 'model/navigation/Action.php';

/**
 * This class represente a web page visited by the Visitor
 */
class Page extends ModelFunctionality
{
    /**
     * Holds Page's url
     * + url format: https://my.domain.com/my/webroot/my/path?my=param
     * @var string
     */
    private $url;

    /**
     * Holds Page's web root
     * + i.e.: /my/webroot/
     * + Note: begin and end with slash
     * @var string
     */
    private $webroot;

    /**
     * Holds Page's path
     * + i.e.: my/path?my=param
     * + Note: don't begin with slash
     * @var string
     */
    private $path;

    /**
     * Holds url's $_GET parameters
     * @var string[]
     */
    private $params;

    /**
     * Holds the time that the Visitor spent on the Page in second
     * @var int
     */
    private $timeOn;

    /**
     * Holds the date Visitor visited this Page
     * @var string
     */
    private $setDate;

    /**
     * Holds Visitor's behavior on the Page
     * + Note: Action are ordered from new to hold
     * @var Action[]
     */
    private $actions;

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
     * Holds access key to get XHR param
     * @var string
     */
    public const KEY_XHR = "xhr";
    /**
     * Holds access key to get XHR param
     * @var string
     */
    public const KEY_LAST_LOAD = "last_load";

    /**
     * Holds Page's type
     * @var string
     */
    public const TYPE_XHR = "type_xhr";
    public const TYPE_NAVIGATOR = "type_navigator";
    public const TYPE_NEWCOMER = "type_newcomer";

    /**
     * Constructor
     * @param $url  Page's url
     *              + url format: https://my.domain.com/my/webroot/my/path?my=param
     */
    public function __construct($url, $setDate = null)
    {
        $this->url = $url;
        $this->setDate = (isset($setDate)) ? $setDate : $this->getDateTime();
    }

    /**
     * To set webroot
     */
    private function setWebroot()
    {
        $this->getWebroot = Configuration::getWebRoot();
    }

    /**
     * To set path
     */
    private function parseUrl()
    // private function setPath()
    {
        $url = $this->getUrl();
        $webroot = $this->getWebroot();
        $parsedMap = new Map(parse_url($url));

        $webrootPath = $parsedMap->get(Map::path);
        $this->path = substr_replace($webrootPath, "", 0, strlen($webroot));

        $query = $parsedMap->get(Map::query);
        parse_str($query, $params);
        $this->params = $params;
    }

    /**
     * To set timeOn
     * @param int $timeOn time passed on the page
     */
    private function setTimeOn(int $timeOn = null)
    {
        $this->timeOn = $timeOn;
    }

    /**
     * To get Page's url
     * @return string Page's url
     */
    private function getUrl()
    {
        return $this->url;
    }

    /**
     * To get Page's web root
     * @return string Page's web root
     */
    private function getWebroot()
    {
        (!isset($this->getWebroot)) ? $this->setWebroot() : null;
        return $this->getWebroot;
    }

    /**
     * To get Page's params
     * @return string[] Page's params
     */
    // public function getParams()
    private function getParams()
    {
        (!isset($this->params)) ? $this->parseUrl() : null;
        return $this->params;
    }

    /**
     * To get Page's path
     * @return string Page's path
     */
    // public function getPath()
    private function getPath()
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

    public function getSetDate()
    {
        return $this->setDate;
    }

    /**
     * Convert setDate to seconde from UNIX.
     * @return int seconde from UNIX
     */
    public function getDateInSec()
    {
        return strtotime($this->setDate);
    }

    /**
     * To evaluate the Page's type
     * @param Session $session Visitor's Session
     * @return string Page's type
     */
    public function getPageType(Session $session)
    {
        $pageType = null;
        $pageID = $session->get(Page::KEY_LAST_LOAD);
        $hasLast = isset($pageID);
        $isXHR = $this->isXHR();
        if($hasLast && $isXHR){
            $pageType = self::TYPE_XHR;
        } else if($hasLast && (!$isXHR)){
            $pageType = self::TYPE_NAVIGATOR;
        } else if((!$hasLast) && (!$isXHR)){
            $pageType = self::TYPE_NEWCOMER;
        }
        return $pageType;
    }

    /**
     * To generate id for the Page
     * @param string    $userID     Visitor's id
     * @return string id for the Page
     */
    public function generatePageID($userID)
    {
        if (!isset($userID)) {
            throw new Exception("Visitor's id can't be unsetted");
        }
        return $userID . self::SEPARATOR . $this->getSetDate();
    }

    /**
     * Check if Page is a XHR request
     * + will check if Page has the param Page::KEY_XHR
     * @return bool true if Page is a XHR request else false
     */
    public function isXHR()
    {
        $params = $this->getParams();
        return key_exists(self::KEY_XHR, $params);
    }

    // /**
    //  * To save Page in database
    //  * @param Response  $response   where to strore results
    //  * @param string    $userID     Visitor's id
    //  */
    // public function savePage(Response $response, $userID)
    // {
    //     $this->insertPage($response, $userID);
    // }

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
     * To extract userID and setDate from Page's id
     * @param string $pageID id of a page
     * @return Map map that contain userID and a Page's setDate
     * + Map[Map::userID]   => id of a Visitor
     * + Map[Map::setDate]  => a Page's setDate
     */
    private static function explodePageID($pageID)
    {
        $exploded = explode(self::SEPARATOR, $pageID);
        $pageIDMap = new Map();
        $pageIDMap->put($exploded[0], Map::userID);
        $pageIDMap->put($exploded[1], Map::setDate);
        return $pageIDMap;
    }

    /**
     * To get a Page in database
     * @param string $pageID id of a page
     * @return Page
     */
    public static function retreivePage($pageID)
    {
        $pageIDMap = self::explodePageID($pageID);
        $userID = $pageIDMap->get(Map::userID);
        $setDate = $pageIDMap->get(Map::setDate);
        $sql = "SELECT * FROM `Navigations` WHERE `userId`='$userID' AND `navDate`='$setDate'";
        $tab = parent::select($sql);
        if (empty($tab)) {
            throw new Exception("There is no page visited by user '$userID' at this time '$setDate'");
        }
        if (count($tab) != 1) {
            throw new Exception("A user '$userID' can visit one page only at a given time '$setDate'");
        }
        $tabLine = $tab[0];
        $url = $tabLine["userId"];
        $navDate = $tabLine["navDate"];
        $page = new Page($url, $navDate);
        $timeOn = (empty($tabLine["timeOn"])) ? ((int) $tabLine["timeOn"]) : null;
        $page->setTimeOn($timeOn);
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
        $bracket = "(?,?,?,?,?,?)"; // regex \[value-[0-9]*\]
        $sql = "INSERT INTO `Navigations`(`userId`, `navDate`, `url`, `webroot`, `path`, `timeOn`)
            VALUES " . $this->buildBracketInsert(1, $bracket);
        $values = [];
        array_push(
            $values,
            $userID,
            $this->getSetDate(),
            $this->getUrl(),
            $this->getWebroot(),
            $this->getPath(),
            $this->getTimeOn()
        );
        $this->insert($response, $sql, $values);
        if (!$response->containError() && (!empty($this->getParams()))) {
            $this->insertParams($response, $userID);
        }
    }

    /**
     * To update Page
     * @param Response  $response   where to strore results
     * @param string    $userID     Visitor's id
     * @param string    $timeOn     the time Visitor spent on the Page
     */
    public function updatePage($response, $userID, $timeOn = null)
    {
        $navDate = $this->getSetDate();
        $timeOn = (empty($timeOn)) ? (time() - strtotime($navDate)) : $timeOn;
        $sql =
            "UPDATE `Navigations` SET
            `timeOn`= ? 
            WHERE `userId`= '$userID' 
            AND `navDate`= '$navDate'";
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
     * @param string    $userID     Visitor's id
     */
    public function insertParams(Response $response, $userID)
    {
        $params = $this->getParams();
        $nb = count($params);
        $bracket = "(?,?,?,?)"; // regex \[value-[0-9]*\]
        $sql = "INSERT INTO `NavigationsParameters`(`userId`, `nav_date`, `paramKey`, `paramData`)
            VALUES " . $this->buildBracketInsert($nb, $bracket);
        $values = [];
        $setDate = $this->getSetDate();
        foreach ($params as $param => $value) {
            array_push(
                $values,
                $userID,
                $setDate,
                $param,
                $value
            );
        }
        $this->insert($response, $sql, $values);
    }
}
