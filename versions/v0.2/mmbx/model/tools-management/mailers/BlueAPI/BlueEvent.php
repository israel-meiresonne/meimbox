<?php
require_once 'model/tools-management/mailers/BlueAPI/BlueAPI.php';

class BlueEvent extends BlueAPI
{
    /**
     * Holds message's id
     * @var string
     */
    private $messageID;

    /**
     * Holds email of the recipient
     * @var string
     */
    private $email;

    /**
     * Holds message's status
     * @var string
     */
    private $status;

    /**
     * Holds message's the reason the event accured
     * @var string
     */
    private $reason;

    /**
     * Holds clicked url on message if the status is click
     * @var string
     */
    private $url;

    /**
     * Holds the IP address used to send the message
     * @var string
     */
    private $sendingIP;

    /**
     * Holds the send date of the message by Sendinblue
     * @var string
     */
    private $sendDate;

    /**
     * Holds the date the event occured
     * @var string
     */
    private $eventDate;

    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * To handle event occured
     */
    public function handleEvent(Response $response)
    {
        $json = @file_get_contents('php://input');
        $event = json_decode($json, true);
        $eventsMap = new Map($event);
        $this->messageID = $eventsMap->get(Map::message_id);
        $this->email = $eventsMap->get(Map::email);
        $this->status = $eventsMap->get(Map::event);
        $this->reason = $eventsMap->get(Map::reason);
        $this->url = $eventsMap->get(Map::link);
        $this->sendingIP = $eventsMap->get(Map::sending_ip);
        $this->sendDate =  date('Y-m-d H:i:s', $eventsMap->get(Map::ts_sent));
        $this->eventDate = date('Y-m-d H:i:s', $eventsMap->get(Map::ts_event));
        $this->insertStatus($response);
        http_response_code(200);
        $this->saveEventInFile($event);
    }

    /**
     * To save event in a file
     * @param array $event handled event
     */
    private function saveEventInFile(array $event)
    {
        $file = 'model/tools-management/mailers/BlueAPI/files/event.json';
        $events = json_decode(file_get_contents($file), true);
        $eventsMap = new Map($events);
        $email = $this->getEmail();
        $messageID = $this->getMessageID();
        $eventDate = strtotime($this->getEventDate());
        $eventsMap->put($event, $email, $messageID, $eventDate);
        $json = json_encode($eventsMap->getMap());
        file_put_contents($file, $json);
    }

    /**
     * To get messageID
     * @return string messageID
     */
    private function getMessageID()
    {
        return $this->messageID;
    }

    /**
     * To get email
     * @return string email
     */
    private function getEmail()
    {
        return $this->email;
    }

    /**
     * To get status
     * @return string status
     */
    private function getStatus()
    {
        return $this->status;
    }

    /**
     * To get reason
     * @return string reason
     */
    private function getReason()
    {
        return $this->reason;
    }

    /**
     * To get url
     * @return string url
     */
    private function getUrl()
    {
        return $this->url;
    }

    /**
     * To get sendingIP
     * @return string sendingIP
     */
    private function getSendingIP()
    {
        return $this->sendingIP;
    }

    /**
     * To get sendDate
     * @return string sendDate
     */
    private function getSendDate()
    {
        return $this->sendDate;
    }

    /**
     * To get eventDate
     * @return string eventDate
     */
    private function getEventDate()
    {
        return $this->eventDate;
    }

    /*———————————————————————————— SCRUD DOWN ———————————————————————————————*/

    /**
     * To insert a new status for an message
     * @param Response $response to push in results or accured errors
     */
    private function insertStatus(Response $response)
    {
        $bracket = "(?,?,?,?,?,?,?)";   // regex \[value-[0-9]*\]
        $sql = "INSERT INTO `EmailsStatus`(`messageId`, `status`, `reason`, `url`, `sendingIP`, `sendDate`, `eventDate`)
                VALUES " . $this->buildBracketInsert(1, $bracket);
        $values = [];
        array_push(
            $values,
            $this->getMessageID(),
            $this->getStatus(),
            $this->getReason(),
            $this->getUrl(),
            $this->getSendingIP(),
            $this->getSendDate(),
            $this->getEventDate()
        );
        $this->insert($response, $sql, $values);
    }
}
