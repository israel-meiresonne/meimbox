<?php
require_once 'model/boxes-management/Basket.php';
require_once 'model/special/Response.php';
/**
 * This class is used to holds and manages items ordered
 */
class BasketOrdered extends Basket
{
    /**
     * The total amount paid by the Client
     * +  (totalItem - discount + shipping)
     * @var Price
     */
    private $paidAmount;

    /**
     * The shipping cost of the order get from the basket's total shipping costs
     * @var Price
     */
    private $shipping;

    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * Create a new BasketOrdered
     * @param Response $response to push in result or accured error
     * @param Basket $basket Client's paid basket
     * @param string $orderID the id of the order for with the BasketOrderd is for
     */
    public function create(Response $response, Basket $basket, $orderID)
    {
        $this->language = $basket->getLanguage();
        $this->country = $basket->getCountry();
        $this->currency = $basket->getCurrency();
        $this->boxes = $basket->getBoxes();
        $this->basketProducts = $basket->getBasketProducts();
        $this->discountCodes = $basket->getDiscountCodes();
        $this->saveBasketOrdered($response, $orderID);
    }

    /**
     * To save the order
     * @param string $orderID id of an order
     */
    private function saveBasketOrdered(Response $response, $orderID)
    {
        // insert boxes
        $boxes = $this->getBoxes();
        Box::orderBoxes($response, $boxes, $orderID);
        // insert basketProducts + decrease sttock
    }

    /*———————————————————————————— SCRUD DOWN ———————————————————————————————*/

}
