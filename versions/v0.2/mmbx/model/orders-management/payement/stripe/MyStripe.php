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

class MyStripe extends ModelFunctionality
{
    /**
     * Holds contact with Stripe's api
     * @var \Stripe\StripeClient
     */
    private static $stripe;

    /**
     * Holds holds Stripe's checkout session
     * @var CheckoutSession
     */
    private $checkoutSession;

    /**
     * Holds the payement method to process
     * @var string
     */
    private $payMethod;

    /**
     * Holds path where redirect Client if he click on the cancel button
     * @var string
     */
    private $domain;

    /**
     * Holds path where redirect Client if he click on the cancel button
     * @var string
     */
    private $cancelPath;

    /**
     * Holds the path where to redirect Client when the payement succed
     * @var string
     */
    private $successPath;

    /**
     * Holds Client that holds the checkoutSession
     * @var Client
     */
    private $client;

    /**
     * Holds Client's currency
     * @var string
     */
    private $currency;

    /**
     * Holds Client's basket to checkout
     * @var string
     */
    private $basket;

    private const CHECKOUT_MODE_PAYEMENT = "payment";
    private const CHECKOUT_MODE_SUBSRIPTIOM = "subscription";
    private const CHECKOUT_MODE_SETUP = "setup";

    /**
     * Holds max images for StripeProduct
     */
    private const STRP_PROD_MAX_IMG = 8;

    /**
     * Key for attribut
     */
    public const KEY_STRP_MTD = "key_strp_mtd";

    /**
     * Constructor
     */
    public function __construct()
    {
        $sk = Configuration::get(Configuration::STRIPE_SK);
        self::$stripe = new \Stripe\StripeClient($sk);

        // $payementMap = $this->getPayementMap();
        // $payIDs = $payementMap->getKeys();
        // $payID = null;
        // foreach ($payIDs as $mapPayID) {
        //     if (in_array($payMethod, $payementMap->get($mapPayID))) {
        //         $payID = $mapPayID;
        //         break;
        //     }
        // }
        // if (empty($payID)) {
        //     throw new Exception("This payement method ('$payMethod') is not supported");
        // }
        // $this->client = $client;
        // $basket = $this->client->getBasket();
        // if ($basket->getQuantity() <= 0) {
        //     throw new Exception("Basket can't be empty");
        // }
        // $this->payMethod = $payementMap->get($payID, Map::payMethod);
        // $this->cancelPath = $payementMap->get($payID, Map::cancelPath);
        // $this->successPath = $payementMap->get($payID, Map::successPath);
        // $this->domain = Configuration::get(Configuration::URL_PROTOCOL);
        // $this->setCheckoutSession();
    }

    // /**
    //  * To set acces to Stripe's API
    //  */
    // private  function setApiKey()
    // {
    //     $sk = Configuration::get(Configuration::STRIPE_SK);
    //     // \Stripe\Stripe::setApiKey('sk_test_4eC39HqLyjWDarjtT1zdp7dc');
    //     // \Stripe\Stripe::setApiKey($sk);
    //     self::$stripe = new \Stripe\StripeClient($sk);
    // }

    /**
     * To initialize the CheckoutSession
     * @param string $payMethod payement method like [card, bancontact, ideal, etc...]
     * @param Client $client Client that holds the CheckoutSession
     */
    public function initializeNewCheckout(string $payMethod, Client $client)
    {
        $payementMap = $this->getPayementMap();
        $payIDs = $payementMap->getKeys();
        $payID = null;
        foreach ($payIDs as $mapPayID) {
            if (in_array($payMethod, $payementMap->get($mapPayID))) {
                $payID = $mapPayID;
                break;
            }
        }
        if (empty($payID)) {
            throw new Exception("This payement method ('$payMethod') is not supported");
        }
        $this->client = $client;
        $basket = $this->client->getBasket();
        if ($basket->getQuantity() <= 0) {
            throw new Exception("Basket can't be empty");
        }
        $this->payMethod = $payementMap->get($payID, Map::payMethod);
        $this->cancelPath = $payementMap->get($payID, Map::cancelPath);
        $this->successPath = $payementMap->get($payID, Map::successPath);
        $this->domain = Configuration::get(Configuration::URL_PROTOCOL);
        $this->setCheckoutSession();
    }

    /**
     * To set the Stripe Checkout Session
     * @param Basket $basket Client's basket to checkout
     */
    private function setCheckoutSession()
    {
        /** NOTE metadat contraints
         * - max 50 keys
         * - key max 40 characters 
         * - value max 500 characters 
         */
        $stripe = $this->getStripe();
        $client = $this->getClient();
        $basket = $client->getBasket();
        $webRoot = Configuration::getWebRoot();
        $domain = $this->getDomain();
        $success_url = $domain . $webRoot . $this->getsuccessPath();
        $cancel_url = $domain  . $webRoot . $this->getcancelPath();
        // $payment_method_types = $this->getPayMethod();
        $line_items = $this->extractLineItems($basket);
        $payementIntent = $this->extractPayementIntent();

        $datas["payment_method_types"] = [$this->getPayMethod()]; // 'payment_method_types' => ['card']
        $datas["client_reference_id"] = $client->getUserID();
        $custoID = $client->getCustoIDStripe();
        if(!empty($custoID)){
            $datas["customer"] = $custoID;
        } else {
            $datas["customer_email"] = $client->getEmail();
        }
        $datas["line_items"] = $line_items;
        // $datas["metadata"] = $metadata;
        $datas["payment_intent_data"] = $payementIntent;
        $datas["mode"] = self::CHECKOUT_MODE_PAYEMENT;
        $datas["success_url"] = $success_url;
        $datas["cancel_url"] = $cancel_url;

        $stripeSession = $stripe->checkout->sessions->create($datas);
        $userID = $client->getUserID();
        // $payMethod = $this->getPayMethod();
        $this->checkoutSession = new CheckoutSession($stripeSession, $userID);
        // $this->checkoutSession = $stripe->checkout->sessions->create([
        //     //   'payment_method_types' => ['card'],
        //     'payment_method_types' => [$this->getPayMethod()],
        //     'client_reference_id' => $client->getUserID(),
        //     // 'customer' => $client->getCustoIDStripe(),
        //     'customer_email' => $client->getEmail(),
        //     'line_items' => $line_items,
        //     // 'metadata' => $metadata,
        //     'payment_intent_data' => $payementIntent,
        //     'mode' => self::CHECKOUT_MODE_PAYEMENT,
        //     'success_url' => $success_url,
        //     'cancel_url' => $cancel_url
        // ]);
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
     * To get CheckoutSession's payement method
     * @return string CheckoutSession's payement method
     */
    private function getPayMethod()
    {
        return $this->payMethod;
    }

    /**
     * To get the domain
     * @return string the domain
     */
    private function getDomain()
    {
        return $this->domain;
    }

    /**
     * To get CheckoutSession's cancel path
     * @return string CheckoutSession's cancel path
     */
    private function getcancelPath()
    {
        return $this->cancelPath;
    }

    /**
     * To get CheckoutSession's success path
     * @return string CheckoutSession's success path
     */
    private function getsuccessPath()
    {
        return $this->successPath;
    }

    /**
     * To get the Client that holds the CheckoutSession
     * @return User Client that holds the CheckoutSession
     */
    private function getClient()
    {
        return $this->client;
    }

    // /**
    //  * To get CheckoutSession's currency
    //  * @return Currency CheckoutSession's currency
    //  */
    // public function getCurrency()
    // {
    //     return $this->currency;
    // }

    // /**
    //  * To get CheckoutSession's basket
    //  * @return Basket CheckoutSession's basket
    //  */
    // public function getBasket()
    // {
    //     return $this->basket;
    // }

    /**
     * To builds CheckoutSession's attribut line_items
     * @param Basket $basket Client's basket to checkout
     * @return string[] CheckoutSession's attribut line_items
     */
    private function extractLineItems(Basket $basket)
    {
        $line_items = [];
        $merged = $basket->getMerge();
        foreach ($merged as $element) {
            switch (get_class($element)) {
                case BasketProduct::class:
                    $stripeProduct = $this->extractProduct($element);
                    array_push($line_items, $stripeProduct);
                    break;
                case Box::class:
                    $line_items = $this->extractBox($element, $line_items);
                    // array_push($line_items, $stripeProduct);
                    break;
                default:
                    throw new Exception("Unknown type of element in basket, element: $element");
                    break;
            }
        }
        return $line_items;
    }

    /**
     * To extract payement intent datas
     * @return string[] payement intent datas
     */
    private function extractPayementIntent()
    {
        $client = $this->getClient();
        $address = $client->getSelectedAddress();
        if (empty($address)) {
            throw new Exception("Selected address can't be empty");
        }
        $payementIntent["shipping"]["address"]["line1"] = $address->getAddress();
        $payementIntent["shipping"]["address"]["city"] = $address->getCity();
        $payementIntent["shipping"]["address"]["country"] = $address->getCountry()->getIsoCountry();       // isoCountry
        $apartment = $address->getAppartement();
        if (!empty($apartment)) {
            $payementIntent["shipping"]["address"]["line2"] = $apartment;     // apartment, suite, unit, or building
        }
        $payementIntent["shipping"]["address"]["postal_code"] = $address->getZipcode();
        $payementIntent["shipping"]["address"]["state"] = $address->getProvince();
        $payementIntent["shipping"]["name"] = $client->getLastname();     // user's lastname
        $phone = $address->getPhone();
        if (!empty($phone)) {
            $payementIntent["shipping"]["phone"] = $phone;
        }
        // $payementIntent["shipping"]["carrier"] = ;  // Fedex, UPS, USPS, etc.
        // $payementIntent["shipping"]["tracking_number"] = ;  // If multiple tracking numbers were generated for this purchase, please separate them with commas.
        return $payementIntent;

        // $payementIntent = [
        //     "address" => [
        //         "line1" => ,
        //         "city" => ,
        //         "country" => $isoCountry,
        //         "line2" => $appart, // apartment, suite, unit, or building
        //         "postal_code" => $zipCode,
        //         "state" => $province,
        //     ],
        //     "name" => , // user's lastname
        //     "phone" => ,
        //     // "carrier" => , // Fedex, UPS, USPS, etc.
        //     // "tracking_number" => , // If multiple tracking numbers were generated for this purchase, please separate them with commas.
        // ];
    }

    /**
     * Convert Product to a StripeProduct
     * @param BasketProduct|BoxProduct $product product to convert into StripeProduct
     * @return string[] Stripe product
     */
    private function extractProduct(Product $product)
    {
        $prodDatas = new Map();
        $client = $this->getClient();
        $prodDatas->put($product->getProdName(), Map::name);
        $prodDatas->put($client->getCurrency(), Map::currency);
        $prodDatas->put($product->getPrice(), Map::unit_amount);
        $prodDatas->put($product->getDescription(), Map::description);
        $prodDatas->put($product->getPictureSources(), Map::images);
        $prodDatas->put($product->getQuantity(), Map::quantity);
        return $this->buildStripeProduct($prodDatas);
    }

    /**
     * Convert Box into StripeProduct
     * @param Box $box the box to conver
     * @param string[] $line_items where to push box converted
     * @return string[] $line_items
     */
    private function extractBox(Box $box, array $line_items)
    {
        $products = $box->getBoxProducts();
        if (!empty($products)) {
            $boxDatas = new Map();
            $client = $this->getClient();
            $boxDatas->put($box->getColor(), Map::name);
            $boxDatas->put($client->getCurrency(), Map::currency);
            $boxDatas->put($box->getPrice(), Map::unit_amount);
            $boxDatas->put(null, Map::description);
            $boxDatas->put([$box->getPictureSource()], Map::images);
            $boxDatas->put(1, Map::quantity);
            $stripeProduct = $this->buildStripeProduct($boxDatas);
            array_push($line_items, $stripeProduct);
            foreach ($products as $product) {
                $stripeProduct = $this->extractProduct($product);
                array_push($line_items, $stripeProduct);
            }
        }
        return $line_items;
    }

    /**
     * Builds a StripeProduct with Map given
     * @param Map $datas necessary to build a StripeProduct
     * + $datas[Map::name]  {string}
     * + $datas[Map::currency]  {Currency}
     * + $datas[Map::unit_amount]  {Price}
     * + $datas[Map::description]  {string}
     * + $datas[Map::images]  {string[]}
     * + $datas[Map::quantity]  {int}
     */
    private function buildStripeProduct(Map $datas)
    {
        $imgSrcs = $datas->get(Map::images);
        $imgLinks = [];
        $nb = 0;
        // $domain = Configuration::get(Configuration::DOMAIN) . Configuration::getWebRoot();
        $domain = $this->getDomain() . Configuration::getWebRoot();
        foreach ($imgSrcs as $imgSrc) {
            if ($nb < self::STRP_PROD_MAX_IMG) {
                $imgLink = $domain . $imgSrc;
                array_push($imgLinks, $imgLink);
            } else {
                break;
            }
            $nb++;
        }
        $stripProduct["price_data"]["currency"] = $datas->get(Map::currency)->getIsoCurrency();
        $stripProduct["price_data"]["unit_amount"] = $datas->get(Map::unit_amount)->getPriceRounded() * 100;
        $stripProduct["price_data"]["product_data"]["name"] = $datas->get(Map::name);
        $description = $datas->get(Map::description);
        if (!empty($description)) {
            $stripProduct["price_data"]["product_data"]["description"] = $description;
            $stripProduct["description"] = $description;
        }
        $stripProduct["price_data"]["product_data"]["images"] = $imgLinks;           // max 8 url
        // $stripProduct["price_data"]["product_data"]["metadata"] = ;
        $stripProduct["quantity"] = $datas->get(Map::quantity);
        return $stripProduct;
    }
}
