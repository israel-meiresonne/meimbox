<?php
require_once 'ControllerSecure.php';
require_once 'model/tools-management/mailers/BlueAPI/BlueAPI.php';

class ControllerCheckout extends ControllerSecure
{

    /**
     * Holds actions function
     */
    public const CTR_NAME = "checkout";

    /**
     * Holds actions function
     */
    public const ACTION_INDEX = "index";
    public const ACTION_SIGN = "sign";
    public const ACTION_ADDRESS = "address";
    public const ACTION_STRIPEWEBHOOK = "stripeWebhook";

    /**
     * Holds request
     * + also used for ajax request
     */
    public const QR_SELECT_ADRS = "checkout/selectAddress";
    public const QR_NW_CHCKT_SS = "checkout/getSessionId";

    /**
     * The layout for the checkout page
     */
    public function index()
    {
        $address = $this->person->getSelectedAddress();
        if (empty($address)) {
            $this->redirect($this->extractController(get_class($this)), self::ACTION_ADDRESS);
        }
        $datasView = [
            "address" => $address
        ];
        $this->generateView($datasView, $this->person);
    }

    /**
     * The layout for the checkout page
     */
    public function sign()
    {
        $datasView = [];
        $this->generateView($datasView, $this->person);
    }

    /**
     * The layout for the checkout page
     */
    public function address()
    {
        $datasView = [];
        $this->generateView($datasView, $this->person);
    }

    /**
     * The layout for the success page
     */
    public function success()
    {
        var_dump("The layout for the success page");
        var_dump($_GET);
    }

    /*———————————————————————————— LAYOUT UP ——————————————————————————————————*/
    /*———————————————————————————— REQUEST DOWN ———————————————————————————————*/

    /**
     * To select an shipping address
     */
    public function selectAddress()
    {
        $response = new Response();
        $datasView = [];
        if (!Query::existParam(Address::KEY_ADRS_SEQUENCE)) {
            $response->addErrorStation("ER1", MyError::FATAL_ERROR);
        } else {
            $sequence =  Query::getParam(Address::KEY_ADRS_SEQUENCE);
            $this->person->selectAddress($response, $sequence);
            if (!$response->containError()) {
                $response->addResult(self::QR_SELECT_ADRS, self::CTR_NAME);
            }
        }
        $this->generateJsonView($datasView, $response, $this->person);
    }

    /**
     * To create a new checkoutSession and get its id
     */
    public function getSessionId()
    {
        $response = new Response();
        $datasView = [];
        if (!Query::existParam(CheckoutSession::KEY_STRP_MTD)) {
            $response->addErrorStation("ER1", MyError::FATAL_ERROR);
        } else {
            $payMethod = Query::getParam(CheckoutSession::KEY_STRP_MTD);
            $sessionId = $this->person->createNewCheckout($response, $payMethod);
            if (!$response->containError()) {
                $response->addResult(self::QR_NW_CHCKT_SS, $sessionId);
            }
        }
        $this->generateJsonView($datasView, $response, $this->person);
    }

    /**
     * To handle Stripe's events
     */
    public function stripeWebhook()
    {
        $response = new Response();
        $event =  $this->person->handleStripeEvents($response);
        switch ($event) {
            case StripeAPI::EVENT_CHECKOUT_COMPLETED:
                $firstname = $this->person->getFirstname();
                $lastname = $this->person->getLastname();
                $toName = ($firstname." ".$lastname);
                $toEmail = $this->person->getEmail();
                $templateFile = 'view/EmailTemplates/orderConfirmation/orderConfirmation.php';
                $company = $this->person->getCompanyInfos();

                /**
                 * @var Order */
                $order = $this->person->getLastOrder();
                // $address = $this->person->getSelectedAddress();
                $datasViewMap = new Map();
                $datasViewMap->put($toName, Map::name);
                $datasViewMap->put($toEmail, Map::email);
                $datasViewMap->put($templateFile, Map::templateFile);
                $datasViewMap->put($company, Map::company);
                $datasViewMap->put($firstname, Map::firstname);
                $datasViewMap->put($lastname, Map::lastname);
                $datasViewMap->put($order, Map::order);
                // $datasViewMap->put($address, Map::address);
                try {
                    $this->sendEmail($response, $this->person, BlueAPI::class, BlueAPI::FUNC_ORDER_CONFIRM, $datasViewMap);
                    $order->getBasketOrdered()->empty($response);
                } catch (\Throwable $th) {
                    $response->addError($th->__toString(), MyError::ADMIN_ERROR);
                }
                break;
        }
        (!$response->containError()) ? $response->addResult(self::ACTION_STRIPEWEBHOOK, true) : null;
        $this->generateJsonView([], $response, $this->person);
    }
}
