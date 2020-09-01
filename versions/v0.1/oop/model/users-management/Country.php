<?php

class Country
{
    /**
     * The country's iso code 2
     * @var string
     */
    private $isoCountry;

    /**
     * The country's name in English
     * @var string
     */
    private $countryName;

    /**
     * Set to true if the country is in EU (European Union)
     * else false
     * @var boolean
     */
    private $isUE;

    /**
     * Country's value added tax (VAT)
     * @var double
     */
    private $vat;

    /**
     * The default country value used if the localisation of the Visitor is not
     *  supported by the database
     * @var string
     */
    protected static $DEFAULT_COUNTRY_NAME;


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
        }
    }

    private function __construct0()
    {
    }

    private function __construct2($countryName, $dbMap)
    {
        self::setConstants($dbMap);
        $countryMap = array_merge($dbMap["countryMap"], $dbMap["buyCountryMap"]);  // a supprimer quand la table BuyCountry sera supprimée
        // $countryMap = ($dbMap["countryMap"][$this->countryName] != null) ? $dbMap["countryMap"] : $dbMap["buyCountryMap"];

        $this->countryName = (array_key_exists($countryName, $countryMap)) ? $countryName : $this->DEFAULT_COUNTRY_NAME;

        $this->isoCountry = $countryMap[$this->countryName]["isoCountry"];
        $this->isUE = $countryMap[$this->countryName]["isUE"];
        $this->vat = $countryMap[$this->countryName]["vat"];
    }

        /**
     * Initialize Language's constants
     * @var string[string[...]] $dbMap The database tables in mapped format 
     * specified in file /oop/model/special/dbMap.txt
     */
    private function setConstants($dbMap)
    {
        if (!isset(self::$DEFAULT_COUNTRY_NAME)) {
            self::$DEFAULT_COUNTRY_NAME  = "DEFAULT_COUNTRY_NAME";
            $this->DEFAULT_COUNTRY_NAME = $dbMap["constantMap"][$this->DEFAULT_COUNTRY_NAME]["stringValue"];
        }
    }

    /**
     * Getter of the country's iso code 2
     * @return string the country's iso code 2
     */
    public function getIsoCountry()
    {
        return $this->isoCountry;
    }

    /**
     * Getter of the country's name in English
     * @return string The country's name in English
     */
    public function getCountryName()
    {
        return $this->countryName;
    }

    /**
     * To get a protected copy of a Country instance
     * @return Country a protected copy of the Country instance
     */
    public function getCopy()
    {
        $copy = new Country();
        $copy->isoCountry = $this->isoCountry;
        $copy->countryName = $this->countryName;
        $copy->isUE = $this->isUE;
        $copy->vat = $this->vat;
        return $copy;
    }

    public function __toString()
    {
        Helper::printLabelValue("isoCountry", $this->isoCountry);
        Helper::printLabelValue("countryName", $this->countryName);
        Helper::printLabelValue("isUE", $this->isUE);
        Helper::printLabelValue("vat", $this->vat);
    }
}
