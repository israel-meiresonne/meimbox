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
    protected $price;

    /**
     * BasketProduct's shipping cost
     * @var Shipping
     */
    protected $shipping;

    /**
     * BasketProduct's discount value
     * + NOTE: Discount is set at null if there any discount 
     * @var Discount
     */
    protected $discount;

    /**
     * Product type to know where to put it
     * @var string Product witch can be puted only into a basket
     */
    const BASKET_TYPE = "basketproduct";

    /**
     * Constructor
     * @param int $prodID product's id
     * @param Country $country the Visitor's country
     * @param Currency the Visitor's current Currency
     */
    public function __construct($prodID, $country, $currency)
    {
        parent::__construct($prodID);

        $this->setPrice($country, $currency);
        $this->setShipping($country, $currency);
        $this->setDiscount($country);
    }

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
        if(count($tab) == 1){
            $tabLine = $tab[0];
            $value = (float) $tabLine["discount_value"];
            $beginDate = $tabLine["beginDate"];
            $endDate = $tabLine["endDate"];
            $this->discount = new Discount($value, $beginDate, $endDate);
        } else {
            $this->discount = null;
        }
    }

    /**
     * To set all other properties that nat in Product table
     * @param Language $lang Visitor's language
     * @param Country $country the Visitor's country
     * @param Currency the Visitor's current Currency
     */
    public function CompleteProperties($lang, $country, $currency)
    {
        $this->setPictures();
        $this->setSizesStock();
        $this->setCollections();
        $this->setProdFunctions();
        $this->setCategories();
        $this->setDescriptions($lang);
        $this->setSameProducts($country, $currency);
    }

    /**
     * Fill the same product list with product sharing the same name that the 
     * current product.
     * @param Country $country the Visitor's country
     * @param Currency the Visitor's current Currencyƒ
     */
    private function setSameProducts($country, $currency)
    {
        $this->sameProducts = [];
        $sql = "SELECT `prodID` 
        FROM `Products` 
        WHERE isAvailable = 1 AND `prodID`!= '$this->prodID' AND `prodName` = '$this->prodName'  
        ORDER BY `Products`.`prodID` ASC";
        $tab = $this->select($sql);
        if(count($tab) > 0){
            foreach($tab as $tabLine){
                $product = new BasketProduct($tabLine["prodID"], $country, $currency);
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

    /**
     * Getter for the price for a country in a currency given in param
     * @param Country $country The current Country of the Visitor
     * @param Currency $currency The current Currency of the Visitor
     * @return Price the Price matching the country in the currency given in 
     * param
     */
    // public function getPrice($country, $currency)
    // {
    //     $iso_country = $country->getIsoCountry();
    //     $iso_currency = $currency->getIsoCurrency();
    //     return $this->price[$iso_country][$iso_currency]->getCopy();
    // }

    /**
     * Getter for product's price
     * @return Price protected copy of the Prices attribute
     */
    // public function getPrices()
    // {
    //     $copy = [];
    //     foreach ($this->price as $iso_country => $currencyList) {
    //         foreach ($currencyList as $iso_currency => $price) {
    //             $copy[$iso_country][$iso_currency] = $price->getCopy();
    //         }
    //     }
    //     return $copy;
    // }

    /**
     * @return Price[[]] a protected copy of the NewPrices attribute
     */
    public function getCopyNewPrices()
    {
        $copy = [];
        foreach ($this->newPrices as $iso_country => $currencyList) {
            foreach ($currencyList as $iso_currency => $newPrice) {
                $copy[$iso_country][$iso_currency] = $newPrice->getCopy();
            }
        }
        return $copy;
    }

    /**
     * @return Shipping[[]] a protected copy of the Shippings attribute
     */
    public function getCopyShippings()
    {
        $copy = [];
        foreach ($this->shipping as $iso_country => $currencyList) {
            foreach ($currencyList as $iso_currency => $shipping) {
                $copy[$iso_country][$iso_currency] = $shipping->getCopy();
            }
        }
        return $copy;
    }

    /**
     * @return Discount[] a protected copy of the Discounts attribute
     */
    public function getCopyDiscounts()
    {
        $copy = [];
        foreach ($this->discount as $setdateUnix => $discount) {
            $copy[$setdateUnix] = $discount->getCopy();
        }
        ksort($copy);
        return $copy;
    }


    /**
     * To get a protected copy of a BasketProduct instance
     * @return BasketProduct a protected copy of the BasketProduct instance
     */
    // public function getCopy()
    // {
    //     $copy = new BasketProduct();

    //     // Product attributs
    //     $copy->prodID = $this->prodID;
    //     $copy->prodName = $this->prodName;
    //     $copy->isAvailable = $this->isAvailable;
    //     $copy->addedDate = $this->addedDate;
    //     $copy->colorName = $this->colorName;
    //     $copy->colorRGB = $this->colorRGB;
    //     $copy->buyPrice = (!empty($this->buyPrice)) ? $this->buyPrice->getCopy() : null;
    //     $copy->weight = $this->weight;
    //     $copy->pictures = $this->pictures;
    //     $copy->sizesStock = $this->sizesStock;
    //     $copy->prodMeasures = GeneralCode::cloneMap($this->prodMeasures);
    //     $copy->size = (!empty($this->size)) ? $this->size->getCopy() : null;
    //     $copy->collections = $this->collections;
    //     $copy->prodFunctions = $this->prodFunctions;
    //     $copy->categories = $this->categories;
    //     $copy->descriptions = $this->descriptions;
    //     $copy->sameNameProducts = GeneralCode::cloneMap($this->sameNameProducts);

    //     // BasketProduct attributs
    //     $copy->prices = $this->getCopyPrices();
    //     $copy->newPrices = $this->getCopyNewPrices();
    //     $copy->shippings = $this->getCopyShippings();
    //     $copy->discounts = $this->getCopyDiscounts();
    //     $copy->setDate = $this->setDate;
    //     // $copy->BASKET_TYPE = self::BASKET_TYPE;

    //     return $copy;
    // }

    /**
     * Check if the product is a basket product
     * @return boolean true if the product is a basket product else false
     */
    public function isBasketProduct()
    {
        return true;
    }

    // public function __toString()
    // {
    //     parent::__toString();
    //     Helper::printLabelValue("prices", $this->price);
    //     Helper::printLabelValue("newPrices", $this->newPrices);
    //     Helper::printLabelValue("shippings", $this->shipping);
    //     Helper::printLabelValue("discounts", $this->discount);
    //     Helper::printLabelValue("BASKET_TYPE", self::BASKET_TYPE);
    // }
}
