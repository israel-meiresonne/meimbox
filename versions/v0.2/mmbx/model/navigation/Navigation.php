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
    }

    /**
     * To set current Pages
     */
    private function setCurrentPage()
    {
        $url = Page::extractUrl();
        self::$currentPage = new Page($url);
        // $response = new Response();
        // $userID = $this->getUserID();
        // self::$currentPage->insertPage($response, $userID);
    }

    /**
     * To set Location
     */
    private function setCurrentLocation()
    {
        self::$currentLocation = new Location();
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
     * To get Visitor's Location
     * @return Location Visitor's Location
     */
    public function getCurrentLocation()
    {
        (!isset(self::$currentLocation)) ? $this->setCurrentLocation() : null;
        return self::$currentLocation;
    }

    /**
     * To handle submited request
     * @param Session $session Visitor's Sesssion
     */
    public function handleRequest(Session $session)
    {
        $userID = $this->getUserID();
        $currentPage = $this->getCurrentPage();
        $response = new Response();

        $pageType = $currentPage->getPageType($session);
        switch ($pageType) {
            case Page::TYPE_XHR:
                /** Update Time on last Page */
                try {
                    $pageID = $session->get(Page::KEY_LAST_LOAD);
                    $lastPage = Page::retreivePage($pageID);
                    $lastPage->updatePage($response, $userID);
                } catch (\Throwable $th) {
                    $response->addError($th->__toString(), MyError::ADMIN_ERROR);
                    $currentPageID = $currentPage->generatePageID($userID);
                    $session->set(Page::KEY_LAST_LOAD, $currentPageID);
                }
                break;
            case Page::TYPE_NAVIGATOR:
                /** Update Time on last Page */
                try {
                    $pageID = $session->get(Page::KEY_LAST_LOAD);
                    $lastPage = Page::retreivePage($pageID);
                    $lastPage->updatePage($response, $userID);
                } catch (\Throwable $th) {
                    $response->addError($th->__toString(), MyError::ADMIN_ERROR);
                }
                /** Update last Page in session */
                $currentPageID = $currentPage->generatePageID($userID);
                $session->set(Page::KEY_LAST_LOAD, $currentPageID);
                break;
            case Page::TYPE_NEWCOMER:
                /** Update last Page in session */
                $currentPageID = $currentPage->generatePageID($userID);
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

            $currentPage = $this->getCurrentPage();
            $response = new Response();
            $userID = $this->getUserID();
            $navDate = $currentPage->getSetDate();
            $currentLocation->insertLocation($response, $userID, $navDate);
            // var_dump($response);

            $newLocationID = $currentLocation->generateLocationID($userID);
            $session->set(Location::KEY_LOCATED, $newLocationID);
        }
    }
}
