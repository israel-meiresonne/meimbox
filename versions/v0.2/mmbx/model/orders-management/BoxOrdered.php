<?php

class BoxOrdered extends Box
{
    /**
     * Postal Tracking number of the box
     * @var string
     */
    private $trackingNumber;

    /**
     * The minimum delivery date.
     * @var string $deliveryMin into format "YYYY-MM-DD"
     */
    private $deliveryMin;

    /**
     * The maximum delivery date.
     * @var string $deliveryMax into format "YYYY-MM-DD"
     */
    private $deliveryMax;

    /**
     * @param Box $box a Box's instance
     */
    function __construct($box)
    {
        parent::$boxID = $box->getBoxID();
        parent::$color = $box->getColor();
        parent::$setDate = $box->getSetDate();
        parent::$sizeMax = $box->getSizeMax();
        parent::$weight = $box->getWeight();
        parent::$stock = $box->getStock();
        
        parent::$buiyPrice = $box->getCopyBuiyPrice();
        parent::$quantity = $box->getQuantity();
        parent::$shippings = $box->getCopyShippings();
        parent::$prices = $box->getCopyPrices();
        parent::$newPrices = $box->getCopyNewPrices();
        parent::$discounts = $box->getCopyDiscounts();
        parent::$boxProducts = $box->getCopyBoxProducts();
    }
}




