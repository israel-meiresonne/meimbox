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
     * Holds the current pages
     * @var Page
     */
    private static $currentPage;

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
     * @param int       $minTime    min time in second from today to get history in database
     * @param int       $maxTime    max time in second from today to get history in database
     */
    public function __construct($userID, int $minTime = null, int $maxTime = null)
    {
        if (!isset($userID)) {
            throw new Exception("The Visitor's id must be setted");
        }
        $this->userID = $userID;
        $this->response = new Response();
    }

    /**
     * To set current Pages
     */
    private function setCurrentPage()
    {
        $url = Page::extractUrl();
        self::$currentPage = new Page($url);
    }

    /**
     * To set current Device
     */
    private function setCurrentDevice()
    {
        self::$currentDevice = new Device();
    }

    /**
     * To set Location
     */
    private function setCurrentLocation()
    {
        $pageID = $this->getCurrentPage();
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
     * To get the current Pages
     * @return Page current Page
     */
    private function getCurrentPage()
    {
        (!isset(self::$currentPage)) ? $this->setCurrentPage() : null;
        return self::$currentPage;
    }

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
    // private function getResponse()
    {
        return $this->response;
    }

    /**
     * To handle submited request
     * @param Session $session Visitor's Sesssion
     */
    public function handleRequest(Session $session)
    {
        $userID = $this->getUserID();
        $currentPage = $this->getCurrentPage();
        $response = $this->getResponse();

        $pageType = $currentPage->getPageType($session);
        switch ($pageType) {
            case Page::TYPE_XHR:
                /** Update Time on last Page */
                try {
                    $pageID = $session->get(Page::KEY_LAST_LOAD);
                    $lastPage = Page::retreivePage($pageID);
                    $lastPage->updatePage($response);
                } catch (\Throwable $th) {
                    $response->addError($th->__toString(), MyError::ADMIN_ERROR);
                    $currentPageID = $currentPage->getPageID();
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
                /** Update last Page in session */
                $currentPageID = $currentPage->getPageID();
                $session->set(Page::KEY_LAST_LOAD, $currentPageID);
                break;
            case Page::TYPE_NEWCOMER:
                /** Update last Page in session */
                $currentPageID = $currentPage->getPageID();
                $session->set(Page::KEY_LAST_LOAD, $currentPageID);
                break;
            default:
                throw new Exception("Unknow Page type '$pageType'");
                break;
        }
        self::$currentPage->insertPage($response, $userID);
    }

    /**
     * To locate Visitor
     * @param Session $session Visitor's Sesssion
     */
    public function locate(Session $session)
    {
        $locationID = $session->get(Location::KEY_LOCATED);
        if (!isset($locationID)) {
            $currentLocation = $this->getCurrentLocation();

            // $currentPage = $this->getCurrentPage();
            // $response = new Response();
            $response = $this->getResponse();
            // $userID = $this->getUserID();
            // $navDate = $currentPage->getSetDate();
            // $pageID = $currentPage->getPageID();
            $currentLocation->insertLocation($response);
            // var_dump($response);

            $newLocationID = $currentLocation->getLocationID();
            $session->set(Location::KEY_LOCATED, $newLocationID);
        }
    }

    /**
     * To detect Visitor's Device
     * @param Session $session Visitor's Sesssion
     */
    // public function detectDevice(Session $session)
    public function detectDevice()
    {
        $currentDevice = $this->getCurrentDevice();
        // $response = new Response();
        $response = $this->getResponse();
        $userID = $this->getUserID();
        $navDate = $this->getCurrentPage()->getSetDate();
        $currentDevice->insertDevice($response, $userID, $navDate);
        // var_dump("currentDevice:", $currentDevice);
        // var_dump("response:", $response->getAttributs());
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
