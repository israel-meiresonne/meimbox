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
        // $this->price = new Price($price, $currency->getCopy());
        $this->price = new Price($price, $currency);
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
        // $this->shipping = new Shipping($price, $currency->getCopy(), $time);
        $this->shipping = new Shipping($price, $currency, $time);
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

    /**
     * Fill the same product list with product sharing the same name that the 
     * current product
     */
    private function setSameProducts()
    {
        $this->sameProducts = [];
        $language = $this->getLanguage();
        $country = $this->getCountry();
        $currency = $this->getCurrency();
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
     * Getter for product's sizes
     * @return string[] product's sizes
     */
    public function getSizes()
    {
        $sizesStock = $this->getSizeStock();
        return array_keys($sizesStock);
    }

    /**
     * Set product's selected size
     * @param Size $size 
     */
    public function selecteSize(Size $size)
    {
        $this->selectedSize = $size;
    }

    /**
     * Getter for product's price
     * @return Price product's price
     * + for boxProduct will return Price with a zero as value
     */
    public function getPrice()
    {
        $country = $this->getCountry();
        $currency = $this->getCurrency();
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

    // /**
    //  * Build a HTML displayable price
    //  * @param Country $country Visitor's current Country
    //  * @param Currency $currency Visitor's current Currency
    //  * @return string[] product's HTML displayable price
    //  */
    // public function getDisplayablePrice()
    // {
    //     $price = $this->getPrice();
    //     $priceStr = '<p>' . $price->getFormated() . '</p>';
    //     return $priceStr;
    // }

    /**
     * Check if it's still stock for the product submited by Visitor
     * + it's still stock mean that there size that fit the Visitor's submited size
     * @param Size $sizeObjs selected sizes to check if still stock for it
     * @return boolean true if the stock is available
     */
    public function stillStock(Size ...$sizeObjs)
    {
        $sizesStock = $this->getSizeStock();
        $size = $sizeObjs[0]->getSize();
        if (!key_exists($size, $sizesStock)) {
            throw new Exception("This size '$size' don't exist in sizesStock");
        }
        return ($sizesStock[$size] > 0);
    }

    /**
     * To check if still stock for product including product locked
     * + this function combine stock available and stock locked to deduct the 
     * stilling stock
     * @return boolean set true if still stock else false
     */
    public function stillUnlockedStock()
    {
        throw new Exception("Function 'stillUnlockedStock' declared but not implemented in class BasketProduct");
    }

    /**
     * Check if the product is a basket product
     * @return boolean true if the product is a basket product else false
     */
    public function isBasketProduct()
    {
        return true;
    }

    /**
     * To get A copy of the currrent instance
     * @return BasketProduct
     */
    public function getCopy()
    {
        $map = get_object_vars($this);
        $attributs = array_keys($map);
        $class = get_class($this);
        $copy = new $class();
        foreach ($attributs as $attribut) {
            switch (gettype($this->{$attribut})) {
                    // case 'object':
                    //     $copy->{$attribut} = $this->{$attribut}->getCopy();
                    //     break;
                default:
                    $copy->{$attribut} = $this->{$attribut};
                    break;
            }
        }
        return $copy;
    }

    /*———————————————————————————— SCRUD DOWN —————————————————————————————————————————*/

    /**
     * Update product's quantity in db
     * + this function also update product's set date
     * @param Response $response to push in results or accured errors
     *  contain the error thrown
     * @param string $userID Visitor's id
     */
    public function updateProduct(Response $response, $userID, Size $holdSize = null) // regex \[value-[0-9]*\]
    {
        $response->addError("not Implemented", MyError::ADMIN_ERROR);
    }
}
