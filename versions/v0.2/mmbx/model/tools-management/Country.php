<?php

require_once 'model/ModelFunctionality.php';

class Country extends ModelFunctionality
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
    private static $DEFAULT_COUNTRY_NAME;


    public function __construct($countryName)
    {
        $this->setConstants();
        if ($this->existCountry($countryName)) {
            $this->buildCurrency($countryName);
        } else {
            $this->buildCurrency(self::$DEFAULT_COUNTRY_NAME);
        }
    }

    /**
     * Initialize Language's constants
     */
    private function setConstants()
    {
        if (!isset(self::$DEFAULT_COUNTRY_NAME)) {
            self::$DEFAULT_COUNTRY_NAME  = "DEFAULT_COUNTRY_NAME";
            self::$DEFAULT_COUNTRY_NAME = $this->getConstantLine(self::$DEFAULT_COUNTRY_NAME)["stringValue"];
        }
    }

    /**
     * Anitialize this Country's attributs
     * @param string $isoCurrency currncy's iso code
     */
    private function buildCurrency($countryName)
    {
        $country = $this->getCountryLine($countryName);
        $this->countryName = $countryName;
        $this->isoCountry = $country["isoCountry"];
        $this->isUE = $country["isUE"];
        $this->vat = $country["vat"];
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
     * Getter of the country's vat
     * @return string The country's vat
     */
    public function getVat()
    {
        return $this->vat;
    }

    // /**
    //  * To get a protected copy of a Country instance
    //  * @return Country a protected copy of the Country instance
    //  */
    // public function getCopy()
    // {
    //     $copy = clone $this;
    //     $copy->isoCountry = $this->isoCountry;
    //     $copy->countryName = $this->countryName;
    //     $copy->isUE = $this->isUE;
    //     $copy->vat = $this->vat;
    //     return $copy;
    // }

    // public function __toString()
    // {
    //     Helper::printLabelValue("isoCountry", $this->isoCountry);
    //     Helper::printLabelValue("countryName", $this->countryName);
    //     Helper::printLabelValue("isUE", $this->isUE);
    //     Helper::printLabelValue("vat", $this->vat);
    // }
}
