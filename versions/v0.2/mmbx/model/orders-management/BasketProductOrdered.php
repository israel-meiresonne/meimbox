<?php

class BasketProductOrdered extends BasketProduct
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

    function __construct($basketProduct)
    {
        // Product attributs
        parent::$prodID = $basketProduct->getProdID();
        parent::$prodName = $basketProduct->getProdName();
        parent::$isAvailable = $basketProduct->getIsAvailable();
        parent::$addedDate = $basketProduct->getAddedDate();
        parent::$colorName = $basketProduct->getColorName();
        parent::$colorRGB = $basketProduct->getColorRGB();
        parent::$buyPrice = $basketProduct->getBuyPrice();
        parent::$weight = $basketProduct->getWeight();
        parent::$quantity = $basketProduct->getQuantity();
        parent::$pictures = $basketProduct->getPictures();
        parent::$sizesStock = $basketProduct->getSizesStock();
        parent::$collections = $basketProduct->getCollections();
        parent::$prodFunctions = $basketProduct->getProdFunctions();
        parent::$categories = $basketProduct->getCatagories();
        parent::$descriptions = $basketProduct->getDescriptions();
        // BasketProduct attribute
        parent::$prices = $basketProduct->getCopyPrices();
        parent::$newPrices = $basketProduct->getCopyNewPrices();
        parent::$shippings = $basketProduct->getCopyShippings();
        parent::$discounts = $basketProduct->getCopyDiscounts();
    }
}
