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

class StripeAPI extends ModelFunctionality
{
    /**
     * Holds contact with Stripe's api
     * @var \Stripe\StripeClient
     */
    private static $stripe;

    /**
     * Holds Client that holds the checkoutSession
     * @var Client
     */
    private $client;

    /**
     * Holds holds Stripe's checkout session
     * @var CheckoutSession
     */
    private $checkoutSession;

    /**
     * Constructor
     */
    public function __construct()
    {
        $sk = Configuration::get(Configuration::STRIPE_SK);
        self::$stripe = new \Stripe\StripeClient($sk);
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
        $stripe = $this->getStripe();
        $client = $this->getClient();
        $this->checkoutSession = new CheckoutSession();
        $this->checkoutSession->create($stripe, $client, $payMethod);
    }

    /**
     * To get the access to Stripe's API
     * @return \Stripe\StripeClient access to Stripe's API
     */
    private function getStripe()
    {
        // (!isset(self::$stripe)) ? $this->setApiKey() : null;
        return self::$stripe;
    }

    /**
     * To get CheckoutSession's id
     * @return string CheckoutSession's id
     */
    public  function getCheckoutSessionId()
    {
        return $this->checkoutSession->getId();
    }

    /**
     * To get the Client that holds the CheckoutSession
     * @return User Client that holds the CheckoutSession
     */
    private function getClient()
    {
        return $this->client;
    }
}
