<?php
require_once 'model/ModelFunctionality.php';
require_once 'model/navigation/Page.php';
require_once 'model/navigation/Device.php';
require_once 'model/navigation/Location.php';

/**
 * This class is used as facade to manage and track Visitor's navigation
 */
class Navigation extends ModelFunctionality
{
    /**
     * Holds Visitor's id
     * @var string
     */
    private $userID;

    /**
     * Holds Visitor's session from $_SESSION
     * @var Session
     */
    private $session;

    /**
     * Holds the Page using the submited url
     * @var Page|Xhr
     */
    private static $urlPage;

    /**
     * Holds the last pages
     * @var Page
     */
    private static $lastPage;

    /**
     * Holds pages visited by the Visitor
     * + Note: Pages are ordered from new to hold
     * @var Page[]
     */
    private $pages;

    /**
     * Holds the current devices
     * @var Device
     */
    private static $currentDevice;

    /**
     * Holds devices used by the Visitor
     * + Note: Device are ordered from new to hold
     * @var Device[]
     */
    private $devices;

    /**
     * Holds Visitor's current location
     * @var Location
     */
    private static $currentLocation;

    /**
     * Holds Visitor's locations
     * + Note: Location are ordered from new to hold
     * @var Location[]
     */
    private $locations;

    /**
     * Holds min time in second from today to get history in database
     * @var int
     */
    private $minTime;

    /**
     * Holds max time in second from today to get history in database
     * @var int
     */
    private $maxTime;

    /**
     * Holds admin notification
     * @var Response
     */
    private $response;

    /**
     * Constructor
     * @param string    $userID     Visitor's id
     * @param Session   $session    Visitor's Sesssion
     * @param int       $minTime    min time in second from today to get history in database
     * @param int       $maxTime    max time in second from today to get history in database
     */
    public function __construct($userID, Session $session, int $minTime = null, int $maxTime = null)
    {
        if (!isset($userID)) {
            throw new Exception("The Visitor's id must be setted");
        }
        $this->userID = $userID;
        $this->session = $session;
        $this->response = new Response();
        // $this->setLastPage();
    }

    /**
     * To set current Pages
     */
    private function setUrlPage()
    {
        $url = Page::extractUrl();
        $page = new Page($url);
        self::$urlPage = ($page->isXHR()) ? new Xhr($url) : $page;
    }

    /**
     * To set current Device
     */
    private function setCurrentDevice()
    {
        $page = $this->getUrlPage();
        if ($page->isXHR()) {
            throw new Exception("Device can't be initialized with a xhr request");
        }
        $pageID = $page->getPageID();
        self::$currentDevice = new Device($pageID);
    }

    /**
     * To set Location
     */
    private function setCurrentLocation()
    {
        // $pageID = $this->getUrlPage()->getPageID();
        $page = $this->getUrlPage();
        if ($page->isXHR()) {
            throw new Exception("Location can't be initialized with a xhr request");
        }
        $pageID = $page->getPageID();
        self::$currentLocation = new Location($pageID);
    }

    /**
     * Getter for Visitor's id
     * @return string Visitor's id
     */
    public function getUserID()
    {
        return $this->userID;
    }

    /**
     * To get Visitor's session
     * @return Session Visitor's session
     */
    private function getSession()
    {
        return $this->session;
    }

    /**
     * To get the current Pages
     * + Note: return a Xhr object if the current url is a xhr request else return a Page object
     * @return Page|Xhr current Page
     */
    public function getUrlPage()
    {
        (!isset(self::$urlPage)) ? $this->setUrlPage() : null;
        return self::$urlPage;
    }

    // /**
    //  * To get the last Pages visited by the Visitor
    //  * @return Page last Pages visited by the Visitor
    //  */
    // public function getLastPage()
    // {
    //     // (!isset(self::$lastPage)) ? $this->setLastPage() : null;
    //     return self::$lastPage;
    // }

    // /**
    //  * To convert the Page to Xhr if the url request is a xhr request
    //  * @return Xhr          if the url request is a xhr request
    //  * @throws Exception    if the url request is not a xhr request
    //  */
    // public function getXhr()
    // {
    //     $urlPage = $this->getUrlPage();
    //     $url = $urlPage->getUrl();
    //     if(!$urlPage->isXHR()){
    //         throw new Exception("The current url '$url' request is not a xhr request");
    //     }
    //     return Xhr::PageToXhr($urlPage);
    // }

    /**
     * To get current Device
     * @return Device current Device
     */
    private function getCurrentDevice()
    {
        (!isset(self::$currentDevice)) ? $this->setCurrentDevice() : null;
        return self::$currentDevice;
    }

    /**
     * To get Visitor's Location
     * @return Location Visitor's Location
     */
    public function getCurrentLocation()
    {
        (!isset(self::$currentLocation)) ? $this->setCurrentLocation() : null;
        return self::$currentLocation;
    }

    /**
     * To get Navigation's Response
     * @return Response Navigation's Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * To handle submited request
     */
    public function handleRequest()
    {
        $session = $this->getSession();
        // $this->getLastPage();
        $userID = $this->getUserID();
        $urlPage = $this->getUrlPage();
        $response = $this->getResponse();

        $pageType = $urlPage->getPageType($session);
        // var_dump($urlPage);
        switch ($pageType) {
            case Page::TYPE_XHR:
                try {
                    if (!$urlPage->isXHR()) {
                        throw new Exception("Page url must be a Xhr request when the Page type is xhr");
                    }
                    /**
                     * @var Xhr  */
                    $xhr = $urlPage;
                    $currentPageID = $xhr->getParam(Page::KEY_XHR);
                    $lastPage = Page::retreivePage($currentPageID);
                    $lastPage->updatePage($response);
                    /** insert the current url */
                    $xhr->insertXhr($response, $userID, $currentPageID);
                } catch (\Throwable $th) {
                    $response->addError($th->__toString(), MyError::ADMIN_ERROR);
                    $currentPageID = $urlPage->getPageID();
                    $session->set(Page::KEY_LAST_LOAD, $currentPageID);
                }
                break;
            case Page::TYPE_NAVIGATOR:
                /** Update Time on last Page */
                try {
                    $pageID = $session->get(Page::KEY_LAST_LOAD);
                    $lastPage = Page::retreivePage($pageID);
                    $lastPage->updatePage($response);
                } catch (\Throwable $th) {
                    $response->addError($th->__toString(), MyError::ADMIN_ERROR);
                }
                /** insert the current url */
                $urlPage->insertPage($response, $userID);
                /** Update last Page in session */
                $currentPageID = $urlPage->getPageID();
                $session->set(Page::KEY_LAST_LOAD, $currentPageID);
                break;
            case Page::TYPE_NEWCOMER:
                /** insert the current url */
                $urlPage->insertPage($response, $userID);
                /** Update last Page in session */
                $currentPageID = $urlPage->getPageID();
                $session->set(Page::KEY_LAST_LOAD, $currentPageID);
                break;
            default:
                throw new Exception("Unknow Page type '$pageType'");
                break;
        }
        // $urlPage->insertPage($response, $userID);
    }

    /**
     * To handle Event occured with Xhr request
     * @param Response  $response   where to strore results
     * @param string    $userID     Visitor's id
     * @param string    $eventCode  code that refer to a Event
     * @param Map|null  $datasMap   holds datas submeted with the event
     *                              + Note: must be list of key value, so deep must be of 1
     */
    public function handleEvent($response, $userID, $eventCode, Map $eventDatasMap = null)
    {
        $urlPage = $this->getUrlPage();
        if (!$urlPage->isXHR()) {
            throw new Exception("Url request must be a Xhr request to handle event");
        }
        /**
         * @var Xhr */
        $xhr = $urlPage;
        // $event = new Event($eventCode, $eventDatasMap);
        // $xhr->handleEvent($response, $userID, $event);
        $xhr->handleEvent($response, $userID, $eventCode, $eventDatasMap);
    }

    /**
     * To locate Visitor
     */
    public function locate()
    {
        $session = $this->getSession();
        $locationID = $session->get(Location::KEY_LOCATED);
        $urlPage = $this->getUrlPage();
        if ((!isset($locationID)) && (!$urlPage->isXHR())) {
            $currentLocation = $this->getCurrentLocation();
            $response = $this->getResponse();
            $currentLocation->insertLocation($response);
            $newLocationID = $currentLocation->getLocationID();
            $session->set(Location::KEY_LOCATED, $newLocationID);
        }
    }

    /**
     * To detect Visitor's Device
     */
    public function detectDevice()
    {
        $currentDevice = $this->getCurrentDevice();
        $response = $this->getResponse();
        $currentDevice->insertDevice($response);
    }

    /**
     * To save Response returned in a file
     * @param Response $response the response to save
     */
    // private function saveResponseInFile($file, Response $response)
    public function saveResponseInFile()
    {
        $file = 'model/navigation/responses.json';
        $response = $this->getResponse();
        $array = json_decode(file_get_contents($file), true);
        $arrayMap = new Map($array);
        $saveDate = time();
        $arrayMap->put($response->getAttributs(), $saveDate);
        $arrayMap->sortKeyAsc();
        $json = json_encode($arrayMap->getMap());
        file_put_contents($file, $json);
    }
}
