<?php
require_once 'model/ModelFunctionality.php';
require_once 'model/boxes-management/Basket.php';
require_once 'model/orders-management/Status.php';
require_once 'model/tools-management/Address.php';
require_once 'model/orders-management/Status.php';
require_once 'model/orders-management/BasketOrdered.php';
require_once 'model/special/Response.php';
require_once 'model/tools-management/AddressDelivery.php';
require_once 'model/special/MyError.php';

/**
 * This class represente a order paid.
 * + This can be created ONLY when you receive the paiement confirmation.
 */
class Order extends ModelFunctionality
{
    /**
     * Holds order's id
     * @var string
     */
    private $orderID;

    /**
     * Holds the id of Stripe's session used to paid the order
     * @var string
     */
    private $stripeCheckoutID;

    /**
     * The status of the order.
     * + By default it set at "processing" with author set at "Systeme"
     * @var Status
     */
    private $status;

    /**
     * Holds order's delivery address
     * @var AddressDelivery
     */
    private $delivery;

    /**
     * Holds a basket that contain item ordered
     * @var BasketOrdered
     */
    private $basketOrdered;

    /**
     * Holds the DATETIME of the order into format "YYYY-MM-DD HH:MM:SS"
     * @var string
     */
    private $setDate;

    /**
     * Holds the time during the stock will be reserved for Client's checkout
     * + Note: time is in second
     * @var int
     */
    private static $LOCK_TIME;

    private const PREFIX_ID = "ord_";

    /**
     * Constructor
     */
    public function __construct()
    {
        self::setConstants();
    }

    /**
     * To set constants
     */
    private static function setConstants()
    {
        if (!isset(self::$LOCK_TIME)) {
            self::$LOCK_TIME = (int) parent::getCookiesMap()->get(Cookie::COOKIE_LCK, Map::period);
        }
    }

    // /**
    //  * To create a new Order
    //  * @param Response $response to push in result or accured error
    //  * @param string $userID id of the Client that own this Order
    //  * @param string $stripeCheckoutID id of Stripe's session used to paid the order
    //  * @param Address $address Client's delivery address for this order
    //  * @param Basket $basket Client's basket
    //  */
    // public function orderBasket(Response $response, $userID, $stripeCheckoutID, Address $address, Basket  $basket)
    // {
    //     $this->orderID = self::PREFIX_ID . $this->generateDateCode(25);
    //     $this->stripeCheckoutID = $stripeCheckoutID;
    //     $this->setDate =  $this->getDateTime();
    //     $country =  $address->getCountry();
    //     $this->insertOrder($response, $userID, $basket, $country);

    //     $this->delivery = new AddressDelivery();
    //     $this->delivery->create($response, $address, $this->orderID);

    //     // $this->basketOrdered = new BasketOrdered();
    //     // $this->basketOrdered->create($response, $basket, $this->orderID);
    //     // $shipping = $basket->getShipping();
    //     // $dayConv = 3600 * 24;
    //     // $minDate = strtotime($this->setDate) + $shipping->getMinTime() * $dayConv;
    //     // $maxDate = strtotime($this->setDate) + $shipping->getMaxTime() * $dayConv;
        
    //     // $this->basketOrdered = new BasketOrdered();
    //     // $this->basketOrdered->create($response, $basket, $this->orderID);
    //     $basket->orderBasket($response, $this->orderID);
    //     $shipping = $basket->getShipping();
    //     $dayConv = 3600 * 24;
    //     $minDate = strtotime($this->setDate) + $shipping->getMinTime() * $dayConv;
    //     $maxDate = strtotime($this->setDate) + $shipping->getMaxTime() * $dayConv;

    //     $this->status = new Status();
    //     $status = ($response->existErrorKey(MyError::ERROR_STILL_STOCK)) ?  MyError::ERROR_STILL_STOCK : null;
    //     $this->status->create($response, $this->orderID, $minDate, $maxDate, $status);

    //     // $this->basketOrdered->dropDiscountCodes($response, $userID);
    //     // $this->basketOrdered->unlock($response, $userID);
    //     $basket->dropDiscountCodes($response, $userID);
    //     $basket->unlock($response, $userID);
    // }
    /**
     * To create a new Order
     * @param Response $response to push in result or accured error
     * @param string $userID id of the Client that own this Order
     * @param string $stripeCheckoutID id of Stripe's session used to paid the order
     * @param Address $address Client's delivery address for this order
     * @param Basket $basket Client's basket
     */
    public function create(Response $response, $userID, $stripeCheckoutID, Address $address, Basket $basket)
    {
        $this->orderID = self::PREFIX_ID . $this->generateDateCode(25);
        $this->stripeCheckoutID = $stripeCheckoutID;
        $this->setDate =  $this->getDateTime();
        $country =  $address->getCountry();
        $this->insertOrder($response, $userID, $basket, $country);

        // $this->delivery = new AddressDelivery();
        // $this->delivery->create($response, $address, $this->orderID);
        $this->delivery = $address;     // ❌
        $address->insertDelivery($response, $this->orderID);

        $this->basketOrdered = $basket; // ❌
        $shipping = $basket->getShipping();
        $dayConv = 3600 * 24;
        $minDate = strtotime($this->setDate) + $shipping->getMinTime() * $dayConv;
        $maxDate = strtotime($this->setDate) + $shipping->getMaxTime() * $dayConv;

        $this->status = new Status();
        // $status = ($response->existErrorKey(MyError::ERROR_STILL_STOCK)) ?  MyError::ERROR_STILL_STOCK : null;
        $status = (!empty($basket->stillStock()->getKeys())) ?  MyError::ERROR_STILL_STOCK : null;
        $this->status->create($response, $this->orderID, $minDate, $maxDate, $status);

        // $this->basketOrdered->dropDiscountCodes($response, $userID);
        // $this->basketOrdered->unlock($response, $userID);
        // $basket->dropDiscountCodes($response, $userID);
        // $basket->unlock($response, $userID);
    }

    /**
     * To get order's id
     * @return string 
     */
    public function getOrderID()
    {
        return $this->orderID;
    }

    /**
     * To get Order's stripeCheckoutID
     * @return string Order's stripeCheckoutID
     */
    private function getStripeCheckoutID()
    {
        return $this->stripeCheckoutID;
    }

    /**
     * To get Order's Status
     * @return Status Order's Status
     */
    private function getStatus()
    {
        return $this->status;
    }

    /**
     * To get Order's address
     * @return AddressDelivery Order's address
     */
    public function getDelivery()
    {
        return $this->delivery;
    }

    /**
     * To get Order's basketOrdered
     * @return BasketOrdered Order's basketOrdered
     */
    public function getBasketOrdered()
    {
        return $this->basketOrdered;
    }

    /**
     * To get Order's setDate
     * @return string Order's setDate
     */
    private function getSetDate()
    {
        return $this->setDate;
    }

    /**
     * Convert setDate to seconde from UNIX.
     * @return int seconde from UNIX
     */
    public function getDateInSec()
    {
        return strtotime($this->setDate);
    }

    /**
     * To get the time during the product's stock will be lockeed
     *  @return int time in second
     */
    public static function getLockTime()
    {
        (!isset(self::$LOCK_TIME)) ? self::setConstants() : null;
        return self::$LOCK_TIME;
    }

    /*———————————————————————————— SCRUD DOWN ———————————————————————————————*/

    /**
     * To insert a new order in db
     * @param Response $response to push in results or accured errors
     * @param string $userID id of the Client that own this Order
     * @param Basket $basket Client's paid basket
     * @param Country $country the delivery country
     */
    private function insertOrder(Response $response, $userID, Basket  $basket, Country $country)
    {
        $bracket = "(?,?,?,?,?,?,?,?,?,?,?,?,?,?)"; // \[value-[0-9]*\]
        $sql = "INSERT INTO `Orders`(`orderID`, `userId`, `stripeCheckoutId`, `iso_currency`, `vatRate`, `vat`, `hvat`, `sellPrice`, `discount`, `subtotal`, `shipping`, `shipDiscount`, `total`, `setDate`) 
                VALUES " . $this->buildBracketInsert(1, $bracket);
        $values = [
            $this->getOrderID(),
            $userID,
            $this->getStripeCheckoutId(),
            $basket->getCurrency()->getIsoCurrency(),
            $country->getVat(),
            $basket->getVat()->getPrice(),
            $basket->getHvat()->getPrice(),
            $basket->getSumProducts()->getPrice(),
            $basket->getDiscountSumProducts()->getPrice(),
            $basket->getSubTotal()->getPrice(),
            $basket->getShipping()->getPrice(),
            $basket->getDiscountShipping()->getPrice(),
            $basket->getTotal()->getPrice(),
            $this->getSetDate()
        ];
        $this->insert($response, $sql, $values);
    }
}
