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
     * Holds iso code of Location's region
     * @var string
     */
    private $regionCode;

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

    /**
     * Holds Location's creation date
     * @var bool
     */
    private $setDate;

    private const SUCCESS = "success";

    /**
     * Holds separator for id
     * @var string
     */
    public const SEPARATOR = "|";

    /**
     * Holds access key used to know if Visitor is located
     * @var string
     */
    public const KEY_LOCATED = "located";

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
            $this->regionCode = strtolower($endpoint->region);
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
            $this->mobile = ($endpoint->mobile);
            $this->proxy = ($endpoint->proxy);
            $this->hosting = ($endpoint->hosting);
            $map = get_object_vars($this);
            foreach ($map as $attribut => $value) {
                $this->{$attribut} = (isset($this->{$attribut}) && ($this->{$attribut} === '')) ? null : $value;
            }
        } else {
            $this->message = $endpoint->message;
        }
        $this->setDate = $this->getDateTime();
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
                    $ip = "197.157.210.199"; // Kinshasa
                    // $ip = '2a02:a03f:5029:1300:dcb7:6c2c:9965:cd78'; // brussels capital
                    // $ip = $_SERVER['REMOTE_ADDR'];// Recuperation de l'IP du visiteur
                    break;
                case Configuration::ENV_PROD:
                    $ip = $_SERVER['REMOTE_ADDR'];
                    break;
            }
        }
        // $ip = null;
        $endpoint = json_decode(file_get_contents('http://ip-api.com/json/' . $ip . '?lang=en&fields=66846719'));
        return $endpoint;
    }

    /**
     * To get Location ip
     * @return string Location ip
     */
    private function getIp()
    {
        return $this->ip;
    }

    /**
     * To get Location request's status
     * @return string Location request's status
     */
    private function getStatus()
    {
        return $this->status;
    }

    /**
     * To get fail message
     * @return string fail message
     */
    private function getMessage()
    {
        return $this->message;
    }
    /**
     * To get Location's continent
     * @return string Location's continent
     */
    private function getContinent()
    {
        return $this->continent;
    }

    /**
     * To get Location's continentCode
     * @return string Location's continentCode
     */
    private function getContinentCode()
    {
        return $this->continentCode;
    }

    /**
     * To get Location's region code
     * @return string Location's region code
     */
    public function getRegionCode()
    {
        return $this->regionCode;
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
     * To get Location's isoCountry
     * @return string Location's isoCountry
     */
    private function getIsoCountry()
    {
        return $this->isoCountry;
    }

    /**
     * To get Location's regionName
     * @return string Location's regionName
     */
    private function getRegionName()
    {
        return $this->regionName;
    }

    /**
     * To get Location's city
     * @return string Location's city
     */
    private function getCity()
    {
        return $this->city;
    }

    /**
     * To get Location's district
     * @return string Location's district
     */
    private function getDistrict()
    {
        return $this->district;
    }

    /**
     * To get Location's zip
     * @return string Location's zip
     */
    private function getZip()
    {
        return $this->zip;
    }

    /**
     * To get Location's latitude
     * @return float Location's latitude
     */
    private function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * To get Location's longitude
     * @return float Location's longitude
     */
    private function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * To get Location's timezone
     * @return string Location's timezone
     */
    private function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * To get Location's offset
     * @return int Location's offset
     */
    private function getOffset()
    {
        return $this->offset;
    }

    /**
     * To get
     * @return string protected copy of the Currency
     */
    public function getIsoCurrency()
    {
        return $this->isoCurrency;
    }

    /**
     * To get Location's isp
     * @return string Location's isp
     */
    private function getIsp()
    {
        return $this->isp;
    }

    /**
     * To get Location's org
     * @return string Location's org
     */
    private function getOrg()
    {
        return $this->org;
    }

    /**
     * To get Location's as
     * @return string Location's as
     */
    private function getAs()
    {
        return $this->as;
    }

    /**
     * To get Location's asname
     * @return string Location's asname
     */
    private function getAsname()
    {
        return $this->asname;
    }

    /**
     * To get Location's reverse
     * @return string Location's reverse
     */
    private function getReverse()
    {
        return $this->reverse;
    }

    /**
     * To get Location's mobile
     * @return string Location's mobile
     */
    private function isMobile()
    {
        return $this->mobile;
    }

    /**
     * To get Location's proxy
     * @return string Location's proxy
     */
    private function isProxy()
    {
        return $this->proxy;
    }

    /**
     * To get Location's hosting
     * @return string Location's hosting
     */
    private function isHosting()
    {
        return $this->hosting;
    }

    /**
     * To get Location's set date
     * @return string Location's set date
     */
    private function getSetDate()
    {
        return $this->setDate;
    }

    /**
     * To generate Location's id
     * @param string    $userID     Visitor's id
     * @return string Location's id
     */
    public function generateLocationID($userID)
    {
        if (!isset($userID)) {
            throw new Exception("Visitor's id can't be unsetted");
        }
        return $userID . self::SEPARATOR . $this->getSetDate();
    }

    /*—————————————————— SCRUD DOWN —————————————————————————————————————————*/

    /**
     * To insert Page in database
     * @param Response  $response   where to strore results
     * @param string    $userID     Visitor's id
     * @param string    $navDate    creation date of the current Page's Visited
     */
    public function insertLocation(Response $response, $userID, $navDate)
    {
        $bracket = "(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)"; // regex \[value-[0-9]*\]
        $sql = "INSERT INTO `Locations`(`userId`, `nav_date`, `locationDate`, `ip`, `status`, `message`, `continent`, `continentCode`, `country`, `countryCode`, `region`, `regionName`, `city`, `district`, `zip`, `lat`, `lon`, `timezone`, `offset`, `currency`, `isp`, `ispOrg`, `ispAs`, `asname`, `reverse`, `mobile`, `proxy`, `hosting`)
            VALUES " . $this->buildBracketInsert(1, $bracket);
        $values = [];
        $isMobile = (!is_null($this->isMobile())) ? (int)$this->isMobile() : null;
        $isProxy = (!is_null($this->isProxy())) ? (int)$this->isProxy() : null;
        $isHosting = (!is_null($this->isHosting())) ? (int)$this->isHosting() : null;
        array_push(
            $values,
            $userID,
            $navDate,
            $this->getSetDate(),
            $this->getIp(),
            $this->getStatus(),
            $this->getMessage(),
            $this->getContinent(),
            $this->getContinentCode(),
            $this->getcountryName(),
            $this->getIsoCountry(),
            $this->getRegionCode(),
            $this->getRegionName(),
            $this->getCity(),
            $this->getDistrict(),
            $this->getZip(),
            $this->getLatitude(),
            $this->getLongitude(),
            $this->getTimezone(),
            $this->getOffset(),
            $this->getIsoCurrency(),
            $this->getIsp(),
            $this->getOrg(),
            $this->getAs(),
            $this->getAsname(),
            $this->getReverse(),
            $isMobile,
            $isProxy,
            $isHosting
        );
        $this->insert($response, $sql, $values);
    }
}
