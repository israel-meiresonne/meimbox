<?php
require_once 'ControllerSecure.php';
require_once 'model/orders-management/payement/stripe/StripeAPI.php';

class ControllerWebhook extends ControllerSecure
{
    /**
     * Holds actions function
     */
    public const ACTION_STRIPEWEBHOOK = "stripeWebhook";
    public const ACTION_BLUEWEBHOOK = "blueWebhook";
    public const ACTION_FACEBOOKCATALOG = "facebookCatalog";

    public function index()
    {
    }

    /*———————————————————————————— SECURE CONTROLLER DOWN ———————————————————*/

    /**
     * To initialize the controller
     */
    public function initController()
    {
        $action = $this->getAction();
        switch ($action) {
            case ControllerWebhook::ACTION_STRIPEWEBHOOK:
                $stripeAPI = new StripeAPI();
                $stripeAPI->handleEvents();
                $clientDatas = $stripeAPI->getCheckoutSessionMetaDatas();
                $CLT_VAL = $clientDatas[Cookie::COOKIE_CLT];
                $this->person = new Client($CLT_VAL);
                break;
            case ControllerWebhook::ACTION_FACEBOOKCATALOG:
            case ControllerWebhook::ACTION_BLUEWEBHOOK:
                $system = new Map(Configuration::getFromJson(Configuration::JSON_KEY_SYSTEM));
                $ADM_VAL = $system->get(Map::cookies, Cookie::COOKIE_ADM, Map::cookieValue);
                $this->person = new Administrator($ADM_VAL);
                break;
            default:
                # code...
                break;
        }
    }

    /*———————————————————————————— SECURE CONTROLLER UP —————————————————————*/

    /**
     * To handle Stripe's events
     */
    public function stripeWebhook()
    {
        $response = new Response();
        /**
         * @var User */
        $person = $this->person;
        $event =  $person->handleStripeEvents($response);
        switch ($event) {
            case StripeAPI::EVENT_CHECKOUT_COMPLETED:
                $firstname = $person->getFirstname();
                $lastname = $person->getLastname();
                $toName = ($firstname . " " . $lastname);
                $toEmail = $person->getEmail();
                $templateFile = 'view/EmailTemplates/orderConfirmation/orderConfirmation.php';
                $company = new Map(Configuration::getFromJson(Configuration::JSON_KEY_COMPANY));
                /**
                 * @var Order */
                $order = $person->getLastOrder();
                $datasViewMap = new Map();
                $datasViewMap->put($toName, Map::name);
                $datasViewMap->put($toEmail, Map::email);
                $datasViewMap->put($templateFile, Map::templateFile);
                $datasViewMap->put($company, Map::company);
                $datasViewMap->put($firstname, Map::firstname);
                $datasViewMap->put($lastname, Map::lastname);
                $datasViewMap->put($order, Map::order);
                try {
                    $this->sendEmail($response, $person, BlueAPI::class, BlueAPI::FUNC_ORDER_CONFIRM, $datasViewMap);
                    $order->getBasketOrdered()->empty($response);        //🔋enable
                } catch (\Throwable $th) {
                    $response->addError($th->__toString(), MyError::ADMIN_ERROR);
                }
                break;
        }
        (!$response->containError()) ? $response->addResult(self::ACTION_STRIPEWEBHOOK, true) : null;
        $this->generateJsonView([], $response, $person);
    }

    /**
     * To handle Sendinblue's events
     */
    public function blueWebhook()
    {
        $response = new Response();
        /**
         * @var Administrator */
        $admin = $this->person;
        $admin->handleBlueEvents($response);
        $file = 'model/tools-management/mailers/BlueAPI/files/response.json';
        (!$response->containError()) ? $response->addResult(self::ACTION_BLUEWEBHOOK, true) : null;
        // $this->saveResponseInFile($file, $response);
    }

    /**
     * To generate catalog file for Facebook
     */
    public function facebookCatalog()
    {
        // $saveFile = "model/marketing/facebook/files/catalog/files/response.json";
        try {
            $response = new Response();
            $person = $this->person;
            $file = Query::getParam(Facebook::GET_CATALOG);
            if (!empty($file)) {
                $language = $person->getLanguage();
                $country = $person->getCountry();
                $currency = $person->getCurrency();
                $catalog = Facebook::getCatalog($file, $language, $country, $currency);
                echo $catalog;
                $response->addResult(self::ACTION_FACEBOOKCATALOG, $catalog);
            }
            // $this->saveResponseInFile($saveFile, $response);
        } catch (\Throwable $th) {
        $saveFile = "model/marketing/facebook/files/catalog/files/response.json";
            $response->addError(Facebook::GET_CATALOG, $file);
            $response->addError(MyError::ADMIN_ERROR, $th);
            $this->saveResponseInFile($saveFile, $response);
        }
    }

    /**
     * To save Response returned in a file
     * @param Response $response the response to save
     */
    private function saveResponseInFile($file, Response $response)
    {
        $array = json_decode(file_get_contents($file), true);
        $arrayMap = new Map($array);
        $saveDate = time();
        $arrayMap->put($response->getAttributs(), $saveDate);
        $arrayMap->sortKeyAsc();
        $json = json_encode($arrayMap->getMap());
        file_put_contents($file, $json);
    }
}
