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
        try {
            //code...
            $countries = Country::getCountries();
            $isoCountries = $countries->getKeys();
            $isoCountry = $addressMap->get(Map::isoCountry);
            if (!in_array($isoCountry, $isoCountries)) {
                $response->addErrorStation("ER1", MyError::FATAL_ERROR);
            } else {
                $countryName = $countries->get($isoCountry, Map::countryName);
                $addresses = $this->getAddresses();
                $address = $addressMap->get(Map::address);
                $zipcode = $addressMap->get(Map::zipcode);
                $sequence = Address::buildSequence($address, $zipcode, $countryName);
                $sequences = $addresses->getKeys();
                if (in_array($sequence, $sequences)) {
                    $response->addErrorStation("ER29", Address::INPUT_ADDRESS);
                } else {
                    $addressMap->put($countryName, Map::countryName);
                    $addressObj = new Address($addressMap);
                    $userID = $this->getUserID();
                    $addressObj->insertAddress($response, $userID);
                }
            }
        } catch (\Throwable $th) {
            // $response->addError(get_object_vars($th), "Throw");
            echo $th;
        }
    }
    /*———————————————————————————— ALTER MODEL UP ———————————————————————————*/
}
