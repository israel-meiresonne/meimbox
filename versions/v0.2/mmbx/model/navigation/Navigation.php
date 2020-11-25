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
        $this->userID = $userID;
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
     * To set Pages
     */
    private function setPages()
    {
        $this->pages = [];
    }

    /**
     * To get Pages visited by the Visitor
     * @return Page[] Pages visited by the Visitor
     */
    private function getPages()
    {
        (!isset($this->pages)) ? $this->setPages() : null;
        return $this->pages;
    }

    /**
     * To handle submited request
     * @param Session $session Visitor's Sesssion
     */
    public function handleRequest(Session $session)
    {
        $userID = $this->getUserID();
        $url = Page::extractUrl();
        $currentPage = new Page($url);
        $response = new Response();

        $pageType = $currentPage->getPageType($session);
        var_dump("pageType: $pageType");
        switch ($pageType) {
            case Page::TYPE_XHR:
                /** Update Time on last Page */
                $pageID = $session->get(Page::KEY_LAST_LOAD);
                $lastPage = Page::retreivePage($pageID);
                $lastPage->updatePage($response, $userID);
                break;
            case Page::TYPE_NAVIGATOR:
                /** Update Time on last Page */
                $pageID = $session->get(Page::KEY_LAST_LOAD);
                $lastPage = Page::retreivePage($pageID);
                $lastPage->updatePage($response, $userID);
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
        $currentPage->insertPage($response, $userID);
    }
}
