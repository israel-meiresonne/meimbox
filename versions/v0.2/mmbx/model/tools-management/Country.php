<?php

require_once 'model/ModelFunctionality.php';
// require_once 'model/special/Map.php';

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

    /**
     * Acces key for country's iso code
     * @var string
     */
    public const KEY_ISO_CODE = "iso_country";

    /**
     * Holds input name
     */
    public const INPUT_ISO_COUNTRY = "iso_country";

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
     * Getter of the default country name in English
     * @return string The country's name in English
     */
    public function getCountryNameDefault()
    {
        return self::$DEFAULT_COUNTRY_NAME;
    }

    /**
     * Getter of the country's vat
     * @return string The country's vat
     */
    public function getVat()
    {
        return $this->vat;
    }

    /**
     * Getter of the country's vat in displayable format
     * @return string The country's vat in displayable format
     */
    public function getVatDisplayable()
    {
        $vat = $this->getVat();
        $display = number_format(($vat*100), 0, "", "")."%";
        return $display;
    }

    /**
     * To get countries supported and their datas
     * @return Map countries supported and their datas
     * $countriesMap[isoCountry] => [
     *      Map::countryName => string
     *      Map::isoCurrency => string 
     *      Map::isUE => boolean
     *      Map::vat => float
     * ]
     */
    public static function getCountries()
    {
        $coutries = parent::getCountriesDb();
        $countriesMap = new Map();
        foreach($coutries as $countryName => $datas){
            // $countriesMap->put($datas["isoCountry"], $countryName, Map::isoCountry);
            // $countriesMap->put($datas["iso_currency"], $countryName, Map::isoCurrency);
            // $countriesMap->put($datas["isUE"], $countryName, Map::isUE);
            // $countriesMap->put($datas["vat"], $countryName, Map::vat);
            $isoCountry = $datas["isoCountry"];
            $countriesMap->put($countryName, $isoCountry,  Map::countryName);
            $countriesMap->put($datas["iso_currency"], $isoCountry, Map::isoCurrency);
            $countriesMap->put($datas["isUE"], $isoCountry, Map::isUE);
            $countriesMap->put($datas["vat"], $isoCountry, Map::vat);
        }
        return $countriesMap;
    }
}
