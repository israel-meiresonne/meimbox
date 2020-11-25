<?php
// namespace Oop\model;
// require "../../vendor/autoload.php";

require_once 'model/ModelFunctionality.php';

class Location extends ModelFunctionality
{
    /**
     * Holds ip used to get Location's datas
     * @string
     */
    private $ip;

    /**
     * Holds status of the request to the location API
     * value: success|fail
     * @var string
     */
    private $status;

    /**
     * Holds Location's message if the request fail
     * @var string
     */
    private $message;

    /**
     * Holds Location's continent
     * @var string
     */
    private $continent;

    /**
     * Holds continent code Location's continent
     * @var string
     */
    private $continentCode;

    /**
     * Holds name of Location's country
     * @var string
     */
    private $countryName;

    /**
     * Holds iso country code of Location's country
     * @var string
     */
    private $isoCountry;

    /**
     * Holds name of Location's region
     * @var string
     */
    private $regionName;

    /**
     * Holds Location's city
     * @var string
     */
    private $city;

    /**
     * Holds Location's district (subdivision of city)
     * @var string
     */
    private $district;

    /**
     * Holds Location's zip code
     * @var string
     */
    private $zip;

    /**
     * Holds Location's latitude
     * @var float
     */
    private $latitude;

    /**
     * Holds Location's longitude
     * @var float
     */
    private $longitude;

    /**
     * Holds Location's timezone
     * + i.e.: Europe/Brussels
     * @var string
     */
    private $timezone;

    /**
     * Holds Location's timezone
     * + i.e.: Europe/Brussels
     * @var int
     */
    private $offset;

    /**
     * Holds Location's iso currency code
     * @var string
     */
    private $isoCurrency;

    /**
     * Holds name of the internet service provider(ISP)
     * + i.e.: Proximus
     * @var string
     */
    private $isp;

    /**
     * Holds ISP's company name
     * + i.e.:Belgacom SA
     * @var string
     */
    private $org;

    /**
     * Holds ISP's AS number and organization separated by space (RIR). 
     * + i.e.: AS5432 Proximus NV
     * + Note: Empty for IP blocks not being announced in BGP tables.
     * @var string
     */
    private $as;

    /**
     * Holds ISP's AS name
     * + i.e.: PROXIMUS-ISP-AS
     * @var string
     */
    private $asname;

    /**
     * Holds reverse DNS of the IP
     * + i.e.: 155.75-244-81.adsl-dyn.isp.belgacom.be
     * Note: can delay response
     * @var string
     */
    private $reverse;

    /**
     * Set true if device requesting is a mobile else false
     * @var bool
     */
    private $mobile;

    /**
     * Set true if the device requesting is using a Proxy, VPN or Tor exit 
     * address else false
     * @var bool
     */
    private $proxy;

    /**
     * Set true it's Hosting, colocated or data center else false
     * @var bool
     */
    private $hosting;

    private const SUCCESS = "success";

    /**
     * Constructor
     * @param string $ip ip to localise
     */
    public function __construct($ip = null)
    {
        $endpoint = $this->getEndpoint($ip);
        $this->ip = (isset($ip)) ? $ip : $endpoint->query;
        $this->status = strtolower($endpoint->status);
        if ($endpoint->status == self::SUCCESS) {
            $this->continent = strtolower($endpoint->continent);
            $this->continentCode = strtolower($endpoint->continentCode);
            $this->countryName = strtolower($endpoint->country);
            $this->isoCountry = strtolower($endpoint->countryCode);
            $this->regionName = strtolower($endpoint->regionName);
            $this->city = strtolower($endpoint->city);
            $this->district = strtolower($endpoint->district);
            $this->zip = strtolower($endpoint->zip);
            $this->latitude = strtolower($endpoint->lat);
            $this->longitude = strtolower($endpoint->lon);
            $this->timezone = strtolower($endpoint->timezone);
            $this->offset = strtolower($endpoint->offset);
            $this->isoCurrency = strtolower($endpoint->currency);
            $this->isp = strtolower($endpoint->isp);
            $this->org = strtolower($endpoint->org);
            $this->as = strtolower($endpoint->as);
            $this->asname = strtolower($endpoint->asname);
            $this->reverse = strtolower($endpoint->reverse);
            $this->mobile = strtolower($endpoint->mobile);
            $this->proxy = strtolower($endpoint->proxy);
            $this->hosting = strtolower($endpoint->hosting);
            $map = get_object_vars($this);
            foreach($map as $attribut => $value)
            {
                $this->{$attribut} = (isset($this->{$attribut}) && ($this->{$attribut} == '')) ? null : $value;
            }
        } else {
            $this->message = $endpoint->message;
        }
    }

    /**
     * use user's ip address to get all his localisation info
     * @return object with all location informations
     */
    private function getEndpoint($ip = null)
    {
        if (!isset($ip)) {
            $config = Configuration::getEnvironement();
            switch ($config) {
                case Configuration::ENV_DEV:
                    // $ip = "203.194.21.241"; // Australie Alexandria
                    // $ip = "138.197.157.60"; // Canada Toronto
                    // $ip = "77.73.241.154"; // Suisse Basel
                    // $ip = "126.29.117.191"; // Tokyo
                    // $ip = "197.157.210.199"; // Kinshasa
                    $ip = '2a02:a03f:5029:1300:dcb7:6c2c:9965:cd78'; // brussels capital
                    // $ip = $_SERVER['REMOTE_ADDR'];// Recuperation de l'IP du visiteur
                    break;
                case Configuration::ENV_PROD:
                    $ip = $_SERVER['REMOTE_ADDR'];
                    break;
            }
        }
        $endpoint = json_decode(file_get_contents('http://ip-api.com/json/' . $ip . '?lang=en&fields=66846719'));
        return $endpoint;
    }



    /**
     * Getter of the get country's Name
     * @return string the name of the location country
     */
    public function getcountryName()
    {
        return $this->countryName;
    }

    /**
     * To get
     * @return string protected copy of the Currency
     */
    public function getIsoCurrency()
    {
        return $this->isoCurrency;
    }
}
