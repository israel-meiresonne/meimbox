<?php
require_once('vendor/autoload.php');
require_once 'model/tools-management/mailers/Mailer.php';
require_once 'model/tools-management/mailers/BlueAPI/BlueMessage.php';

require_once 'framework/Configuration.php';
require_once 'model/ModelFunctionality.php';
require_once 'model/special/Map.php';
/**
 * This class manage access to Sendinblue's API
 */
// class BlueAPI extends Mailer
class BlueAPI extends ModelFunctionality
{
    /**
     * Holds the api's configuration
     * @var SendinBlue\Client\Configuration
     */
    private static $blueAPI;

    /**
     * @var Translator $translator translator from EmailView to translate email
     */
    private static $translator;

    /**
     * Holds function available
     */
    public const FUNC_ORDER_CONFIRM = "sendOrderConfirmation";

    /**
     * Consttructor
     * @param Translator $translator translator from EmailView to translate email
     */
    public function __construct(Translator $translator)
    {
        // header('content-type: application/json');
        // header('accept: application/json', true);
        // $apik = Configuration::get(Configuration::SENDINBLUE_APIK);
        // self::$blueAPI = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', $apik);
        $this->setBlueAPI();
        self::$translator = $translator;
    }

    /**
     * To set access to the API
     */
    protected function setBlueAPI()
    {
        // header('content-type: application/json');
        // header('accept: application/json', true);
        if(empty(self::$blueAPI)){
            $apik = Configuration::get(Configuration::SENDINBLUE_APIK);
            self::$blueAPI = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', $apik);
        }
    }

    /**
     * To get the api's configuration
     * @return SendinBlue\Client\Configuration
     */
    protected function getBlueAPI()
    {
        return self::$blueAPI;
    }

    /**
     * To get info about the Sendinblue Account
     * @return mixed[] info about the Sendinblue Account
     */
    public function getInfo()
    {
        $apiInstance = new SendinBlue\Client\Api\AccountApi(
            new GuzzleHttp\Client(),
            $this->getBlueAPI()
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
    public function sendOrderConfirmation(Response $response, Map $datasMap)
    {
        $toName = $datasMap->get(Map::name);
        $toEmail = $datasMap->get(Map::email);
        $htmlContent = $datasMap->get(Map::template);
        if (empty($toName)) {
            throw new Exception("Recipient's name can't be empty");
        }
        if (empty($toEmail)) {
            throw new Exception("Email recipient can't be empty");
        }
        if (empty($htmlContent)) {
            throw new Exception("The html content of the email can't be empty");
        }
        $translator = $this->getTranslator();
        $mailing = new Map(Configuration::getFromJson(Configuration::JSON_KEY_MAILING));
        $order_confirmation = new Map($mailing->get(Map::order_confirmation));
        $sender = [
            "name" => strtoupper($order_confirmation->get(Map::sender, Map::name)),
            "email" => $order_confirmation->get(Map::sender, Map::email)
        ];
        $to = [
            ["name" => ucwords($toName), "email" => $toEmail]
        ];
        $subject = ucfirst($translator->translateStation($order_confirmation->get(Map::subject)));
        $replyTo = [
            "name" => ucwords($translator->translateStation($order_confirmation->get(Map::replyTo, Map::name))),
            "email" => $order_confirmation->get(Map::replyTo, Map::email)
        ];
        $tags = $order_confirmation->get(Map::tags);
        $dataMap = new Map();
        $dataMap->put($sender, Map::sender);
        $dataMap->put($to, Map::to);
        $dataMap->put($htmlContent, Map::htmlContent);
        $dataMap->put($subject, Map::subject);
        $dataMap->put($replyTo, Map::replyTo);
        $dataMap->put($tags, Map::tags);
        $blueMessage = new BlueMessage();
        $blueMessage->sendEmail($response, BlueMessage::EMAIL_TYPE_TANSACTIONAL, $dataMap);
    }

    /**
     * To get translator
     * @return Translator translator
     */
    private function getTranslator()
    {
        return self::$translator;
    }
}
