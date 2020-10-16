<?php
require_once('vendor/autoload.php');
// require_once 'model/tools-management/mailers/Mailer.php';
require_once 'model/tools-management/mailers/BlueAPI/BlueMessage.php';

require_once 'framework/Configuration.php';
require_once 'model/ModelFunctionality.php';
require_once 'model/special/Map.php';
/**
 * This class manage access to Sendinblue's API
 */
class BlueAPI extends ModelFunctionality
{
    /**
     * Holds the api's configuration
     * @var SendinBlue\Client\Configuration
     */
    private static $CONFIG;

    /**
     * Holds function available
     */
    public const FUNC_ORDER_CONFIRM = "sendOrderConfirmation";


    public function __construct()
    {
        header('content-type: application/json');
        header('accept: application/json', true);
        $apik = Configuration::get(Configuration::SENDINBLUE_APIK);
        self::$CONFIG = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', $apik);
    }

    /**
     * To get the api's configuration
     * @return SendinBlue\Client\Configuration
     */
    protected function getCONFIG()
    {
        return self::$CONFIG;
    }

    /**
     * To get info about the Sendinblue Account
     * @return mixed[] info about the Sendinblue Account
     */
    public function getInfo()
    {
        $apiInstance = new SendinBlue\Client\Api\AccountApi(
            new GuzzleHttp\Client(),
            $this->getCONFIG()
        );
        return $apiInstance->getAccount();
    }

    /**
     * To send an order confirmation
     * @param Response $response used store results or errors occured
     * @param Map $datasMap datas used to send a email confirmation
     * + $datasMap[Map::name] => complete name of the recipient
     * + $datasMap[Map::email] => email recipient
     * + $datasMap[Map::template] => the html content of the email
     */
    // public function sendOrderConfirmation(Response $response, $toName, $toEmail, $htmlContent)
    public function sendOrderConfirmation(Response $response, Map $datasMap)
    // public function sendOrderConfirmation(Client $client)
    {
        $toName = $datasMap->get(Map::name);
        $toEmail = $datasMap->get(Map::email);
        $htmlContent = $datasMap->get(Map::template);
        if(empty($toName)){
            throw new Exception("Recipient's name can't be empty");
        }
        if(empty($toEmail)){
            throw new Exception("Email recipient can't be empty");
        }
        if(empty($htmlContent)){
            throw new Exception("The html content of the email can't be empty");
        }
        $dataMap = new Map();
        $sender = [
            "name" => "my sender name",
            "email" => "support@iandmeim.com"
        ];
        $to = [
            ["name" => $toName, "email" => $toEmail]
        ];
        $subject = "My subject";
        $replyTo = [
            "name" => "my reply name",
            "email" => "support@iandmeim.com"
        ];
        $tags = ["order"];
        $dataMap->put($sender, Map::sender);
        $dataMap->put($to, Map::to);
        $dataMap->put($htmlContent, Map::htmlContent);
        $dataMap->put($subject, Map::subject);
        $dataMap->put($replyTo, Map::replyTo);
        $dataMap->put($tags, Map::tags);
        $blueMessage = new BlueMessage();
        $blueMessage->sendEmail($response, BlueMessage::EMAIL_TYPE_TANSACTIONAL, $dataMap);
    }


    // /**
    //  * To send a email
    //  * @param mixed[] $datas datas required to send an email
    //  * + $datas[Map::sender] holds sender
    //  * + + $emailMap[
    //  * + +  "name" => {string}, (optional)
    //  * + +  "email" => {string},
    //  * + +  "id" => {string},   (optional)
    //  * + + ]
    //  * + $datas[Map::to] holds the name and email of recipients
    //  * + + $emailMap[
    //  * + +  index => ["name" => {string}, "email" => {string}],
    //  * + + ]
    //  * + $datas[Map::bcc] to send email blinding other recipient for all
    //  * + $datas[Map::cc] to send email hidding 'cc' contacts from the 'to' contacts
    //  * + + invisible for the recipient 'to' but visible for the recipient 'cc'
    //  * + $datas[Map::htmlContent] holds HTML body of the message
    //  * + + ignored if templateId given
    //  * + $datas[Map::textContent] holds Plain Text body of the message
    //  * + + ignored if templateId given
    //  * + $datas[Map::subject] holds Subject of the message
    //  * + + ignored if templateId given
    //  * + $datas[Map::replyTo] email to send the reply from the recipient
    //  * + $datas[Map::attachment] holds
    //  * + $datas[Map::headers] holds
    //  * + $datas[Map::templateId] holds
    //  * + $datas[Map::params] holds
    //  * + $datas[Map::tags] holds
    //  */
    // private function sendEventEmail(Map $dataMap)
    // {
    //     $apiInstance = new SendinBlue\Client\Api\TransactionalEmailsApi(
    //         new GuzzleHttp\Client(),
    //         $this->getCONFIG()
    //     );
    //     $sendSmtpEmail = new \SendinBlue\Client\Model\SendSmtpEmail($dataMap->getMap());
    //     $apiInstance->sendTransacEmail($sendSmtpEmail);
    // }
}
