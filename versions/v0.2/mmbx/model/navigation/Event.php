<?php
require_once 'model/ModelFunctionality.php';

/**
 * This class represente a Event done on a web page by the Visitor
 */
class Event extends ModelFunctionality
{
    // /**
    //  * Holds id of the Page where the Event happen
    //  * @var string
    //  */
    // private $pageID;

    /**
     * Holds Event's id
     * @var string
     */
    private $eventID;

    /**
     * Holds code that refer to a Event
     * @var string
     */
    private $eventCode;

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
    private $datasMap;

    /**
     * @var string
     */
    private $setDate;

    private const PREFIX_ID = "evt_id_";

    /**
     * Holds keys to access datas of Events submited
     * @var string
     */
    public const KEY_EVENT = "evt_k";
    public const KEY_DATA = "evt_d";

    /**
     * Constructor
     * @param string    $eventCode  code that refer to a Event
     * @param Map       $datasMap   holds datas submeted with the event
     *                              + Note: must be list of key value, so deep must be of 1
     */
    public function __construct($eventCode, Map $datasMap = null)
    {
        if ((!empty($datasMap)) && (!empty($datasMap->getMap()))) {
            $keys = $datasMap->getKeys();
            foreach ($keys as $key) {
                $value = $datasMap->get($key);
                if (is_array($value) || is_object($value)) {
                    throw new Exception("Event datas are invalid");
                }
            }
        }
        // $eventCode = strtolower($eventCode);
        // $sql = "SELECT `eventCode` FROM `Events` WHERE `eventCode`='$eventCode'";
        // $tab = $this->select($sql);
        $tab = self::retreiveEventLine($eventCode);
        if (count($tab) != 1) {
            throw new Exception("This event code '$eventCode' is invalid");
        }
        $this->eventID = self::PREFIX_ID . $this->generateDateCode(25);
        $this->eventCode = $eventCode;
        $this->datasMap = (!empty($datasMap)) ? $datasMap : null;
        $this->setDate = $this->getDateTime();
    }

    /**
     * To get Event's eventID
     * @return string Event's eventID
     */
    public function getEventID()
    {
        return $this->eventID;
    }

    /**
     * To get Event's eventCode
     * @return string Event's eventCode
     */
    private function getEventCode()
    {
        return $this->eventCode;
    }

    /**
     * To get Event's datasMap
     * @return Map Event's datasMap
     */
    private function getDatasMap()
    {
        (!isset($this->datasMap))? $this->datasMap = new Map() : null;
        return $this->datasMap;
    }

    /**
     * To get Event's setDate
     * @return string Event's setDate
     */
    private function getSetDate()
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
     * To get datas of the event with the given code
     * @param string    $eventCode  code that refer to a Event
     * @return array    table from database that match the event code
     */
    public static function retreiveEventLine($eventCode)
    {
        $eventCode = strtolower($eventCode);
        $sql = "SELECT `eventCode` FROM `Events` WHERE `eventCode`='$eventCode'";
        $tab = parent::select($sql);
        return $tab;
    }

    /*—————————————————— SCRUD DOWN —————————————————————————————————————————*/

    /**
     * To insert event in database
     * @param Response  $response   where to strore results
     * @param string    $xhrID     id of the current page when this Location is created
     */
    public function insertEvent(Response $response, $xhrID)
    {
        $bracket = "(?,?,?,?)"; // regex \[value-[0-9]*\]
        $sql = "INSERT INTO `Navigations-Events`(`xhrId`, `eventID`, `event_code`, `eventDate`)
            VALUES " . $this->buildBracketInsert(1, $bracket);
        $values = [];
        array_push(
            $values,
            $xhrID,
            $this->getEventID(),
            $this->getEventCode(),
            $this->getSetDate()
        );
        $this->insert($response, $sql, $values);
        if ((!$response->containError()) && (!empty($this->getDatasMap()->getKeys()))) {
            $this->insertEventDatas($response);
        }
    }

    /**
     * To insert Event's datas in database
     * @param Response  $response   where to strore results
     */
    private function insertEventDatas(Response $response)
    {
        $datasMap = $this->getDatasMap();
        $params = $datasMap->getKeys();
        $bracket = "(?,?,?)"; // regex \[value-[0-9]*\]
        $sql = "INSERT INTO `EventsDatas`(`eventId`, `dataKey`, `dataValue`)
            VALUES " . $this->buildBracketInsert(count($params), $bracket);
        $values = [];
        $eventID = $this->getEventID();
        foreach($params as $param){
            array_push(
                $values,
                $eventID,
                $param,
                $datasMap->get($param)
            );
        }
        $this->insert($response, $sql, $values);
    }
}
