<?php
require_once 'model/API/Stripe/StripeCoupon.php';

class CheckoutSession extends ModelFunctionality
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
     * Holds holds Stripe's checkout session
     * @var \Stripe\Checkout\Session
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
     * holds the creation date of the CheckoutSession
     * @var string
     */
    private $setDate;


    private const CHECKOUT_MODE_PAYEMENT = "payment";
    private const CHECKOUT_MODE_SUBSRIPTIOM = "subscription";
    private const CHECKOUT_MODE_SETUP = "setup";

    /**
     * Key for attribut
     */
    public const KEY_STRP_MTD = "key_strp_mtd";
    public const KEY_SESSION_ID = "key_strp_session_id";

    /**
     * Holds image for shipping cost
     */
    private const SHIPPING_IMG = "delivery.png";

    /**
     * Holds max images for StripeProduct
     * @var int
     */
    private static $STRIPE_MAX_PROD_IMG;

    /**
     * Constructor
     * @param \Stripe\StripeClient $stripe access to the stripe API
     */
    public function __construct(\Stripe\StripeClient $stripeAPI)
    {
        $this->setConstants();
        self::$stripeAPI = $stripeAPI;
    }

    /**
     * Initialize CheckoutSession's constants
     */
    private function setConstants()
    {
        if (!isset(self::$STRIPE_MAX_PROD_IMG)) {
            self::$STRIPE_MAX_PROD_IMG = "STRIPE_MAX_PROD_IMG";
            self::$STRIPE_MAX_PROD_IMG = (int) $this->getConstantLine(self::$STRIPE_MAX_PROD_IMG)["stringValue"];
        }
    }

    /**
     * To create a new CheckoutSession
     * @param Client $client Client that holds the CheckoutSession
     */
    public function create(string $payMethod, Client $client)
    {
        $this->client = $client;
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
            throw new Exception("This payement method '$payMethod' with payID '$payID' is not supported");
        }
        $basket = $client->getBasket();
        if ($basket->getQuantity() <= 0) {
            throw new Exception("Basket can't be empty");
        }
        $this->payMethod = $payementMap->get($payID, Map::payMethod);
        $this->cancelPath = $payementMap->get($payID, Map::cancelPath);
        $this->successPath = $payementMap->get($payID, Map::successPath);
        $this->domain = Configuration::get(Configuration::URL_DOMAIN);

        $this->setCheckoutSession();
        $this->setDate = $this->getDateTime();
        $response = new Response();
        $userID = $client->getUserID();
        $this->insertCheckoutSession($response, $userID);
    }

    /**
     * To retreive CheckoutSession from Stripe's event
     * @param Stripe\Event $event event send by Stripee to the webhook
     */
    public function handleEvent(Stripe\Event $event)
    {
        // if ($event->type != 'checkout.session.completed') {
        if ($event->type != StripeAPI::EVENT_CHECKOUT_COMPLETED) {
            // throw new Exception("The Stripe Event to retreive is not of type 'checkout.session.completed', event->type:$event->type");
            throw new Exception("The Stripe Event to retreive is not of type '" . StripeAPI::EVENT_CHECKOUT_COMPLETED . "', event->type:" . $event->type);
        }
        $this->checkoutSession = $event->data->object;
        $response = new Response();
        $this->updateCheckoutSession($response);
    }

    /**
     * To create a new CheckoutSession
     * @param \Stripe\StripeClient $stripe access to the stripe API
     * @param Client $client Client that holds the CheckoutSession
     */
    // private function setCheckoutSession($stripe, Client $client)
    private function setCheckoutSession()
    {
        $stripeAPI = $this->getStripeAPI();
        $client = $this->getClient();
        /** NOTE metadat contraints
         * - max 50 keys
         * - key max 40 characters 
         * - value max 500 characters 
         * - must be in format [key => string]
         */
        $basket = $client->getBasket();
        $webRoot = Configuration::getWebRoot();
        $domain = $this->getDomain();
        $success_url = $domain . $webRoot . $this->getsuccessPath();
        $cancel_url = $domain  . $webRoot . $this->getcancelPath();

        $line_items = $this->extractLineItems($basket, $client->getCurrency());
        $payementIntent = $this->extractPayementIntent($client->getSelectedAddress(), $client->getLastname());

        $coupon = $this->createCoupon();

        $datas["payment_method_types"] = [$this->getPayMethod()]; // 'payment_method_types' => ['card']
        $datas["client_reference_id"] = $client->getUserID();
        $custoID = $client->getCustoIDStripe();
        if (!empty($custoID)) {
            $datas["customer"] = $custoID;
        } else {
            $datas["customer_email"] = $client->getEmail();
        }
        $datas["line_items"] = $line_items;
        $datas["metadata"][Cookie::COOKIE_CLT] = $client->getCookie(Cookie::COOKIE_CLT)->getValue();
        $datas["payment_intent_data"] = $payementIntent;
        $datas["mode"] = self::CHECKOUT_MODE_PAYEMENT;
        (!empty($coupon)) ? $datas["discounts"] = [['coupon' => $coupon->getId()]] : null;
        $datas["success_url"] = $success_url;
        $datas["cancel_url"] = $cancel_url;

        $this->checkoutSession = $stripeAPI->checkout->sessions->create($datas);
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
        return self::$stripeAPI;
    }

    /**
     * To get CheckoutSession's id
     * @return string CheckoutSession's id
     */
    public  function getSessionID()
    {
        return $this->checkoutSession->id;
    }

    /**
     * To get CheckoutSession's customer id
     * @return string|null CheckoutSession's id
     */
    public  function getCustomerID()
    {
        return $this->checkoutSession->customer;
    }

    /**
     * To get CheckoutSession's payement method
     * @return string CheckoutSession's payement method
     */
    public  function getPaymentMethod()
    {
        return $this->checkoutSession->payment_method_types[0];
    }

    /**
     * To get CheckoutSession's payement method
     * @return string CheckoutSession's payement method
     */
    public  function getPaymentStatus()
    {
        return $this->checkoutSession->payment_status;
    }

    /**
     * To get CheckoutSession's attribut metadatas
     * @return string[] CheckoutSession's attribut metadatas
     */
    public  function getMetaDatas()
    {
        return $this->checkoutSession->metadata;
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
     * To get translator
     * @return Translator translator
     */
    private function getTranslator()
    {
        if(!isset($this->translator)) {
            $language = $this->getClient()->getLanguage();
            $this->translator = new Translator($language);
        }
        return $this->translator;
    }

    /**
     * To get creation date of the CheckoutSession
     * @return string the creation date of the CheckoutSession
     */
    private function getSetDate()
    {
        return $this->setDate;
    }

    /**
     * To get the max images allowed in Stripe product
     * @return int
     */
    private function getSTRIPE_MAX_PROD_IMG()
    {
        return self::$STRIPE_MAX_PROD_IMG;
    }

    /**
     * To convert shipping discount into a Stripe coupon
     * @return StripeCoupon|null the shipping discount converted into a Stripe coupon
     */
    private function createCoupon()
    {
        $coupon = null;
        $stripeAPI = $this->getStripeAPI();
        $translator = $this->getTranslator();
        
        $basket = $this->getClient()->getBasket();
        $translator = $this->getTranslator();
        $discCodes = $basket->getDiscountCodes();
        $couponID = implode("-", array_keys($discCodes))."-".time();
        
        // $shipCouponID = DiscountCode::TYPE_SUM_PRODS."_".$couponSequence;
        $shipDiscount = $basket->getDiscountShipping();
        $sumProdDiscount = $basket->getDiscountSumProducts();
        $sum = $shipDiscount->getPrice() + $sumProdDiscount->getPrice();
        $finalDiscount = new Shipping($sum, $basket->getCurrency(), 0, 0);
        if($finalDiscount->getPrice() > 0){
            $nameSumProdDisc = $translator->translateStation("US116");//." ".$translator->translateStation("US118");
            $name = "";
            $name .= ($sumProdDiscount->getPrice() == $sum) ? $nameSumProdDisc: null;
            $name .= ($shipDiscount->getPrice() == $sum) ? $translator->translateStation("US115"): null;
            $name .= (empty($name)) ? $nameSumProdDisc." + ".$translator->translateStation("US115"): null;
            $couponMap = new Map();
            $couponMap->put($couponID, Map::id);
            $couponMap->put($name, Map::name);
            $couponMap->put(StripeCoupon::DURATION_ONCE, Map::duration);
            $coupon = new StripeCoupon($stripeAPI, $finalDiscount, $couponMap);
            $coupon->create();
        }
        return $coupon;
    }

    /**
     * To builds CheckoutSession's attribut line_items
     * @param Basket $basket Client's basket to checkout
     * @param Currency $currency Client's currency
     * @return string[] CheckoutSession's attribut line_items
     */
    private function extractLineItems(Basket $basket)
    {
        $line_items = [];
        $shipping = $this->extractShipping($basket->getShipping(), $basket->getLanguage());
        array_push($line_items, $shipping);
        $merged = $basket->getMerge();
        foreach ($merged as $element) {
            switch (get_class($element)) {
                case BasketProduct::class:
                    $stripeProduct = $this->extractProduct($element);
                    array_push($line_items, $stripeProduct);
                    break;
                case Box::class:
                    $line_items = $this->extractBox($element, $line_items);
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
     * @param Address $address Client's seleted shipping address
     * @param string $lastname Client's lastname
     * @return string[] payement intent datas
     */
    private function extractPayementIntent(Address $address, string $lastname)
    {
        // $client = $this->getClient();
        // $address = $client->getSelectedAddress();
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
        // $payementIntent["shipping"]["name"] = $client->getLastname();     // user's lastname
        $payementIntent["shipping"]["name"] = $lastname;     // user's lastname
        $phone = $address->getPhone();
        if (!empty($phone)) {
            $payementIntent["shipping"]["phone"] = $phone;
        }
        // $payementIntent["shipping"]["carrier"] = ;  // Fedex, UPS, USPS, etc.
        // $payementIntent["shipping"]["tracking_number"] = ;  // If multiple tracking numbers were generated for this purchase, please separate them with commas.
        return $payementIntent;
    }

    /**
     * To convert shipping cost into a StripeProduct
     * @param Shipping $price total shipping cost
     * @param Currency $language Client's language
     * @return string[] Stripe product
     */
    private function extractShipping(Shipping $shipping, Language $language)
    {
        $shipMap = new Map();
        // $translator  = new Translator($language);
        $translator  = $this->getTranslator();
        $description = ($shipping->getPrice() == 0) ? $translator->translateStation("US67") : null;
        $images = [Configuration::get(Configuration::DIR_STATIC_FILES) . self::SHIPPING_IMG];
        $shipMap->put($translator->translateStation("US66"), Map::name);
        $shipMap->put($shipping->getCurrency(), Map::currency);
        $shipMap->put($shipping, Map::unit_amount);
        $shipMap->put($description, Map::description);
        $shipMap->put($images, Map::images);
        $shipMap->put(1, Map::quantity);
        return $this->buildStripeProduct($shipMap);
    }

    /**
     * Convert Product to a StripeProduct
     * @param BasketProduct|BoxProduct $product product to convert into StripeProduct
     * @param Currency $currency Client's currency
     * @return string[] Stripe product
     */
    private function extractProduct(Product $product)
    {
        $prodDatas = new Map();
        $price = $product->getPrice();
        $prodDatas->put($product->getProdName(), Map::name);
        $prodDatas->put($price->getCurrency(), Map::currency);
        $prodDatas->put($price, Map::unit_amount);
        $prodDatas->put($product->getDescription(), Map::description);
        $prodDatas->put($product->getPictureSources(), Map::images);
        $prodDatas->put($product->getQuantity(), Map::quantity);
        return $this->buildStripeProduct($prodDatas);
    }

    /**
     * Convert Box into StripeProduct
     * @param Box $box the box to conver
     * @param string[] $line_items where to push box converted
     * @param Currency $currency Client's currency
     * @return string[] $line_items
     */
    private function extractBox(Box $box, array $line_items)
    {
        $products = $box->getProducts();
        if (!empty($products)) {
            $boxDatas = new Map();
            $price = $box->getPrice();
            $boxDatas->put($box->getColor(), Map::name);
            $boxDatas->put($price->getCurrency(), Map::currency);
            $boxDatas->put($price, Map::unit_amount);
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
        $MAX_IMG = $this->getSTRIPE_MAX_PROD_IMG();
        foreach ($imgSrcs as $imgSrc) {
            if ($nb < $MAX_IMG) {
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

    /*———————————————————————————— SCRUD DOWN ———————————————————————————————*/

    /**
     * To insert in db a CheckoutSession
     * @param Response $response to push in results or accured errors
     * @param string $userID id of the Client Attempting to pay
     * @param string $payMethod payement method like [card, bancontact, ideal, etc...]
     */
    private function insertCheckoutSession(Response $response, $userID)
    {
        // $client = $this->getClient();
        $bracket = "(?,?,?,?,?,?,?)";  // regex \[value-[0-9]*\]
        $sql = "INSERT INTO `StripeCheckoutSessions`(`sessionID`, `payId`, `userId`, `iso_currency`, `custoID`, `payStatus`, `setDate`) 
                VALUES " . $this->buildBracketInsert(1, $bracket);
        $values = [];
        array_push(
            $values,
            $this->getSessionID(),
            $this->getPaymentMethod(),     // with Stripe the payId = payMeth
            $userID,
            $this->getClient()->getCurrency()->getIsoCurrency(),
            $this->getCustomerID(),
            $this->getPaymentStatus(),
            $this->getSetDate()
        );
        $this->insert($response, $sql, $values);
    }

    /**
     * To update Client's Stripe customer ID and payement status
     */
    private function updateCheckoutSession(Response $response) // regex \[value-[0-9]*\]
    {
        $sessionID = $this->getSessionID();
        $sql = "UPDATE `StripeCheckoutSessions` SET 
                `custoID`=?,
                `payStatus`=?
                WHERE `sessionID` = '$sessionID'";
        $values = [];
        array_push(
            $values,
            $this->getCustomerID(),
            $this->getPaymentStatus()
        );
        $this->update($response, $sql, $values);
    }
}
