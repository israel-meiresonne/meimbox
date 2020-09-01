<?php

/**
 * This class représente a order paid.
 * This can be created ONLY when you receive the paiement confirmation.
 */
class Order {
    /**
     * Holds a sequence of letter and number as the id of the order.
     * Two order can't have a same $orderID
     * @var string
     */
    private $orderID;
    /**
     * Holds the DATETIME of the order into format "YYYY-MM-DD HH:MM:SS"
     * @var string
     */
    private $setDate;
    
    /**
     * The status of the order.
     * By default it set at "processing" with author set at "Systeme"
     * @var Status
     */
    private $status;
    
    /**
     * The price of the order get from the basket's subtotal
     * @var Price
     */
    private $subtotal;

    /**
     * The shipping cost of the order get from the basket's total shipping costs
     * @var Shipping
     */
    private $shipping;

    /**
     * Holds Boxes from basket ordered
     * @var BoxOrdered[]
     */
    private $boxesOrdered;

    /**
     * Holds basketProduct from basket ordered
     * @var BasketProductOrdered[]
     */
    private $basketProductsOrdered;

    /**
     * Liste of discount code of the basket.
     * Use the code as access key like $discountCodes[code => DiscountCode]
     * @var DiscountCode[] $discountCodes
     */
    private $discountCodes;

    /**
     * The default value take by a new order.
     * This default value ("ORDER_DEFAULT_STATUS") is used to get the real value 
     * stored in Constante table with the keyword "ORDER_DEFAULT_STATUS". In this way we can change the 
     * $STATUS value without touch the code.
     * @var string
     */
    private $STATUS = "ORDER_DEFAULT_STATUS";


    function __construct($basket, $dbMap)
    {
        $this->STATUS = $dbMap["constantMap"][$this->STATUS]["stringValue"];
        $this->orderID = self::genarateOrderID();
        $this->setDate =  GeneralCode::getDateTime();
        $this->status = new Status($dbMap["SYSTEM_ID"], $this->STATUS, $this->setDate);
        // $this->subtotal = 
        // $this->shipping = 

        $this->boxesOrdered = self::initBoxOrdered($basket);
        $this->basketProductsOrdered = self::initBasketProductOrdered($basket);
        $this->discountCodes = self::initDiscountCodes($basket);
    }

    /**
     * Generate a new order ID
     */
    private function genarateOrderID(){
        return "orderID";
    }

        /**
     * Convert setDate to seconde from UNIX.
     * @return int seconde from UNIX
     */
    public function getDateInSec(){
        return strtotime($this->setDate);
    }

    /**
     * Convert all Box inside the basket to BoxOrdered instance
     * @param Basket $basket user's Basket
     * @return BoxOrdered[]
     */
    private function initBoxOrdered($basket){
        $boxesOrdered = [];
        $boxes = $basket->getCopyBoxes();
        foreach($boxes as $setDateUnix => $box){
            $boxesOrdered[$setDateUnix] = new BoxOrdered($box);
        }
        return $boxesOrdered;
    }
    
    /**
     * @param Basket $basket user's Basket
     * @return BasketProductOrdered[]
     */
    private function initBasketProductOrdered($basket){
        $basketProductOrdered = [];
        $basketProducts = $basket->getCopyBasketProducts();
        foreach($basketProducts as $setDateUnix => $basketProduct){
            $basketProductOrdered[$setDateUnix] = new BasketProductOrdered($basketProduct);
        }
        return $basketProductOrdered;
    }
    
    /**
     * @param Basket $basket user's Basket
     * @return DiscountCode[]
     */
    private function initDiscountCodes($basket){
        return $basket->getCopyDiscountCodes();
    }
}