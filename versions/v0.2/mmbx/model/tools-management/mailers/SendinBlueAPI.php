<?php
require_once('vendor/autoload.php');
require_once 'framework/Configuration.php';
require_once 'model/ModelFunctionality.php';
require_once 'model/special/Map.php';

class SendinBlueAPI extends ModelFunctionality
{
    /**
     * Holds the api's configuration
     * @var SendinBlue\Client\Configuration
     */
    private static $CONFIG;

    public function __construct()
    {
        header('content-type: application/json');
        header('accept: application/json', true);
        $apik = Configuration::get(Configuration::SENDINBLUE_APIK);
        // $config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', $apik);
        self::$CONFIG = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', $apik);
        // Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
        // $config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('api-key', 'Bearer');
        // Configure API key authorization: partner-key
        // $config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('partner-key', 'YOUR_API_KEY');
        // Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
        // $config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('partner-key', 'Bearer');

        // self::$API = new SendinBlue\Client\Api\AccountApi(
        //     // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
        //     // This is optional, `GuzzleHttp\Client` will be used as default.
        //     new GuzzleHttp\Client(),
        //     $config
        // );

        // try {
        // $result = self::$API->getAccount();
        //     print_r($result);
        // } catch (Exception $e) {
        //     echo 'Exception when calling AccountApi->getAccount: ', $e->getMessage(), PHP_EOL;
        // }
    }

    /**
     * To get the api's configuration
     * @return SendinBlue\Client\Configuration
     */
    private function getCONFIG()
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
            // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
            // This is optional, `GuzzleHttp\Client` will be used as default.
            new GuzzleHttp\Client(),
            self::$CONFIG
        );
        return $apiInstance->getAccount();
    }

    /**
     * To send an order confirmation
     * @param Client $client the recipient
     * @param Map $map datas neccessary to config the email
     */
    public function sendOrderConfirmation(Client $client, Map $map)
    {
        $dataMap = new Map();
        $sender = [
            "name" => "my sender name",
            "email" => "support@iandmeim.com"
        ];
        $to = [
            ["name" => $client->getLastname(), "email" => $client->getEmail()]
        ];
        // $bcc = 
        // $cc = [
        //     ["name" => "witness", "email" => "53298@etu.he2b.be"]
        // ];
        ob_start();
        require 'model/view-management/emails/orderConfirmation.php';
        $htmlContent = ob_get_clean();
        // $textContent = 
        $subject = "My subject";
        $replyTo = [
            "name" => "my reply name",
            "email" => "support@iandmeim.com"
        ];
        // $attachment = 
        // $headers = 
        // $templateId = 
        // $params = 
        $tags = ["order"];
        $dataMap->put($sender, Map::sender);
        $dataMap->put($to, Map::to);
        // $dataMap->put($bcc , Map::bcc);
        // $dataMap->put($cc, Map::cc);
        $dataMap->put($htmlContent, Map::htmlContent);
        // $dataMap->put($textContent , Map::textContent);
        $dataMap->put($subject, Map::subject);
        $dataMap->put($replyTo, Map::replyTo);
        // $dataMap->put($attachment , Map::attachment);
        // $dataMap->put($headers , Map::headers);
        // $dataMap->put($templateId , Map::templateId);
        // $dataMap->put($params , Map::params);
        $dataMap->put($tags, Map::tags);
        $this->sendEventEmail($dataMap);
    }


    /**
     * To send a email
     * @param mixed[] $datas datas required to send an email
     * + $datas[Map::sender] holds sender
     * + + $emailMap[
     * + +  "name" => {string}, (optional)
     * + +  "email" => {string},
     * + +  "id" => {string},   (optional)
     * + + ]
     * + $datas[Map::to] holds the name and email of recipients
     * + + $emailMap[
     * + +  index => ["name" => {string}, "email" => {string}],
     * + + ]
     * + $datas[Map::bcc] to send email blinding other recipient for all
     * + $datas[Map::cc] to send email hidding 'cc' contacts from the 'to' contacts
     * + + invisible for the recipient 'to' but visible for the recipient 'cc'
     * + $datas[Map::htmlContent] holds HTML body of the message
     * + + ignored if templateId given
     * + $datas[Map::textContent] holds Plain Text body of the message
     * + + ignored if templateId given
     * + $datas[Map::subject] holds Subject of the message
     * + + ignored if templateId given
     * + $datas[Map::replyTo] email to send the reply from the recipient
     * + $datas[Map::attachment] holds
     * + $datas[Map::headers] holds
     * + $datas[Map::templateId] holds
     * + $datas[Map::params] holds
     * + $datas[Map::tags] holds
     */
    private function sendEventEmail(Map $dataMap)
    {
        $apiInstance = new SendinBlue\Client\Api\TransactionalEmailsApi(
            // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
            // This is optional, `GuzzleHttp\Client` will be used as default.
            new GuzzleHttp\Client(),
            $this->getCONFIG()
        );
        $sendSmtpEmail = new \SendinBlue\Client\Model\SendSmtpEmail($dataMap->getMap());
        $apiInstance->sendTransacEmail($sendSmtpEmail);
    }
}
