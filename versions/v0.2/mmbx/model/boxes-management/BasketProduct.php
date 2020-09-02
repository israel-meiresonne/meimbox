<?php

require_once 'model/boxes-management/Product.php';
require_once 'model/boxes-management/Price.php';
require_once 'model/boxes-management/Shipping.php';
require_once 'model/boxes-management/Discount.php';
require_once 'model/tools-management/Country.php';
require_once 'model/tools-management/Currency.php';

class BasketProduct extends Product
{
    /** 
     * BasketProduct's sell price
     * @var Price
     */
    private $price;

    /**
     * BasketProduct's shipping cost
     * @var Shipping
     */
    private $shipping;

    /**
     * BasketProduct's discount value
     * + NOTE: Discount is set at null if there any discount 
     * @var Discount
     */
    private $discount;

    /**
     * Product type to know where to put it
     * @var string Product witch can be puted only into a basket
     */
    public const BASKET_TYPE = "basketproduct";

    /**
     * Constructor
     * @param int $prodID product's id
     * @param Language $language Visitor's language
     * @param Country $country the Visitor's country
     * @param Currency $currency the Visitor's current Currency
     */
    public function __construct($prodID, Language $language, Country $country, Currency $currency)
    {
        parent::__construct($prodID, $language, $country, $currency);
        // $this->setPrice($country, $currency);
        // $this->setShipping($country, $currency);
        // $this->setDiscount($country);
    }

        // /**
    //  * Setter for product's size and stock
    //  */
    // protected function setSizesStock()
    // {
    //     $this->sizesStock  = [];
    //     $sql = "SELECT * 
    //     FROM `Products-Sizes`
    //     WHERE `prodId` = '$this->prodID'";
    //     $tab = $this->select($sql); // add error if there is no size
    //     if (count($tab) < 1) {
    //         throw new Exception("There no size for this product");
    //     }
    //     foreach ($tab as $tabLine) {
    //         $this->sizesStock[$tabLine["size_name"]] = $tabLine["stock"];
    //     }
    // }

    /**
     * Setter for Basketproduct's price
     * @param Country $country the Visitor's country
     * @param Currency the Visitor's current Currency
     */
    private function setPrice($country, $currency)
    {
        $countryName = $country->getCountryName();
        $isoCurrency = $currency->getIsoCurrency();
        $sql = "SELECT * 
        FROM `ProductsPrices`
        WHERE `prodId` = '$this->prodID' AND `country_` = '$countryName' AND `iso_currency` = '$isoCurrency'";
        $tab = $this->select($sql);
        if (count($tab) != 1) {
            throw new Exception("There is any price for this product: id=$this->prodID, 
            countryName=$countryName, isoCurrency=$isoCurrency");
        }
        $tabLine = $tab[0];
        $price = (float) $tabLine["price"];
        $this->price = new Price($price, $currency->getCopy());
    }

    /**
     * Setter for Basketproduct's shipping
     * @param Country $country the Visitor's country
     * @param Currency the Visitor's current Currency
     */
    private function setShipping($country, $currency)
    {
        $countryName = $country->getCountryName();
        $isoCurrency = $currency->getIsoCurrency();
        $sql = "SELECT * 
        FROM `ProductsShippings`
        WHERE `prodId` = '$this->prodID' AND `country_` = '$countryName' AND `iso_currency` = '$isoCurrency'";
        $tab = $this->select($sql);
        if (count($tab) != 1) {
            throw new Exception("There is any shipping cost for this product: id=$this->prodID, 
            countryName=$countryName, isoCurrency=$isoCurrency");
        }
        $tabLine = $tab[0];
        $price = (float) $tabLine["price"];
        $time = (int) $tabLine["time"];
        $this->shipping = new Shipping($price, $currency->getCopy(), $time);
    }

    /**
     * Setter for Basketproduct's discount
     * @param Country $country the Visitor's country
     */
    private function setDiscount($country)
    {
        $countryName = $country->getCountryName();
        $sql = "SELECT * 
        FROM `ProductsDiscounts`
        WHERE `prodId` = '$this->prodID' AND `country_` = '$countryName'";
        $tab = $this->select($sql);
        if (count($tab) == 1) {
            $tabLine = $tab[0];
            $value = (float) $tabLine["discount_value"];
            $beginDate = $tabLine["beginDate"];
            $endDate = $tabLine["endDate"];
            $this->discount = new Discount($value, $beginDate, $endDate);
        } else {
            $this->discount = null;
        }
    }

    // /**
    //  * To set all other properties that nat in Product table
    //  * @param Language $lang Visitor's language
    //  * @param Country $country the Visitor's country
    //  * @param Currency the Visitor's current Currency
    //  */
    // public function CompleteProperties($lang, $country, $currency)
    // {
    // $this->setPictures();
    // $this->setSizesStock();
    // $this->setCollections();
    // $this->setProdFunctions();
    // $this->setCategories();
    // $this->setDescriptions($lang);
    // $this->setSameProducts($country, $currency);
    // }

    /**
     * Fill the same product list with product sharing the same name that the 
     * current product
     */
    private function setSameProducts()
    {
        $this->sameProducts = [];
        $language = $this->getLanguage();
        $country = $this->getCountry();
        $currency =$this->getCurrency();
        $sql = "SELECT `prodID` 
        FROM `Products` 
        WHERE isAvailable = 1 AND `prodID`!= '$this->prodID' AND `prodName` = '$this->prodName'  
        ORDER BY `Products`.`prodID` ASC";
        $tab = $this->select($sql);
        if (count($tab) > 0) {
            foreach ($tab as $tabLine) {
                $product = new BasketProduct($tabLine["prodID"], $language, $country, $currency);
                $this->sameProducts[$product->getProdID()] = $product;
            }
        }
    }

    /**
     * Getter of $BASKET_TYPE
     * @return string the type of the product
     */
    public function getType()
    {
        return self::BASKET_TYPE;
    }

    // /**
    //  * Getter for product's stock for each size
    //  * @return int[] product's stock for each size
    //  */
    // protected function getSizeStock()
    // {
    //     (!isset($this->sizesStock)) ? $this->setSizesStock() : null;
    //     return $this->sizesStock;
    // }

    /**
     * Getter for sameProducts
     * @return BasketProduct[] same Products than the current product
     */
    public function getSameProducts()
    {

        (!isset($this->sameProducts)) ? $this->setSameProducts() : null;
        return $this->sameProducts;
    }

    /**
     * Getter for product's prrice
     * @return Price product's prrice
     */
    private function getPrice()
    {
        $country = $this->getCountry();
        $currency =$this->getCurrency();
        (!isset($this->price)) ? $this->setPrice($country, $currency) : null;
        return $this->price;
    }

    /**
     * Getter for product's formated price
     * @return string product's formated price
     */
    public function getFormatedPrice()
    {
        $price = $this->getPrice();
        return $price->getFormated();
    }

    /**
     * Build a HTML displayable price
     * @param Country $country Visitor's current Country
     * @param Currency $currency Visitor's current Currency
     * @return string[] product's HTML displayable price
     */
    public function getDisplayablePrice()
    {
        $price = $this->getPrice();
        $priceStr = '<p>' . $price->getFormated() . '</p>';
        return $priceStr;
    }

    /**
     * Check if it's still stock for the product submited by Visitor
     * + it's still stock mean that there size that fit the Visitor's submited size
     * @param string $size to check if stock is available
     * @param string $brand never set for basket product
     * @param Measure $measure never set for basket product
     * @return boolean true if the stock is available
     */
    public function stillStock($size, $brand = null, Measure $measure = null)
    {
        (!isset($this->sizesStock)) ? $this->setSizesStock() : null;
        if (!key_exists($size, $this->sizesStock)) {
            throw new Exception("This size '$size' don't exist in sizesStock");
        }
        return ($this->sizesStock[$size] > 0);
    }

    /**
     * Check if the product is a basket product
     * @return boolean true if the product is a basket product else false
     */
    public function isBasketProduct()
    {
        return true;
    }
}
