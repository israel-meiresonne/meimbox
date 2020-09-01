<?php

class BasketProduct extends Product
{
    /** Sell prices for each country and currency
     * $prices = [
     *      iso_country => [
     *          iso_currency => Price
     *      ]
     * ]
     * @var Price[[]] In format $prices[iso_country][iso_currency]
     */
    protected $prices;

    /** 
     * New price after an appliqued discount sell prices for each country and currency.
     * Fill only the country where the discount is available
     * $prices = [
     *      iso_country => [
     *          iso_currency => Price
     *      ]
     * ]
     * @var Price[[]] In format $prices[iso_country][iso_currency]
     */
    protected $newPrices;

    /**
     * Shippings cost for each country and currency
     * $shippings = [
     *      iso_country => [
     *          iso_currency => Shipping
     *      ]
     * ]
     * @var Shipping[[]] In format $shippings[iso_country][iso_currency]
     */
    protected $shippings;

    /**
     * Discount values for each country
     * $discounts = [
     *      iso_country => Discount
     * ]
     * @var Discount[] In format $discounts[iso_country]
     */
    protected $discounts;

    /**
     * Product type to know where to put it
     * @var string Product witch can be puted only into a basket
     */
    const BASKET_TYPE = "basketproduct";


    function __construct()
    {
        $argv = func_get_args();
        switch (func_num_args()) {
            case 0:
                self::__construct0();
                break;
            case 2:
                self::__construct3($argv[0], $argv[1]);
                break;
        }
    }

    protected function __construct0()
    {
    }

    protected function __construct3($prodID, $dbMap)
    {
        parent::__construct($prodID, self::BASKET_TYPE, $dbMap);

        $product = $dbMap["productMap"][self::BASKET_TYPE][$prodID];
        $this->prices = GeneralCode::initPrices($product["prices"], $dbMap);
        $this->newPrices = [];

        $this->shippings = GeneralCode::initShippings($product["shippings"], $dbMap);
        $this->discounts = GeneralCode::initDiscounts($product["discounts"], $dbMap);
        // $this->setDate = $product["datas"]["size_name"][$prodSize];
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
    //  * Getter of $BASKET_TYPE
    //  * @return string the type of the product
    //  */
    // public static function __getType()
    // {
    //     return self::BASKET_TYPE;
    // }

    /**
     * Getter for the price for a country in a currency given in param
     * @param Country $country The current Country of the Visitor
     * @param Currency $currency The current Currency of the Visitor
     * @return Price the Price matching the country in the currency given in 
     * param
     */
    public function getPrice($country, $currency)
    {
        $iso_country = $country->getIsoCountry();
        $iso_currency = $currency->getIsoCurrency();
        return $this->prices[$iso_country][$iso_currency]->getCopy();
    }

    /**
     * @return Price[[]] a protected copy of the Prices attribute
     */
    public function getCopyPrices()
    {
        $copy = [];
        foreach ($this->prices as $iso_country => $currencyList) {
            foreach ($currencyList as $iso_currency => $price) {
                $copy[$iso_country][$iso_currency] = $price->getCopy();
            }
        }
        return $copy;
    }

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
        foreach ($this->shippings as $iso_country => $currencyList) {
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
        foreach ($this->discounts as $setdateUnix => $discount) {
            $copy[$setdateUnix] = $discount->getCopy();
        }
        ksort($copy);
        return $copy;
    }


    /**
     * To get a protected copy of a BasketProduct instance
     * @return BasketProduct a protected copy of the BasketProduct instance
     */
    public function getCopy()
    {
        $copy = new BasketProduct();

        // Product attributs
        $copy->prodID = $this->prodID;
        $copy->prodName = $this->prodName;
        $copy->isAvailable = $this->isAvailable;
        $copy->addedDate = $this->addedDate;
        $copy->colorName = $this->colorName;
        $copy->colorRGB = $this->colorRGB;
        $copy->buyPrice = (!empty($this->buyPrice)) ? $this->buyPrice->getCopy() : null;
        $copy->weight = $this->weight;
        $copy->pictures = $this->pictures;
        $copy->sizesStock = $this->sizesStock;
        $copy->prodMeasures = GeneralCode::cloneMap($this->prodMeasures);
        $copy->size = (!empty($this->size)) ? $this->size->getCopy() : null;
        $copy->collections = $this->collections;
        $copy->prodFunctions = $this->prodFunctions;
        $copy->categories = $this->categories;
        $copy->descriptions = $this->descriptions;
        $copy->sameNameProducts = GeneralCode::cloneMap($this->sameNameProducts);

        // BasketProduct attributs
        $copy->prices = $this->getCopyPrices();
        $copy->newPrices = $this->getCopyNewPrices();
        $copy->shippings = $this->getCopyShippings();
        $copy->discounts = $this->getCopyDiscounts();
        $copy->setDate = $this->setDate;
        // $copy->BASKET_TYPE = self::BASKET_TYPE;

        return $copy;
    }

    /**
     * Check if the product is a basket product
     * @return boolean true if the product is a basket product else false
     */
    public function isBasketProduct()
    {
        return true;
    }

    public function __toString()
    {
        parent::__toString();
        Helper::printLabelValue("prices", $this->prices);
        Helper::printLabelValue("newPrices", $this->newPrices);
        Helper::printLabelValue("shippings", $this->shippings);
        Helper::printLabelValue("discounts", $this->discounts);
        Helper::printLabelValue("BASKET_TYPE", self::BASKET_TYPE);
    }
}
