<?php

class Price
{
    /**
     * @var float
     */
    private $price;

    /**
     * The country where the price is for
     * @var Country
     */
    private $country;

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
     * __construct2($price, $country, $currency)
     * @param double $price 
     * @param Country $country The country where the price is for
     * @param Currency The currency of the price
     */
    function __construct()
    {
        $args = func_get_args();
        switch (func_num_args()) {
            case 0:
                $this->__construct0();
                break;
            case 2:
                $this->__construct2($args[0], $args[1]);
                break;
            case 4:
                $this->__construct4($args[0], $args[1], $args[2], $args[3]);
                break;
        }
    }

    protected function __construct0()
    {
    }

    /**
     * @param float $price the price's value
     * @param Currency $currency The current Currency of the Visitor
     */
    protected function __construct2($price, $currency)
    {
        $this->price = $price;
        $this->currency = $currency;
    }

    protected function __construct4($price, $countryName, $isoCurrency, $dbMap)
    {
        $this->price = $price;
        $this->country = new Country($countryName, $dbMap);
        $this->currency = new Currency($isoCurrency, $dbMap);
    }

    /**
     * Getter of the price
     * @return double the price
     */
    public function getPrice()
    {
        return number_format($this->price, 2, ".", "");
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
    public function getCopy()
    {
        $copy = new Price();
        $copy->price = $this->price;
        $copy->country = (!empty($this->country)) ? $this->country->getCopy() : null;
        $copy->currency = (!empty($this->currency)) ? $this->currency->getCopy() : null;
        return $copy;
    }

    /**
     * Format the price to make it into a displayable format for Visitor
     * @return string the price into a displayable format
     */
    public function getFormated()
    {
        $isoCurrency = strtoupper($this->currency->getIsoCurrency());
        $symbol = strtoupper($this->currency->getSymbol());
        $price = ($this->price != 0) ? number_format($this->price, 2, ",", " ") : 0;
        // $price = number_format($this->price, 2, ",", " ");
        return  $symbol != $isoCurrency ? $symbol . "" . $price . " " . $isoCurrency
            : $price . " " . $isoCurrency;
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
    public function getMinPrice($language, $translator){
        $textualMin = $translator->translateString(self::TEXTUAL_MIN, $language);
        return $textualMin. ": ".self::getFormated();
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
    public function getMaxPrice($language, $translator){
        $textualMin = $translator->translateString(self::TEXTUAL_MAX, $language);
        return $textualMin. ": ".self::getFormated();
    }

    public function __toString()
    {
        Helper::printLabelValue("price", $this->price);
        $this->country->__toString();
        $this->currency->__toString();
    }
}
