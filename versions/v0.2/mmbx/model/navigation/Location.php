<?php
// namespace Oop\model;
// require "../../vendor/autoload.php";

require_once 'model/ModelFunctionality.php';
require_once 'model/tools-management/Currency.php';

class Location extends ModelFunctionality
{
    private $ip;

    /**
     * @var Currency
     */
    private $currency; // object

    private $city;
    private $zip;
    private $countryName;
    private $isoCountry;
    private $continent;
    private $continentCode;
    private $regionName;
    private $timezone;
    private $isp;
    private $org;
    private $asname;
    private $mobile;
    private $proxy;
    private $message;

    private const SUCCESS = "success";

    function __construct()
    {
        $endpoint = $this->getEndpoint();
        // if ($endpoint->status == "success") {
        if ($endpoint->status == self::SUCCESS) {
            $this->currency = new Currency(strtolower($endpoint->currency));
            $this->ip = strtolower($endpoint->query);
            $this->city = strtolower($endpoint->city);
            $this->zip = strtolower($endpoint->zip);
            $this->countryName = strtolower($endpoint->country);
            $this->isoCountry = strtolower($endpoint->countryCode);
            $this->continent = strtolower($endpoint->continent);
            $this->continentCode = strtolower($endpoint->continentCode);
            $this->regionName = strtolower($endpoint->regionName);
            $this->timezone = strtolower($endpoint->timezone);
            $this->isp = strtolower($endpoint->isp);
            $this->org = strtolower($endpoint->org);
            $this->asname = strtolower($endpoint->asname);
            $this->mobile = $endpoint->mobile;
            $this->proxy = $endpoint->proxy;
        } else {
            $this->message = $endpoint->message;
        }
    }

    /**
     * use user's ip address to get all his localisation info
     * @return object with all location informations
     */
    private function getEndpoint()
    {
        // $ip = "203.194.21.241"; // Australie Alexandria
        // $ip = "138.197.157.60"; // Canada Toronto
        // $ip = "77.73.241.154"; // Suisse Basel
        // $ip = "126.29.117.191"; // Tokyo
        // $ip = "197.157.210.199"; // Kinshasa
        $ip = '2a02:a03f:5029:1300:dcb7:6c2c:9965:cd78'; // brussels capital
        // $ip = $_SERVER['REMOTE_ADDR'];// Recuperation de l'IP du visiteur
        /* 
            status = [success | fail]
            message [private range | reserved range | invalid query] // included only when status is fail
            continent
            continentCode
            country
            countryCode
            regionName
            city
            zip
            timezone
            currency
            isp
            org
            asname
            mobile
            proxy 
            query => $ip

            status          success or fail
            message         included only when status is fail Can be one of the following: private range, reserved range, invalid query
            continent       Continent name
            continentCode   Two-letter continent code
            country         Country name
            countryCode     Two-letter country code ISO 3166-1 alpha-2
            region          Region/state short code (FIPS or ISO)
            regionName      Region/state
            city            City
            district        District (subdivision of city)
            zip             Zip code
            lat             Latitude
            lon             Longitude
            timezone        Timezone (tz)
            offset          Timezone UTC DST offset in seconds
            currency        National currency
            isp             ISP name
            org             Organization name
            as              AS number and organization, separated by space (RIR). Empty for IP blocks not being announced in BGP tables.
            asname          AS name (RIR). Empty for IP blocks not being announced in BGP tables.
            reverse         Reverse DNS of the IP (can delay response)
            mobile          Mobile (cellular) connection
            proxy           Proxy, VPN or Tor exit address
            hosting         Hosting, colocated or data center
            query           IP used for the query
            
        */
        // $endpoint = json_decode(file_get_contents('http://ip-api.com/json/' . $ip . '?lang=en&fields=15984443')); //connection au serveur de ip-api.com et recuperation des données
        $endpoint = json_decode(file_get_contents('http://ip-api.com/json/' . $ip . '?lang=en&fields=66846719')); //connection au serveur de ip-api.com et recuperation des données
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
     * Getter of a protected copy of the Currency
     * @return Currency protected copy of the Currency
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    // function __toString()
    // {

    //     Helper::printLabelValue("ip", $this->ip);
    //     $this->currency->__toString();
    //     Helper::printLabelValue("city", $this->city);
    //     Helper::printLabelValue("zip", $this->zip);
    //     Helper::printLabelValue("country", $this->countryName);
    //     Helper::printLabelValue("isoCountry", $this->isoCountry);
    //     Helper::printLabelValue("continent", $this->continent);
    //     Helper::printLabelValue("continentCode", $this->continentCode);
    //     Helper::printLabelValue("regionName", $this->regionName);
    //     Helper::printLabelValue("timezone", $this->timezone);
    //     Helper::printLabelValue("isp", $this->isp);
    //     Helper::printLabelValue("org", $this->org);
    //     Helper::printLabelValue("asname", $this->asname);
    //     Helper::printLabelValue("mobile", $this->mobile);
    //     Helper::printLabelValue("proxy", $this->proxy);
    //     Helper::printLabelValue("message", $this->message);
    // }
}
