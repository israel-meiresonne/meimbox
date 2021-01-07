<?php
require_once 'model/ModelFunctionality.php';

class Price  extends ModelFunctionality
{
    /**
     * @var float
     */
    protected $price;

    /**
     * The currency of the price
     * @var Currency
     */
    protected $currency;

    /**
     * The textual value to display a price with a textual minimum indication
     * @var string
     */
    public const TEXTUAL_MIN = "min";

    /**
     * The textual value to display a price with a textual minimum indication
     * @var string
     */
    public const TEXTUAL_MAX = "max";

    /**
     * @param float $price 
     * @param Currency $currency price's currency
     */
    public function __construct(float $price, Currency $currency)
    {
        $this->price = ModelFunctionality::toFloat($price);
        $this->currency = $currency;
    }

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
     * Getter of the price
     * @return float the price
     */
    public function getPriceRounded()
    {
        $price = $this->getPrice();
        return ModelFunctionality::toFloat(number_format($price, 2, ".", ""));
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
     * To reverse the price
     * @return Price
     */
    public function getReverse()
    {
        $this->price = -$this->getPrice();
        $copy = $this->getCopy();
        $this->price = -$this->getPrice();
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
        // return  ($symbol != $isoCurrency) ? $symbol . "" . $price . " " . $isoCurrency
        //     : $price . " " . $isoCurrency;
        return  $symbol . " " . $price;
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

    /**
     * To get A copy of the currrent instance
     * @return Size
     */
    public function getCopy()
    {
        $map = get_object_vars($this);
        $attributs = array_keys($map);
        $class = get_class($this);
        $copy = new $class($this->price, $this->currency);
        foreach ($attributs as $attribut) {
            $copy->{$attribut} = $this->{$attribut};
        }
        return $copy;
    }
}
