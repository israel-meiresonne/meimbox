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
        /**
         * @var User */
        $person = $this->person;
        $address = $person->getSelectedAddress();
        if (empty($address)) {
            $this->redirect($this->extractController(get_class($this)), self::ACTION_ADDRESS);
        }
        $datasView = [
            "address" => $address
        ];
        $this->generateView($datasView, $person);
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
        /**
         * @var User */
        $person = $this->person;
        $datasView = [];
        if (!Query::existParam(Address::KEY_ADRS_SEQUENCE)) {
            $response->addErrorStation("ER1", MyError::FATAL_ERROR);
        } else {
            $sequence =  Query::getParam(Address::KEY_ADRS_SEQUENCE);
            $person->selectAddress($response, $sequence);
            if (!$response->containError()) {
                $response->addResult(self::QR_SELECT_ADRS, self::CTR_NAME);
            }
        }
        $this->generateJsonView($datasView, $response, $person);
    }

    /**
     * To create a new checkoutSession and get its id
     */
    public function getSessionId()
    {
        $response = new Response();
        /**
         * @var User */
        $person = $this->person;
        $datasView = [];
        if (!Query::existParam(CheckoutSession::KEY_STRP_MTD)) {
            $response->addErrorStation("ER1", MyError::FATAL_ERROR);
        } else {
            $payMethod = Query::getParam(CheckoutSession::KEY_STRP_MTD);
            $sessionId = $person->createNewCheckout($response, $payMethod);
            if (!$response->containError()) {
                $response->addResult(self::QR_NW_CHCKT_SS, $sessionId);
            }
        }
        $this->generateJsonView($datasView, $response, $person);
    }

    /*———————————————————————————— REQUEST UP —————————————————————————————————*/
    /*———————————————————————————— ROOT DOWN ——————————————————————————————————*/

    /**
     * To root Controller
     */
    public function rootController()
    {
        $ctrClass = get_class($this);
        $action = $this->getAction();
        switch ($action) {
            case ControllerCheckout::ACTION_INDEX:
                if (!$this->person->hasCookie(Cookie::COOKIE_CLT)) {
                    $ctr = $this->extractController($ctrClass);
                    $this->redirect($ctr, ControllerCheckout::ACTION_SIGN);
                } else if (!$this->person->hasCookie(Cookie::COOKIE_ADRS)) {
                    $ctr = $this->extractController($ctrClass);
                    $this->redirect($ctr, ControllerCheckout::ACTION_ADDRESS);
                }
                break;
            case ControllerCheckout::ACTION_ADDRESS:
                if (!$this->person->hasCookie(Cookie::COOKIE_CLT)) {
                    $ctr = $this->extractController($ctrClass);
                    $this->redirect($ctr, ControllerCheckout::ACTION_SIGN);
                }
                break;
            case ControllerCheckout::ACTION_SIGN:
                if ($this->person->hasCookie(Cookie::COOKIE_CLT)) {
                    $ctr = $this->extractController($ctrClass);
                    $this->redirect($ctr);
                }
                break;
            default:
                if (!method_exists($this, $action)) {
                    throw new Exception("Unknow action '$action' in controller '$ctrClass'");
                }
                break;
        }
    }
}
