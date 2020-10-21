<?php
require_once 'model/tools-management/mailers/BlueAPI/BlueAPI.php';

/**
 * This class represente a message created with Sendinblue's API
 */
class BlueMessage extends BlueAPI
{
    /**
     * Holds email of the sender
     * @var string[]
     * + + $emailMap[
     * + +  "name" => {string}[0,1],
     * + +  "email" => {string},
     * + +  "id" => {string}[0,1],
     * + + ]
     */
    private $sender;

    /**
     * Holds list of contact to send the email
     * @var array[string[]]
     * + + $emailMap[
     * + +  ["name" => {string}, "email" => {string}],
     * + + ]
     */
    private $to;


    /**
     * Holds list of contact to send email and blind them from contacts in 
     * field 'to'
     * + contacts from the 'cc' field can see the one in the 'to' field
     * @var array[string[]]
     * + + $emailMap[
     * + +  ["name" => {string}, "email" => {string}],
     * + + ]
     */
    private $cc;

    /**
     * Holds list of contact to send the email but no one can see the other 
     * contact who received the email
     * @var array[string[]]
     * + + $emailMap[
     * + +  ["name" => {string}, "email" => {string}],
     * + + ]
     */
    private $bcc;

    /**
     * Holds the html content of the email
     * @var string
     */
    private $htmlContent;

    /**
     * Holds the textual content of the email
     * @var string
     */
    private $textContent;

    /**
     * Holds the subject of the email
     * @var string
     */
    private $subject;

    /**
     * Holds the email recipient to reply to
     * @var string[]
     * + + $emailMap[
     * + +  "name" => {string}[0,1],
     * + +  "email" => {string},
     * + + ]
     */
    private $replyTo;

    /**
     * Holds files to send with the email
     * @var array[string[]]
     */
    private $attachment;

    /**
     * @var 
     */
    private $headers;

    /**
     * Tamplate if
     * @var 
     */
    private $templateId;

    /**
     * @var 
     */
    private $params;

    /**
     * Holds a list of tag you want to give to the email to track itt more easily
     * @var string[]
     */
    private $tags;

    /**
     * Holds the name of function to execute to send an email
     * @var string
     */
    public const EMAIL_TYPE_TANSACTIONAL = "sendEventEmail";

    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * To send a email
     * @param Response $response used store results or errors occured
     */
    private function sendEventEmail(Response $response)
    {
        $apiInstance = new SendinBlue\Client\Api\TransactionalEmailsApi(
            new GuzzleHttp\Client(),
            $this->getCONFIG()
        );
        $sendSmtpEmail = new \SendinBlue\Client\Model\SendSmtpEmail($this->getAttributs());
        try {
            $json = $apiInstance->sendTransacEmail($sendSmtpEmail);
        } catch (\SendinBlue\Client\ApiException $apiErr) {
            $json = $apiErr->getResponseBody();
        } catch (\InvalidArgumentException $argErr) {
            $map = [
                Map::code => get_class($argErr),
                Map::message => $argErr->getMessage()
            ];
            $json = json_encode($map);
        }
        $blueResponseMap = new Map(json_decode($json, true));
        $this->insertMessage($response, $blueResponseMap);
        if (!empty($argErr)) {
            throw $argErr;
        }
        if (!empty($apiErr)) {
            throw $apiErr;
        }
    }

    /**
     * To send an order confirmation
     * @param Response $response used store results or errors occured
     * @param string $sendFunc holds function to execute to send email
     * @param Map $datasMap holds datas to config the email
     * + $datas[Map::sender]
     * + $datas[Map::to]
     * + $datas[Map::bcc]
     * + $datas[Map::cc]
     * + $datas[Map::htmlContent]
     * + $datas[Map::textContent]
     * + $datas[Map::subject]
     * + $datas[Map::replyTo]
     * + $datas[Map::attachment]
     * + $datas[Map::headers]
     * + $datas[Map::templateId]
     * + $datas[Map::params]
     * + $datas[Map::tag]
     */
    public function sendEmail(Response $response, $sendFunc, Map $datasMap)
    {
        $this->sender = $datasMap->get(Map::sender);
        $this->to = $datasMap->get(Map::to);
        $this->bcc = $datasMap->get(Map::bcc);
        $this->cc = $datasMap->get(Map::cc);
        $this->htmlContent = $datasMap->get(Map::htmlContent);
        $this->textContent = $datasMap->get(Map::textContent);
        $this->subject = $datasMap->get(Map::subject);
        $this->replyTo = $datasMap->get(Map::replyTo);
        $this->attachment = $datasMap->get(Map::attachment);
        $this->headers = $datasMap->get(Map::headers);
        $this->templateId = $datasMap->get(Map::templateId);
        $this->params = $datasMap->get(Map::params);
        $this->tags = $datasMap->get(Map::tags);
        if (!method_exists($this, $sendFunc)) {
            $class = self::class;
            throw new Exception("This send function '$sendFunc' don't exist in class '$class'");
        }
        $this->$sendFunc($response);
    }

    /**
     * To get BlueMeassage's attributs
     * @return string[] BlueMeassage's attributs
     */
    public function getAttributs()
    // private function getAttributs()
    {
        $map = get_object_vars($this);
        // unset($map["files"]);
        // unset($map["errorStations"]);
        return $map;
    }

    /**
     * To get to
     * @return string[] blue message's to field
     */
    private function getTo()
    {
        return (!empty($this->to)) ? $this->to : [];
    }

    /**
     * To get cc
     * @return string[] blue message's cc field
     */
    private function getCc()
    {
        return (!empty($this->cc)) ? $this->cc : [];
    }

    /**
     * To get bcc
     * @return string[] blue message's bcc field
     */
    private function getBcc()
    {
        return (!empty($this->bcc)) ? $this->bcc : [];
    }

    /**
     * To get tags
     * @return string[] message's tags
     */
    private function getTags()
    {
        return (!empty($this->tags)) ? $this->tags : [];
    }

    /**
     * To merge the to, cc and bcc field
     * @return array
     * + [
     * + + ["name" => {string}, "email" => {string}],
     * + ]
     */
    private function megeRecipients()
    {
        $contacts = array_merge($this->getTo(), $this->getCc(), $this->getBcc());
        $pushed = [];
        $recipients = [];
        foreach ($contacts as $contact) {
            $email = $contact[Map::email];
            if (!in_array($email, $pushed)) {
                array_push($recipients, $contact);
                array_push($pushed, $email);
            }
        }
        return $recipients;
    }

    /**
     * To check if a value is holds by a the to, cc or bcc field
     * @param string $field the name of the attribut  to check
     * @param string $value value to look for
     * @param string $key field to check in the attribut map
     * @return boolean true if value is in field holds by the given key else false
     */
    private function isInField($field, $value, $key)
    {
        $isInField = false;
        if (!property_exists($this, $field)) {
            throw new Exception("This attribut '$field' don't exist");
        }
        if (!empty($this->$field)) {
            foreach ($this->$field as $contact) {
                $isInField = (key_exists($key, $contact)) ? $contact[$key] == $value : $isInField;
                if ($isInField) {
                    break;
                }
            }
        }
        return $isInField;
    }

    /*———————————————————————————— SCRUD DOWN ———————————————————————————————*/

    /**
     * To save sent message in db
     * @param Response $response used store results or errors occured
     * @param Map $blueResponseMap response returned by Sendinblue's API
     */
    private function insertMessage(Response $response, Map $blueResponseMap)
    {
        $rspKeys = $blueResponseMap->getKeys();
        $messageID = (in_array(Map::messageId, $rspKeys))
            ? $blueResponseMap->get(Map::messageId)
            : $this->generateDateCode(25);
        $code = (in_array(Map::code, $rspKeys)) ? $blueResponseMap->get(Map::code) : null;
        $message = (in_array(Map::message, $rspKeys)) ? $blueResponseMap->get(Map::message) : null;

        $map = new Map($this->getAttributs());
        $recipients = new Map($this->megeRecipients());

        $keys = $recipients->getKeys();
        $bracket = "(?,?,?,?,?,?,?,?,?,?,?,?,?,?)";   // regex \[value-[0-9]*\]
        $sql = "INSERT INTO `EmailsSent`(`messageID`, `recipient`, `recipientName`, `mailer_`, `subject`, `sender`, `toField`, `ccField`, `bccField`, `replyTo`, `content`, `sendDate`, `code`, `message`) 
                VALUES " . $this->buildBracketInsert(count($keys), $bracket);
        $values = [];
        foreach ($keys as $key) {
            $recipientEmail = $recipients->get($key, Map::email);
            $content = (!empty($map->get(Map::htmlContent))) ? $map->get(Map::htmlContent) : "";
            $content = (empty($content) && (!empty($map->get(Map::textContent)))) ? $map->get(Map::textContent) : $content;
            array_push(
                $values,
                $messageID,
                $recipientEmail,
                $recipients->get($key, Map::name),
                BlueAPI::class,
                $map->get(Map::subject),
                $map->get(Map::sender, Map::email),
                ((int)$this->isInField(Map::to, $recipientEmail, Map::email)),
                ((int)$this->isInField(Map::cc, $recipientEmail, Map::email)),
                ((int)$this->isInField(Map::bcc, $recipientEmail, Map::email)),
                $map->get(Map::replyTo, Map::email),
                $content,
                $this->getDateTime(),
                $code,
                $message
            );
        }
        $this->insert($response, $sql, $values);
        $this->insertTags($response, $messageID);
    }

    /**
     * To insert message's tags in db
     * @param Response $response used store results or errors occured
     * @param string $messageID id of the message
     */
    private function insertTags(Response $response, string $messageID)
    {
        $tags = $this->getTags();
        if (!empty($tags)) {
            $bracket = "(?,?)";   // regex \[value-[0-9]*\]
            $sql = "INSERT INTO `EmailsTags`(`messageId`, `tag`)
                    VALUES " . $this->buildBracketInsert(count($tags), $bracket);
            $values = [];
            foreach ($tags as $tag) {
                array_push(
                    $values,
                    $messageID,
                    $tag
                );
            }
            $this->insert($response, $sql, $values);
        }
    }
}
