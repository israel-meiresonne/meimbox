<?php
require_once 'model/ModelFunctionality.php';

/**
 * This class represente a Event done on a web page by the Visitor
 */
class Event extends ModelFunctionality
{
    /**
     * Holds id of the Page where the Event happen
     * @var string
     */
    private $pageID;

    /**
     * Holds Event's id
     * @var string
     */
    private $eventID;

    /**
     * Holds the event's name
     * @var string
     */
    private $event;

    /**
     * Holds support where the Event's applied
     * @var string
     */
    private $element;

    /**
     * Holds identifient of the support where the Event's applied
     * @var string
     */
    private $name;

    /**
     * Holds the result of the Event
     * @var string
     */
    private $result;

    /**
     * Holds datas related to the Event
     * @var Map
     */
    private $datas;

    /**
     * @var string
     */
    private $setDate;

    /**
     * Holds keys to access datas of Events submited
     * @var string
     */
    public const KEY_EVENT = "evt_k";
    public const KEY_DATA = "evt_d";

    /**
     * Holds available events
     * @var Map
     */
    private static $eventMap = [
        "code" => [
            Map::event => self::ACT_SCROLL,
            Map::element => self::ELMT_SCROLER
        ]
    ];
    public const ACT_CLICK = "click";
    public const ACT_FOCUS = "focus";
    public const ACT_UNFOCUS = "unfocus";
    public const ACT_CHANGE = "change";
    public const ACT_SCROLL = "scroll";

    /**
     * Holds elements
     * @var string
     */
    public const ELMT_BUTTON = "button";
    public const ELMT_PAGE = "page";
    public const ELMT_LINK = "link";
    public const ELMT_TEXT = "text";
    public const ELMT_SCROLER = "scroller";

    /**
     * Constructor
     * @param string $event
     * @param string $element
     * @param string $name
     * @param string $result
     */
    public function __construct($event, $element, $name, $result, Map $datas = null)
    {
        // $this->setConstants();
        $this->event = $event;
        $this->element = $element;
        $this->name = $name;
        $this->result = $result;
        $this->datas = $datas;
        $this->setDate = $this->getDateTime();
    }

    // /**
    //  * To set constants
    //  */
    // private function setConstants()
    // {
    //     if (!isset($this->eventMap)) {
    //         self::$eventMap = new Map();
    //         self::$eventMap->put()
    //     }
    //     if (!isset($this->onMap)) {
    //         $this->onMap = new Map();
    //     }
    // }

    /**
     * Convert setDate to seconde from UNIX.
     * @return int seconde from UNIX
     */
    public function getDateInSec()
    {
        return strtotime($this->setDate);
    }
}
