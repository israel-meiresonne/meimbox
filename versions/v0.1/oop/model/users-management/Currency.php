<?php
class Currency
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
     * __construct0() |
     * __construct2($db, $isoCurrency) |
     * __construct4($isoCurrency, $currencyName, $symbol, $eurToCurrency) |
     * @param string $isoCurrency The iso code 2 of the currency
     * @param string $currencyName The currency's name
     * @param string $symbol The iso symbole of the currency
     * @param string $eurToCurrency The coef to convert euro to this currency
     */
    function __construct()
    {
        $argv = func_get_args();
        switch (func_num_args()) {
            case 0:
                self::__construct0();
                break;
            case 2:
                self::__construct2($argv[0], $argv[1]);
                break;
            case 4:
                self::__construct4($argv[0], $argv[1], $argv[2], $argv[3]);
                break;
        }
    }

    private function __construct0()
    {
    }

    private function __construct2($isoCurrency, $dbMap)
    {
        self::setConstants($dbMap);
        if (array_key_exists($isoCurrency, $dbMap["currencyMap"])) {
            $this->isoCurrency = $isoCurrency;
            $this->currencyName = $dbMap["currencyMap"][$isoCurrency]["currencyName"];
            $this->symbol = $dbMap["currencyMap"][$isoCurrency]["symbol"];
            $this->eurToCurrency = (float) $dbMap["currencyMap"][$isoCurrency]["EURtoCurrency"];
        } else {
            $this->isoCurrency = $dbMap["currencyMap"]["default"]["isoCurrency"];
            $this->currencyName = $dbMap["currencyMap"]["default"]["currencyName"];
            $this->symbol = $dbMap["currencyMap"]["default"]["symbol"];
            $this->eurToCurrency = (float) $dbMap["currencyMap"]["default"]["euroToCurrency"];
        }
    }

    /**
     * @param string $isoCurrency The iso code 3 of the currency
     * @param string $currencyName The currency's name
     * @param string $symbol The iso symbole of the currency
     * @param string $eurToCurrency The coef to convert euro to this currency
     */
    private function __construct4($isoCurrency, $currencyName, $symbol, $eurToCurrency)
    {
        $this->isoCurrency = $isoCurrency;
        $this->currencyName = $currencyName;
        $this->symbol = $symbol;
        $this->eurToCurrency = (float) $eurToCurrency;
    }

    /**
     * Initialize Language's constants
     * @var string[string[...]] $dbMap The database tables in mapped format 
     * specified in file /oop/model/special/dbMap.txt
     */
    private function setConstants($dbMap)
    {
        if (!isset(self::$DEFAULT_ISO_CURRENCY)) {
            self::$DEFAULT_ISO_CURRENCY = "DEFAULT_ISO_CURRENCY";
            self::$DEFAULT_ISO_CURRENCY = $this->dbMap["constantMap"][self::$DEFAULT_ISO_CURRENCY]["stringValue"];
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
    public function getCopy()
    {
        $copy = new Currency();
        $copy->isoCurrency = $this->isoCurrency;
        $copy->currencyName = $this->currencyName;
        $copy->symbol = $this->symbol;
        $copy->eurToCurrency = $this->eurToCurrency;

        return $copy;
    }

    function __toString()
    {
        Helper::printLabelValue("isoCode", $this->isoCurrency);
        Helper::printLabelValue("currency", $this->currencyName);
        Helper::printLabelValue("symbol", $this->symbol);
        Helper::printLabelValue("eurToCurrency", $this->eurToCurrency);
    }
}
