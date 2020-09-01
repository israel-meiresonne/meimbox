<?php

require_once 'model/ModelFunctionality.php';

class Currency extends ModelFunctionality
{
    /**
     * The iso code 3 of the currency
     *@var string $isoCurrency
     */
    private $isoCurrency;
    /**
     * The currency's name
     *@var string $currencyName
     */
    private $currencyName;
    /**
     * The iso symbole of the currency
     *@var string $symbol
     */
    private $symbol;
    /**
     * The coef to convert euro to this currency
     *@var double $eurToCurrency
     */
    private $eurToCurrency;

    /**
     * Holds the default currency iso code
     * @var string
     */
    private static $DEFAULT_ISO_CURRENCY;

    /**
     * Constructor
     * @param string $isoCurrency The iso code 2 of the currency
     */
    function __construct($isoCurrency)
    {
        if ($this->existCurrency($isoCurrency)) {
            $this->buildCurrency($isoCurrency);
        } else {
            $this->buildCurrency(self::$DEFAULT_ISO_CURRENCY);
        }
    }

    /**
     * Anitialize this Currency's attributs
     * @param string $isoCurrency currncy's iso code
     */
    private function buildCurrency($isoCurrency)
    {
        $tabLine = $this->getCurrencyLine($isoCurrency);
        $this->isoCurrency = $isoCurrency;
        $this->currencyName = $tabLine["currencyName"];
        $this->symbol = $tabLine["symbol"];
        $this->eurToCurrency = (float) $tabLine["EURtoCurrency"];
    }

    // /**
    //  * @param string $isoCurrency The iso code 3 of the currency
    //  * @param string $currencyName The currency's name
    //  * @param string $symbol The iso symbole of the currency
    //  * @param string $eurToCurrency The coef to convert euro to this currency
    //  */
    // private function __construct4($isoCurrency, $currencyName, $symbol, $eurToCurrency)
    // {
    //     $this->isoCurrency = $isoCurrency;
    //     $this->currencyName = $currencyName;
    //     $this->symbol = $symbol;
    //     $this->eurToCurrency = (float) $eurToCurrency;
    // }

    /**
     * Initialize Language's constants
     * @var string[string[...]] $dbMap The database tables in mapped format 
     * specified in file /oop/model/special/dbMap.txt
     */
    private function setConstants()
    {
        if (!isset(self::$DEFAULT_ISO_CURRENCY)) {
            self::$DEFAULT_ISO_CURRENCY = "DEFAULT_ISO_CURRENCY";
            self::$DEFAULT_ISO_CURRENCY = $this->getConstantLine(self::$DEFAULT_ISO_CURRENCY)["stringValue"];
        }
    }

    /**
     * Getter for the currency's iso code 3
     * @return string the currency's iso code 3
     */
    public function getIsoCurrency()
    {
        return $this->isoCurrency;
    }

    /**
     * Getter for the currency's iso code 3
     * @return string the currency's iso code 3
     */
    public function getSymbol()
    {
        return $this->symbol;
    }

    /**
     * To get a protected copy of a Currency instance
     * @return Currency a protected copy of the Currency instance
     */
    // public function getCopy()
    // {
    //     $copy = new Currency();
    //     $copy->isoCurrency = $this->isoCurrency;
    //     $copy->currencyName = $this->currencyName;
    //     $copy->symbol = $this->symbol;
    //     $copy->eurToCurrency = $this->eurToCurrency;

    //     return $copy;
    // }

    function __toString()
    {
        var_dump(get_object_vars($this));
        // Helper::printLabelValue("isoCode", $this->isoCurrency);
        // Helper::printLabelValue("currency", $this->currencyName);
        // Helper::printLabelValue("symbol", $this->symbol);
        // Helper::printLabelValue("eurToCurrency", $this->eurToCurrency);
    }
}
