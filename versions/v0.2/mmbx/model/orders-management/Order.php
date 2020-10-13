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
 * This class représente a order paid.
 * This can be created ONLY when you receive the paiement confirmation.
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

    // /**
    //  * Holds Boxes from basket ordered
    //  * @var BoxOrdered[]
    //  */
    // private $boxesOrdered;

    // /**
    //  * Holds basketProduct from basket ordered
    //  * @var BasketProductOrdered[]
    //  */
    // private $basketProductsOrdered;

    // /**
    //  * Liste of discount code of the basket.
    //  * Use the code as access key like $discountCodes[code => DiscountCode]
    //  * @var DiscountCode[] $discountCodes
    //  */
    // private $discountCodes;

    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * To create a new Order
     * @param Response $response to push in result or accured error
     * @param string $userID id of the Client that own this Order
     * @param string $stripeCheckoutID id of Stripe's session used to paid the order
     * @param Address $address Client's delivery address for this order
     * @param Basket $basket Client's basket
     */
    public function create(Response $response, $userID, $stripeCheckoutID, Address $address, Basket  $basket)
    {
        $this->orderID = $this->generateDateCode(25);
        $this->stripeCheckoutID = $stripeCheckoutID;
        $this->setDate =  $this->getDateTime();
        $country =  $address->getCountry();
        $this->insertOrder($response, $userID, $basket, $country);

        $this->delivery = new AddressDelivery();
        $this->delivery->create($response, $address, $this->orderID);

        $this->basketOrdered = new BasketOrdered();
        $this->basketOrdered->create($response, $basket, $this->orderID);
        
        $this->status = new Status();
        $status = ($response->existErrorKey(MyError::ERROR_STILL_STOCK)) ?  MyError::ERROR_STILL_STOCK : null;
        $this->status->create($response, $this->orderID, $status);
        
        $this->basketOrdered->unlock($response, $userID);
        $this->basketOrdered->empty($response);
    }

    /**
     * To get order's id
     * @return string 
     */
    private function getOrderID()
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
    private function getDelivery()
    {
        return $this->delivery;
    }

    /**
     * To get Order's basketOrdered
     * @return BasketOrdered Order's basketOrdered
     */
    private function getBasketOrdered()
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

    /*———————————————————————————— SCRUD DOWN ———————————————————————————————*/

    /**
     * To insert a new order in db
     * @param Response $response to push in results or accured errors
     * @param string $userID id of the Client that own this Order
     * @param Basket $basket Client's paid basket
     * @param Country $country the delivery country
     */
    private function insertOrder(Response $response, $userID, Basket  $basket, Country $country) // \[value-[0-9]*\]
    {
        $bracket = "(?,?,?,?,?,?,?,?)";
        $sql = "INSERT INTO `Orders`(`orderID`, `userId`, `stripeCheckoutId`, `vat`, `paidAmount`, `shippingCost`, `iso_currency`, `setDate`) 
                VALUES " . $this->buildBracketInsert(1, $bracket);
        $values = [
            $this->getOrderID(),
            $userID,
            $this->getStripeCheckoutId(),
            $country->getVat(),
            $basket->getTotal()->getPrice(),
            $basket->getShipping()->getPrice(),
            $basket->getCurrency()->getIsoCurrency(),
            $this->getSetDate()
        ];
        $this->insert($response, $sql, $values);
    }
}
