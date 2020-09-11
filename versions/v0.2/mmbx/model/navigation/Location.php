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
        */
        $endpoint = json_decode(file_get_contents('http://ip-api.com/json/' . $ip . '?lang=en&fields=15984443')); //connection au serveur de ip-api.com et recuperation des données
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
