<?php
require_once 'ControllerSecure.php';
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
     * 
     */
    public function stripeWebhook()
    {
        $payload = @file_get_contents('php://input');
        $event = null;

        try {
            $event = \Stripe\Event::constructFrom(
                json_decode($payload, true)
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
            exit();
        }

        // Handle the event
        switch ($event->type) {
            case 'payment_intent.succeeded':
                $paymentIntent = $event->data->object; // contains a \Stripe\PaymentIntent
                // Then define and call a method to handle the successful payment intent.
                // handlePaymentIntentSucceeded($paymentIntent);
                break;
            case 'payment_method.attached':
                $paymentMethod = $event->data->object; // contains a \Stripe\PaymentMethod
                // Then define and call a method to handle the successful attachment of a PaymentMethod.
                // handlePaymentMethodAttached($paymentMethod);
                break;
                // ... handle other event types
            default:
                echo 'Received unknown event type ' . $event->type;
        }

        http_response_code(200);
    }
}
