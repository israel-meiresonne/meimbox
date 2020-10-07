<?php
require_once 'framework/Configuration.php';
require_once 'model/library/payement/stripe-php/init.php';
require_once 'model/ModelFunctionality.php';
require_once 'model/boxes-management/Basket.php';
require_once 'model/boxes-management/Box.php';
require_once 'model/boxes-management/BasketProduct.php';
require_once 'model/boxes-management/BoxProduct.php';
require_once 'model/special/Map.php';
require_once 'model/orders-management/payement/stripe/CheckoutSession.php';

/**
 * This class provide an access to the Stripe's API
 */
class StripeAPI extends ModelFunctionality
{
    /**
     * Holds contact with Stripe's api
     * @var \Stripe\StripeClient
     */
    private static $stripeAPI;

    /**
     * Holds Client that holds the checkoutSession
     * @var Client
     */
    private $client;

    /**
     * Holds holds Stripe's checkout session
     * @var CheckoutSession
     */
    private static $checkoutSession;

    /**
     * Constructor
     */
    public function __construct()
    {
        if (!isset(self::$stripeAPI)) {
            $sk = Configuration::get(Configuration::STRIPE_SK);
            self::$stripeAPI = new \Stripe\StripeClient($sk);
        }
    }

    /**
     * To initialize the CheckoutSession
     * @param string $payMethod payement method like [card, bancontact, ideal, etc...]
     * @param Client $client Client that holds the CheckoutSession
     */
    public function initializeNewCheckout(string $payMethod, Client $client)
    {
        $this->client = $client;
        $this->createCheckoutSession($payMethod);
    }

    /**
     * To set the Stripe Checkout Session
     * @param string $payMethod payement method like [card, bancontact, ideal, etc...]
     */
    private function createCheckoutSession(string $payMethod)
    {
        $stripeAPI = $this->getStripeAPI();
        $client = $this->getClient();
        self::$checkoutSession = new CheckoutSession();
        self::$checkoutSession->create($stripeAPI, $client, $payMethod);
    }

    /**
     * To get the access to Stripe's API
     * @return \Stripe\StripeClient access to Stripe's API
     */
    private function getStripeAPI()
    {
        // (!isset(self::$stripeAPI)) ? $this->setApiKey() : null;
        return self::$stripeAPI;
    }

    /**
     * To get CheckoutSession's id
     * @return string CheckoutSession's id
     */
    public  function getCheckoutSessionId()
    {
        return self::$checkoutSession->getSessionID();
    }

    /**
     * To get CheckoutSession's attribut metadatas
     * @return string[] CheckoutSession's attribut metadatas
     */
    public function getCheckoutSessionMetaDatas()
    {
        if (!isset(self::$checkoutSession)) {
            throw new Exception("Can't get CheckoutSession's metadats because CheckoutSession is not setted");
        }
        return self::$checkoutSession->getMetaDatas();
    }

    /**
     * To get the Client that holds the CheckoutSession
     * @return User Client that holds the CheckoutSession
     */
    private function getClient()
    {
        return $this->client;
    }

    /**
     * To handle Stripe's events
     */
    public function handleEvents()
    {
        // $stripeAPI = $this->getStripeAPI();

        // If you are testing your webhook locally with the Stripe CLI you
        // can find the endpoint's secret by running `stripe listen`
        // Otherwise, find your endpoint's secret in your webhook settings in the Developer Dashboard
        $endpoint_secret = Configuration::get(Configuration::STRIPE_WEBHOOK);

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;
        try {
            // $stripeAPI->webhook->constructEvent(
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
            exit();
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            http_response_code(400);
            exit();
        }

        // Handle the event
        switch ($event->type) {
            case 'checkout.session.completed':
                self::$checkoutSession = new CheckoutSession();
                self::$checkoutSession->retreive($event);
                break;
            default:
                echo 'Received unknown event type ' . $event->type;
        }
        http_response_code(200);
    }
}
