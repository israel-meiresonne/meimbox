<?php
require_once 'model/navigation/Page.php';
require_once 'model/navigation/Event.php';

/**
 * This class represente a web page visited by the Visitor
 */
class Xhr extends Page
{
    /**
     * Holds Xhr's id
     * @var string
     */
    private $xhrID;

    /**
     * Holds Event sent with the Xhr request
     * @var Event
     */
    private $event;

    private const PREFIX_ID = "xhr_";

    /**
     * Constructor
     * @param string    $url    Page's url
     *                          + url format: https://my.domain.com/my/webroot/my/path?my=param
     * @param Event     $event  sent with the Xhr request
     */
    public function __construct($url, Event $event = null)
    {
        $this->url = $url;
        if (!$this->isXHR()) {
            throw new Exception("This url '$url' is not a xhr request");
        }
        $this->xhrID = self::PREFIX_ID . $this->generateDateCode(25);
        $this->setDate = $this->getDateTime();
        $this->event = $event;
    }

    /**
     * To generate id for the Page
     * @return string id for the Page
     */
    public function getXhrID()
    {
        return $this->xhrID;
    }

    /**
     * To generate id for the Page
     * @return string id for the Page
     */
    public function getPageID()
    {
        return $this->getXhrID();
        // throw new Exception("Xhr Page don't have page id, call instead getXhrID");
    }

    /**
     * To get Event
     * @return Event event occured on the page
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * To handle a Event by insert it into database
     * @param Response  $response   where to strore results
     * @param string    $userID     Visitor's id
     * @param Event     $event      the Event to handle
     */
    public function handleEvent(Response $response, $userID, Event $event)
    {
        $holdsEvent = $this->getEvent();
        if (!empty($holdsEvent)) {
            $eventID = $holdsEvent->getEventID();
            throw new Exception("This xhr request already holds a Event '$eventID'");
        }
        $xhrID = $this->getXhrID();
        $sql =
            "SELECT * 
        FROM `Navigations`n
        LEFT JOIN `Navigations-Events`ne ON n.`navID`=ne.`xhrId`
        WHERE n.`navID`='$xhrID'";
        $tab = $this->select($sql);
        if (empty($tab)) { // mean that Xhr didn't be inserted already
            $currentPageID = $this->getParam(Page::KEY_XHR);
            $this->insertXhr($response, $userID, $currentPageID);
        } else { // mean that Xhr have been inserted already but dont holds any event
            $event->insertEvent($response, $xhrID);
        }
    }

    /*—————————————————— SCRUD DOWN —————————————————————————————————————————*/

    /**
     * To insert Page in database
     * @param Response  $response   where to strore results
     * @param string    $userID     Visitor's id
     * @param string    $pageID     id of the Page that holds this Xhr request
     */
    public function insertXhr(Response $response, $userID, $pageID)
    {
        $xhrID = $this->getXhrID();
        if ($this->getParam(self::KEY_XHR) != $pageID) {
            throw new Exception("This xhr request of id '$xhrID' is not from this Page with id '$pageID'");
        }
        $bracket = "(?,?,?,?,?,?,?)"; // regex \[value-[0-9]*\]
        $sql = "INSERT INTO `Navigations`(`navID`, `userId`, `xhrFrom`, `navDate`, `url`, `webroot`, `path`)
            VALUES " . $this->buildBracketInsert(1, $bracket);
        $values = [];
        array_push(
            $values,
            $xhrID,
            $userID,
            $pageID,
            $this->getSetDate(),
            $this->getUrl(),
            $this->getWebroot(),
            $this->getPath()
        );
        $this->insert($response, $sql, $values);
        if (!$response->containError()) {
            (!empty($this->getParamsMap()->getKeys())) ? $this->insertParams($response) : null;
            $event = $this->getEvent();
            (!empty($event)) ? $event->insertEvent($response, $xhrID) : null;
        }
    }
}
