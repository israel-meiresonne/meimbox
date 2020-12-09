<?php
require_once 'ControllerSecure.php';
// require_once 'model/tools-management/mailers/BlueAPI/BlueAPI.php';

class ControllerCheckout extends ControllerSecure
{

    /**
     * Holds actions function
     */
    // public const CTR_NAME = "checkout";

    /**
     * Holds actions function
     */
    public const ACTION_INDEX = "index";
    public const ACTION_SIGN = "sign";
    public const ACTION_ADDRESS = "address";
    public const ACTION_SUCCESS = "success";

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
        $person = $this->getPerson();
        $address = $person->getSelectedAddress();
        $basket = $person->getBasket();
        $response = new Response();
        $deleted = $basket->deleteEmptyBoxes($response);
        // (!empty($haveDelete)) ? $response->addResultStation(Response::RSP_NOTIFICATION, "US69") : null;

        $datasView = [
            "address" => $address,
            "deletedBoxesStation" => (($deleted) ? "US69" : null)
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
        $person = $this->getPerson();
        $person->destroyCookie(Cookie::COOKIE_CHKT_LNCHD, true);
        $datas = [
            "btnLink" => self::extractController(ControllerDashboard::class) . "/" . ControllerDashboard::ACTION_ORDERS
        ];
        $this->generateView($datas, $person, self::ACTION_SUCCESS);
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
        $person = $this->getPerson();
        $datasView = [];
        if (!Query::existParam(Address::KEY_ADRS_SEQUENCE)) {
            $response->addErrorStation("ER1", MyError::FATAL_ERROR);
        } else {
            $sequence =  Query::getParam(Address::KEY_ADRS_SEQUENCE);
            $person->selectAddress($response, $sequence);
            if (!$response->containError()) {
                $ctrName = self::extractController(ControllerCheckout::class);
                $response->addResult(self::QR_SELECT_ADRS, $ctrName);

                $eventDatasMap = new Map();
                $eventDatasMap->put($sequence, Address::KEY_ADRS_SEQUENCE);
                $eventCode = "evt_cd_28";
                $person->handleEvent($eventCode, $eventDatasMap);
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
        $person = $this->getPerson();
        $datasView = [];
        if (!Query::existParam(CheckoutSession::KEY_STRP_MTD)) {
            $response->addErrorStation("ER1", MyError::FATAL_ERROR);
        } else {
            $payMethod = Query::getParam(CheckoutSession::KEY_STRP_MTD);
            $sessionId = $person->createNewCheckout($response, $payMethod);
            if (!$response->containError()) {
                $response->addResult(self::QR_NW_CHCKT_SS, $sessionId);

                $eventDatasMap = new Map();
                $eventDatasMap->put($sessionId, CheckoutSession::KEY_SESSION_ID);
                $eventCode = "evt_cd_32";
                $person->handleEvent($eventCode, $eventDatasMap);
            }
        }
        $this->generateJsonView($datasView, $response, $person);
    }

    /*———————————————————————————— REQUEST UP —————————————————————————————————*/
    /*———————————————————————————— CONTROLLER_SECURE DOWN —————————————————————*/

    /**
     * To root Controller
     */
    public function rootController()
    {
        /**
         * @var User */
        $person = $this->person;
        $ctrClass = get_class($this);
        $action = $this->getAction();
        // $this->debug();
        switch ($action) {
            case ControllerCheckout::ACTION_INDEX:
                if (!$person->hasCookie(Cookie::COOKIE_CLT)) {
                    $ctr = self::extractController($ctrClass);
                    $this->redirect($ctr, ControllerCheckout::ACTION_SIGN);
                } else if ((!$person->hasCookie(Cookie::COOKIE_ADRS)) || empty($person->getSelectedAddress())) {
                    $ctr = self::extractController($ctrClass);
                    $this->redirect($ctr, ControllerCheckout::ACTION_ADDRESS);
                }
                break;
            case ControllerCheckout::ACTION_SIGN:
                if ($person->hasCookie(Cookie::COOKIE_CLT)) {
                    $ctr = self::extractController($ctrClass);
                    $this->redirect($ctr);
                }
                break;
            case ControllerCheckout::ACTION_ADDRESS:
                if (!$person->hasCookie(Cookie::COOKIE_CLT)) {
                    $ctr = self::extractController($ctrClass);
                    $this->redirect($ctr, ControllerCheckout::ACTION_SIGN);
                }
                break;
            case ControllerCheckout::ACTION_SUCCESS:
                if (!$person->hasCookie(Cookie::COOKIE_CHKT_LNCHD)) {
                    $ctr = self::extractController($ctrClass);
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

    // private function debug()
    // {
    //     $hasCLT = $this->person->hasCookie(Cookie::COOKIE_CLT);
    //     $ctr = $this->extractController(get_class($this));
    //     $action = $this->getAction();
    //     var_dump("action: $action");
    //     echo "<hr>";
    //     var_dump("hasCLT:", $hasCLT);
    //     echo "<hr>";
    //     var_dump("ctr: $ctr");
    //     echo "<hr>";
    //     var_dump($_SESSION);
    //     echo "<hr>";
    //     var_dump($_SERVER);
    // }
}
