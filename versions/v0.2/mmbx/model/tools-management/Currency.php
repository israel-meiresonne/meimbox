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
        self::setConstants();
        if (!$this->existCurrency($isoCurrency)) {
            throw new Exception("This currency('$isoCurrency') is not supported");
        }
        $this->setCurrency($isoCurrency);
    }

    /**
     * Anitialize this Currency's attributs
     * @param string $isoCurrency currncy's iso code
     */
    public function setCurrency($isoCurrency)
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
     * To set Currency's constants
     */
    private static function setConstants()
    {
        if (!isset(self::$DEFAULT_ISO_CURRENCY)) {
            self::$DEFAULT_ISO_CURRENCY = "DEFAULT_ISO_CURRENCY";
            self::$DEFAULT_ISO_CURRENCY = parent::getConstantLine(self::$DEFAULT_ISO_CURRENCY)["stringValue"];
        }
    }

    /**
     * To get System's default iso currency code
     * @return string System's default iso currency code
     */
    public static function getDefaultIsoCurrency()
    {
        (!isset(self::$DEFAULT_ISO_CURRENCY)) ? self::setConstants() : null;
        return self::$DEFAULT_ISO_CURRENCY;
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
}