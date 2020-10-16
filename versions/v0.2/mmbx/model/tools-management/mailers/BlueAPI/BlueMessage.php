<?php
require_once 'model/tools-management/mailers/BlueAPI/BlueAPI.php';

/**
 * This class represente a message created with Sendinblue's API
 */
class BlueMessage extends BlueAPI
{
    /**
     * Holds email recipient of the sender
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
     * To send a email
     */
    private function sendEventEmail()
    {
        $apiInstance = new SendinBlue\Client\Api\TransactionalEmailsApi(
            new GuzzleHttp\Client(),
            $this->getCONFIG()
        );
        $sendSmtpEmail = new \SendinBlue\Client\Model\SendSmtpEmail($this->getAttributs());
        echo $apiInstance->sendTransacEmail($sendSmtpEmail);
    }

    /**
     * To send an order confirmation
     * @param Response $response used store results or errors occured
     * @param string $sendFunc holds function to execute to send email
     * @param Map $dataMap holds datas to config the email
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
     * + $datas[Map::tags]
     */
    public function sendEmail(Response $response, $sendFunc, Map $dataMap)
    {
        $this->sender = $dataMap->get(Map::sender);
        $this->to = $dataMap->get(Map::to);
        $this->bcc = $dataMap->get(Map::bcc);
        $this->cc = $dataMap->get(Map::cc);
        $this->htmlContent = $dataMap->get(Map::htmlContent);
        $this->textContent = $dataMap->get(Map::textContent);
        $this->subject = $dataMap->get(Map::subject);
        $this->replyTo = $dataMap->get(Map::replyTo);
        $this->attachment = $dataMap->get(Map::attachment);
        $this->headers = $dataMap->get(Map::headers);
        $this->templateId = $dataMap->get(Map::templateId);
        $this->params = $dataMap->get(Map::params);
        $this->tags = $dataMap->get(Map::tags);
        if(!method_exists($this, $sendFunc)){
            $class = self::class;
            throw new Exception("This send function '$sendFunc' don't exist in class '$class'");
        }
        $this->$sendFunc();
        // $this->sendEventEmail();
    }
}
