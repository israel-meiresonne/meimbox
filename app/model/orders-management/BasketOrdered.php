<?php
require_once 'model/boxes-management/Basket.php';
require_once 'model/special/Response.php';

/**
 * This class is used to holds and manages items ordered
 */
class BasketOrdered extends Basket
{
    /**
     * Holds BasketOrdered's orderID
     * @var string
     */
    private $orderID;

    /**
     * Holds BasketOrdered's vat
     * @var Price
     */
    private $vat;

    /**
     * Holds BasketOrdered's hvat
     * @var Price
     */
    private $hvat;

    /**
     * Holds BasketOrdered's sellPrice
     * @var Price
     */
    private $sellPrice;

    /**
     * Holds BasketOrdered's discount
     * @var Price
     */
    private $discount;

    /**
     * Holds BasketOrdered's subtotal
     * @var Price
     */
    private $subtotal;

    /**
     * Holds BasketOrdered's shipping
     * @var Price
     */
    private $shipping;

    /**
     * Holds BasketOrdered's shipDiscount
     * @var Price
     */
    private $shipDiscount;

    /**
     * Holds BasketOrdered's total
     * @var Price
     */
    private $total;

    /**
     * Constructor
     * @param string|null $orderID id of the order
     */
    public function __construct($orderID = null)
    {
        if (isset($orderID)) {
            $ordersMap = Order::getOrdersMap();
            $orderIDs = $ordersMap->getKeys();
            if (!in_array($orderID, $orderIDs)) {
                throw new Exception("This order id '$orderID' don't existt in orders map");
            }
            // Map::stripeCheckoutId
            $this->orderID = $orderID;
            $isoCurrency = $ordersMap->get($orderID, Map::iso_currency);
            $currency = new Currency($isoCurrency);
            $this->currency = $currency;
            // Map::vatRate
            $vat = $ordersMap->get($orderID, Map::vat);
            $hvat = $ordersMap->get($orderID, Map::hvat);
            $sellPrice = $ordersMap->get($orderID, Map::sellPrice);
            $discount = $ordersMap->get($orderID, Map::discount);
            $subtotal = $ordersMap->get($orderID, Map::subtotal);
            $shipping = $ordersMap->get($orderID, Map::shipping);
            $shipDiscount = $ordersMap->get($orderID, Map::shipDiscount);
            $total = $ordersMap->get($orderID, Map::total);

            $this->vat = new Price($vat, $currency);
            $this->hvat = new Price($hvat, $currency);
            $this->sellPrice = new Price($sellPrice, $currency);
            $this->discount = new Price($discount, $currency);
            $this->subtotal = new Price($subtotal, $currency);
            $this->shipping = new Price($shipping, $currency);
            $this->shipDiscount = new Price($shipDiscount, $currency);
            $this->total = new Price($total, $currency);
            // Map::setDate
        }
    }

    /**
     * Setter for boxes
     */
    private function setBoxes()
    {
        $orderID = $this->getOrderID();
        $this->boxes = [];
        $currency = $this->getCurrency();
        $boxesMap = new Map(Box::getOrderedBoxes($orderID, $currency));
        $boxesMap->sortKeyDesc();
        $this->boxes = $boxesMap->getMap();
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
     * Getter for basket's boxes
     * @return Box[] basket's boxes
     */
    public function getBoxes()
    {
        (!isset($this->boxes)) ? $this->setBoxes() : null;
        return $this->boxes;
    }

    /**
     * To get the sum of of BasketProducts and Boxes in Basket
     * @return Price sum of of prices of BasketProducts and Boxes in Basket
     */
    // public function getSumProducts()
    public function getSumProducts()
    {
        return $this->sellPrice;
    }

    /**
     * To get price of item in Basket excluding vat tax
     * @return Price price of item in Basket excluding vat tax
     */
    // public function getHvat()
    public function getHvat()
    {
        return $this->hvat;
    }

    /**
     * To get basket's subtotal amount
     * @return Price basket's subtotal amount
     */
    public function getVat()
    {
        return $this->vat;
    }

    /**
     * To get basket's total price
     * @return Price basket's total price
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * To get basket's subtotal amount following the given config
     * @param $conf to config the subtotal returned
     * @return Price basket's subtotal amount
     */
    public function getSubTotal()
    {
        return $this->subtotal;
    }

    /**
     * To get Basket's shipping cost
     * @return Shipping Basket's shipping cost
     */
    public function getShipping()
    {
        return $this->shipping;
    }

    /**
     * To get the amount of the discount for the sum of products in Bakste
     * @return Price the amount of the discount
     */
    public function getDiscountSumProducts()
    {
        return $this->discount;
    }

    /**
     * To get the amount of the discount for the shipping
     * @return Price the amount of the discount for the shipping
     */
    public function getDiscountShipping()
    {
        return $this->shipDiscount;
    }
}
