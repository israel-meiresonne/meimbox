<?php
require_once 'model/library/payement/stripe-php/init.php';
require_once 'model/orders-management/payement/stripe/CheckoutSession.php';

require_once 'framework/Configuration.php';
require_once 'model/ModelFunctionality.php';
require_once 'model/boxes-management/Basket.php';
require_once 'model/boxes-management/Box.php';
require_once 'model/boxes-management/BasketProduct.php';
require_once 'model/boxes-management/BoxProduct.php';
require_once 'model/special/Map.php';
require_once 'model/special/Response.php';
require_once 'model/tools-management/Cookie.php';
require_once 'model/view-management/Translator.php';
/**
 * This class used as a facade and provide an access to the Stripe's API
 */
class StripeAPI extends ModelFunctionality
{
    /**
     * Holds Client that holds the checkoutSession
     * @var Client
     */
    private $client;

    /**
     * Holds contact with Stripe's api
     * @var \Stripe\StripeClient
     */
    private static $stripeAPI;

    /**
     * Holds Stripe's checkout session
     * @var CheckoutSession
     */
    private static $checkoutSession;

    /**
     * Holds Stripe's event accurd if there is one
     * @var CheckoutSession
     */
    private static $event;

    /**
     * Holds type of event
     * @var string
     */
    public const EVENT_CHECKOUT_COMPLETED = "checkout.session.completed";


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
        self::$checkoutSession = new CheckoutSession($stripeAPI);
        self::$checkoutSession->create($payMethod, $client);
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
     * To get the access to Stripe's API
     * @return \Stripe\StripeClient access to Stripe's API
     */
    private function getStripeAPI()
    {
        // (!isset(self::$stripeAPI)) ? $this->setApiKey() : null;
        return self::$stripeAPI;
    }

    /**
     * To get the Stripe event accured
     * @return string|null the Stripe event accured
     */
    public function getEvent()
    {
        return self::$event;
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
                // case 'checkout.session.completed':
            case self::EVENT_CHECKOUT_COMPLETED:
                $client = $this->getClient();
                $stripeAPI = $this->getStripeAPI();
                self::$event = $event->type;
                self::$checkoutSession = new CheckoutSession($stripeAPI);
                self::$checkoutSession->handleEvent($event);
                break;
            default:
                echo 'Received unknown event type ' . $event->type;
        }
        http_response_code(200);
    }
}
