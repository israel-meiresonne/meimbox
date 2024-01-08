<?php
require_once 'model/ModelFunctionality.php';
require_once 'model/special/Response.php';
class Address extends ModelFunctionality
{
    /**
     * @var string
     */
    protected $address;

    /**
     * @var string
     */
    protected $appartement;

    /**
     * @var string
     */
    protected $province;

    /**
     * @var string
     */
    protected $zipcode;

    /**
     * @var string
     */
    protected $city;

    /**
     * @var Country
     */
    protected $country;

    /**
     * @var string
     */
    protected $phone;

    // /**
    //  * Show if this address is the current one
    //  * @var boolean Set true if this the current address else false
    //  */
    // private $isActive;

    /**
     * Holds de date of the registration of this addresse
     * @var string DATETIME into format "YYYY-MM-DD HH:MM:SS"
     */
    protected $setDate;

    /**
     * Holds input name
     */
    public const KEY_ADRS_SEQUENCE = "key_adrs_sequence";

    /**
     * Holds input name
     */
    public const INPUT_ADDRESS =  "address";
    public const INPUT_APPARTEMENT =  "appartement";
    public const INPUT_PROVINCE =  "province";
    public const INPUT_CITY =  "city";
    public const INPUT_ZIPCODE =  "zipcode";
    public const INPUT_PHONE =  "phone";

    private const  SEQUENCE_SEPARATOR = "|";

    /**
     * Holds Configuration of address adder
     */
    public const CONF_ADRS_POP = "conf_adrs_pop";
    public const CONF_ADRS_FEED = "conf_adrs_feed";


    /**
     * Contructor
     * @param Map $addressMap map that contain datas submited for a sign up
     * + $addressMap[Map::address] Holds address
     * + $addressMap[Map::appartement] Holds appartement of the address
     * + $addressMap[Map::province] Holds province of the address
     * + $addressMap[Map::city] Holds city of the address
     * + $addressMap[Map::zipcode] Holds zipcode of the address
     * + $addressMap[Map::countryName] Holds country of the address
     * + $addressMap[Map::phone] Holds phone of the address
     * + $addressMap[Map::setDate] Holds creation date of the address
     */
    public function __construct(Map $addressMap)
    {
        $this->address = (!empty($addressMap->get(Map::address))) ? $addressMap->get(Map::address) : $this->ThrowEmptyFieldError(Map::address);
        $this->appartement = $addressMap->get(Map::appartement);
        $this->province = (!empty($addressMap->get(Map::province))) ? $addressMap->get(Map::province) : $this->ThrowEmptyFieldError(Map::province);
        $this->zipcode = (!empty($addressMap->get(Map::zipcode))) ? $addressMap->get(Map::zipcode) : $this->ThrowEmptyFieldError(Map::zipcode);
        $this->city = (!empty($addressMap->get(Map::city))) ? $addressMap->get(Map::city) : $this->ThrowEmptyFieldError(Map::city);
        $this->country = (!empty($addressMap->get(Map::countryName))) ? (new Country($addressMap->get(Map::countryName))) : $this->ThrowEmptyFieldError(Map::countryName);
        $this->phone = $addressMap->get(Map::phone);
        $this->setDate = (!empty($addressMap->get(Map::setDate))) ? $addressMap->get(Map::setDate) : $this->getDateTime();
    }

    /**
     * to throw error when field is empty
     * @param string $field name of the empty field
     */
    private function ThrowEmptyFieldError($field)
    {
        throw new Exception("This address field ('$field') can't be empty");
    }

    /**
     * To get address
     * @return string address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * To get appartement
     * @return string appartement
     */
    public function getAppartement()
    {
        return $this->appartement;
    }

    /**
     * To get province
     * @return string province
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * To get zipcode
     * @return string zipcode
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * To get city
     * @return string city
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * To get country
     * @return Country country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * To get phone
     * @return string phone
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * To get the creation date of the address
     * @return string the creation date of the address
     */
    public function getSetDate()
    {
        return $this->setDate;
    }

    /**
     * To get Address's sequence
     * @return string Address's sequence
     */
    public function getSequence()
    {
        return self::buildSequence($this->getAddress(), $this->getZipcode(), $this->getCountry()->getCountryName());
    }

    /**
     * To build a id for an address
     * + sequence = "address|zipcode|country"
     * @param string $address address
     * @param string $zipcode address's  zipcode
     * @param string $country country where is located the address
     * @return string a sequence for an address
     */
    public static function buildSequence(string $address, string $zipcode, string $country)
    {
        if (empty($address) || empty($zipcode) || empty($country)) {
            throw new Exception("The param address, zipcode and country can't be empty,  address:'$address', zipcode:'$zipcode', country:'$country',");
        }
        $sequence = $address . self::SEQUENCE_SEPARATOR . $zipcode . self::SEQUENCE_SEPARATOR . $country;
        return $sequence;
    }

    /*———————————————————————————— SCRUD DOWN —————————————————————————————————————————*/

    /**
     * To insert a new address
     * @param Response $response to push in result or accured error
     * @param string $userID User's id
     */
    public function insertAddress(Response $response, $userID)
    {
        $bracket = "(?,?,?,?,?,?,?,?,?)"; // regex \[value-[0-9]*\]
        $sql = "INSERT INTO `Addresses`(`userId`, `address`, `zipcode`, `country_`, `appartement`, `province`, `city`, `phoneNumber`, `setDate`) 
                VALUES " . $this->buildBracketInsert(1, $bracket);
        $values = [
            $userID,
            $this->getAddress(),
            $this->getZipcode(),
            $this->getCountry()->getCountryName(),
            $this->getAppartement(),
            $this->getProvince(),
            $this->getCity(),
            $this->getPhone(),
            $this->getSetDate(),
        ];
        $this->insert($response, $sql, $values);
    }

    /**
     * To insert a new address
     * @param Response $response to push in result or accured error
     * @param string $orderID the id of the order for with the BasketOrderd is for
     */
    public function insertDelivery(Response $response, $orderID)
    {
        $bracket = "(?,?,?,?,?,?,?,?,?)"; // regex \[value-[0-9]*\]
        $sql = "INSERT INTO `Orders-Addresses`(`orderId`, `address`, `zipcode`, `country_`, `appartement`, `province`, `city`, `phoneNumber`, `setDate`)
                VALUES " . $this->buildBracketInsert(1, $bracket);
        $values = [
            $orderID,
            $this->getAddress(),
            $this->getZipcode(),
            $this->getCountry()->getCountryName(),
            $this->getAppartement(),
            $this->getProvince(),
            $this->getCity(),
            $this->getPhone(),
            $this->getSetDate(),
        ];
        $this->insert($response, $sql, $values);
    }
}
