<?php

require_once 'model/users-management/Visitor.php';
require_once 'model/tools-management/Address.php';

abstract class User extends  Visitor
{

    // protected $password;

    /**
     * Holds the mail of the user
     * @var string
     */
    protected $mail;

    /**
     * Holds the firstname of the user
     * @var string
     */
    protected $firstname;

    /**
     * Holds the lastname of the user
     * @var string
     */
    protected $lastname;

    /**
     * Holds the birthday of the user
     * @var string
     */
    protected $birthday;

    /**
     * Holds the sexe of the user
     * @var string
     */
    protected $sexe;

    /**
     * Holds User's addresses
     * + use address sequence as access key
     * @var Map
     */
    protected $addresses;

    /**
     * Holds user's db line
     * + this attribut is used to avoid multiple request for each children
     * @var string[]
     */
    protected $userLine;

    /**
     * Constructor
     * @param string $CLT_VAL value of the user's Client  cookie (Cookie::COOKIE_CLT)
     */
    protected function __construct($CLT_VAL)
    {
        // $tab = $this->select("SELECT * FROM `Users` WHERE `userID` = '$userID'");
        $sql = "SELECT u.* 
                FROM `Users-Cookies` uc
                JOIN `Users` u ON uc.`userId` = u.`userID`
                WHERE uc.`cookieId` = '" . Cookie::COOKIE_CLT . "'
                AND uc.`cookieValue` = '$CLT_VAL'";
        $tab = $this->select($sql);
        if (count($tab) != 1) {
            throw new Exception("User with Client cookie '$CLT_VAL' don't exist");
        }
        $this->userLine = $tab[0];
        $this->userID = $this->userLine["userID"];
        $this->setCookies();
        $VIS_VAL = $this->getCookie(Cookie::COOKIE_VIS)->getValue();
        parent::__construct($VIS_VAL);

        $this->setDate = $this->userLine["setDate"];
        $this->lang = new Language($this->userLine["lang_"]);
        $this->mail = $this->userLine["mail"];
        $this->firstname = $this->userLine["firstname"];
        $this->lastname = $this->userLine["lastname"];
        $this->birthday = $this->userLine["birthday"];
        $this->sexe = $this->userLine["sexe_"];
    }

    /**
     * Setter for address
     */
    private function setAddress()
    {
        $this->addresses = new Map();
        $userID = $this->getUserID();
        $sql = "SELECT * FROM `Addresses` WHERE `userId` = '$userID' ORDER BY `Addresses`.`setDate` DESC;";
        $tab = $this->select($sql);
        if (!empty($tab)) {
            foreach ($tab as $tabLine) {
                $addressMap = new Map();
                $addressMap->put($tabLine["address"], Map::address);
                $addressMap->put($tabLine["appartement"], Map::appartement);
                $addressMap->put($tabLine["province"], Map::province);
                $addressMap->put($tabLine["city"], Map::city);
                $addressMap->put($tabLine["zipcode"], Map::zipcode);
                $addressMap->put($tabLine["country_"], Map::countryName);
                $addressMap->put($tabLine["phoneNumber"], Map::phone);
                $addressMap->put($tabLine["setDate"], Map::setDate);
                $address = new Address($addressMap);
                $sequence = Address::buildSequence($tabLine["address"], $tabLine["zipcode"], $tabLine["country_"]);
                $this->addresses->put($address, $sequence);
            }
        }
    }

    /**
     * Getter for User's addresses
     * @return Map User's addresses
     */
    public function getAddresses()
    {
        (!isset($this->addresses)) ? $this->setAddress() : null;
        return $this->addresses;
    }

    /**
     * To get the address with the given sequence
     * @param string $sequence identifiant of an address
     * + sequence = "address|zipcode|country"
     * @return Address|null User's addresses
     */
    public function getAddress($sequence)
    {
        $address = null;
        $addresses  = $this->getAddresses();
        $keys = $addresses->getKeys();
        foreach ($keys as $key) {
            if ($key == $sequence) {
                $address = $addresses->get($key);
            }
        }
        return $address;
    }

    /*———————————————————————————— ALTER MODEL DOWN —————————————————————————*/
    /**
     * To add new address
     * @param Response $response to push in result or accured error
     * @param Map $addressMap map that contain datas submited for a sign up
     * + $addressMap[Map::address] Holds address submited
     * + $addressMap[Map::appartement] Holds appartement submited
     * + $addressMap[Map::province] Holds province submited
     * + $addressMap[Map::city] Holds city submited
     * + $addressMap[Map::zipcode] Holds zipcode submited
     * + $addressMap[Map::isoCountry] Holds country submited
     * + $addressMap[Map::phone] Holds phone submited
     */
    public function addAddress(Response $response, Map $addressMap)
    {
        $countries = Country::getCountries();
        $isoCountries = $countries->getKeys();
        $isoCountry = $addressMap->get(Map::isoCountry);
        if (!in_array($isoCountry, $isoCountries)) {
            $response->addErrorStation("ER1", MyError::FATAL_ERROR);
        } else {
            $countryName = $countries->get($isoCountry, Map::countryName);
            // $addresses = $this->getAddresses();
            $address = $addressMap->get(Map::address);
            $zipcode = $addressMap->get(Map::zipcode);
            $sequence = Address::buildSequence($address, $zipcode, $countryName);
            // $sequences = $addresses->getKeys();
            // if (in_array($sequence, $sequences)) {
            if (!empty($this->getAddress($sequence))) {
                $response->addErrorStation("ER29", Address::INPUT_ADDRESS);
            } else {
                $addressMap->put($countryName, Map::countryName);
                $addressObj = new Address($addressMap);
                $userID = $this->getUserID();
                $addressObj->insertAddress($response, $userID);
            }
        }
    }

    /**
     * To select an address holds by the User
     * + if the address exist this function generate a cookie
     * @param Response $response to push in result or accured error
     * @param string $sequence address's id
     */
    public function selectAddress(Response $response, $sequence)
    {
        if (empty($this->getAddress($sequence))) {
            $response->addErrorStation("ER1", MyError::FATAL_ERROR);
        } else {
            // $sequence_json  = [Address::KEY_ADRS_SEQUENCE => $sequence];
            $value = json_encode($sequence);
            $this->generateCookie(Cookie::COOKIE_ADRS, $value);
        }
    }

    /**
     * To get the selected shipping address from session's datas ($_COOKIE)
     * @return Address|null the selected shipping address
     */
    public function getSelectedAddress()
    {
        $address = null;
        $cookie = $this->getCookie(Cookie::COOKIE_ADRS);
        if (!empty($cookie)) {
            $sequence_json = $cookie->getValue();
            $sequence = json_decode($sequence_json);
            // if (!empty($sequenceMap->{Address::KEY_ADRS_SEQUENCE})) {
            if (!empty($sequence)) {
                $address = $this->getAddress($sequence);
            }
        }
        return $address;
    }

    /*———————————————————————————— ALTER MODEL UP ———————————————————————————*/
}
