<?php

class Price
{
    /**
     * @var double
     */
    private $price;

    /**
     * The currency of the price
     * @var Currency
     */
    private $currency;

    /**
     * The textual value to display a price with a textual minimum indication
     * @var string
     */
    const TEXTUAL_MIN = "min";

    /**
     * The textual value to display a price with a textual minimum indication
     * @var string
     */
    const TEXTUAL_MAX = "max";

    /**
     * @param float $price 
     * @param Currency $currency price's currency
     */
    public function __construct(float $price, Currency $currency)
    {
        $this->price = $price;
        $this->currency = $currency;
    }

    protected function __construct0()
    {
    }

    // /**
    //  * @param double $price the price's value
    //  * @param Currency $currency The current Currency of the Visitor
    //  */
    // protected function __construct2($price, $currency)
    // {
    //     $this->price = $price;
    //     $this->currency = $currency;
    // }

    // protected function __construct4($price, $countryName, $isoCurrency, $dbMap)
    // {
    //     $this->price = $price;
    //     $this->country = new Country($countryName, $dbMap);
    //     $this->currency = new Currency($isoCurrency, $dbMap);
    // }

    /**
     * Getter of the price
     * @return float the price
     */
    public function getPrice()
    {
        // return (float) number_format($this->price, 2, ".", "");
        return $this->price;
    }

    /**
     * Getter for price's currency
     * @return Currency price's currency
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Getter of the iso code 2 of the price's country 
     * @return string the iso code 2 of the price's country 
     */
    public function getIsoCountry()
    {
        return $this->country->getIsoCountry();
    }

    /**
     * To get a protected copy of a Price instance
     * @return Price a protected copy of the Price instance
     */
    // public function getCopy()
    // {
    //     $copy = new Price();
    //     $copy->price = $this->price;
    //     $copy->country = (!empty($this->country)) ? $this->country->getCopy() : null;
    //     $copy->currency = (!empty($this->currency)) ? $this->currency->getCopy() : null;
    //     return $copy;
    // }

    /**
     * Format the price to make it into a displayable format for Visitor
     * @return string the price into a displayable format
     */
    public function getFormated()
    {
        $isoCurrency = strtoupper($this->currency->getIsoCurrency());
        $symbol = strtoupper($this->currency->getSymbol());
        $price = ($this->price != 0) ? number_format($this->price, 2, ",", " ") : 0;
        // return  ($symbol != $isoCurrency) ? $symbol . "" . $price . " " . $isoCurrency
        //     : $price . " " . $isoCurrency;
        return  $symbol . " ". $price;
    }

    /**
     * Format the price to make it in a displayable format for Visitor with a 
     * textual indication that it a minimum value. The textual indication is 
     * trnaslated with the translator.
     * @param Translator $translator the View's translator. NOTE: it's the only
     *  instance of this class in the whole system.
     * @return string the price in a displayable format with a translated
     * textual indication that it a minimum value
     */
    public function getMinPrice($translator)
    {
        $textualMin = $translator->translateString(self::TEXTUAL_MIN);
        return $textualMin . ": " . $this->getFormated();
    }

    /**
     * Format the price to make it in a displayable format for Visitor with a 
     * textual indication that it a minimum value. The textual indication is 
     * trnaslated with the translator.
     * @param Translator $translator the View's translator. NOTE: it's the only
     *  instance of this class in the whole system.
     * @return string the price in a displayable format with a translated
     * textual indication that it a minimum value
     */
    public function getMaxPrice($translator)
    {
        $textualMin = $translator->translateString(self::TEXTUAL_MAX);
        return $textualMin . ": " . $this->getFormated();
    }

    /**
     * Getter of the price as key 
     * + i.e: 2.35 return 235
     * @return float the price as key
     */
    public function getPriceKey()
    {
        return number_format($this->getPrice() * 100, 2, "", "");
    }
}
