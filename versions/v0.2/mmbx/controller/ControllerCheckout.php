<?php
require_once 'ControllerSecure.php';
require_once 'model/orders-management/payement/stripe/MyStripe.php';
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
        $address = $this->person->getSelectedAddress();
        if(empty($address)){
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
     * To select an shipping address
     */
    public function selectAddress()
    {
        $response = new Response();
        $datasView = [];
        if(!Query::existParam(Address::KEY_ADRS_SEQUENCE)){
            $response->addErrorStation("ER1", MyError::FATAL_ERROR);
        } else {
            $sequence =  Query::getParam(Address::KEY_ADRS_SEQUENCE);
            $this->person->selectAddress($response, $sequence);
            if(!$response->containError()){
                $response->addResult(self::QR_SELECT_ADRS, self::CTR_NAME);
            }
        }
        $this->generateJsonView($datasView, $response, $this->person);
    }

    public function getSessionId()
    {
        $response = new Response();
        $datasView = [];
        if(!Query::existParam(MyStripe::KEY_STRP_MTD)){
            $response->addErrorStation("ER1", MyError::FATAL_ERROR);
        } else {
            $payMethod = Query::getParam(MyStripe::KEY_STRP_MTD);
            try {
                $myStripe= new MyStripe();
                $myStripe->initializeNewCheckout($payMethod, $this->person);
            } catch (\Throwable $th) {
                $response->addError($th->getMessage(), MyStripe::KEY_STRP_MTD);
            }
            if(!$response->containError()){
                $sessionId = $myStripe->getCheckoutSessionId();
             $response->addResult(MyStripe::KEY_STRP_MTD, $sessionId); 
            }
            
        }
        $this->generateJsonView($datasView, $response, $this->person);
    }
}
