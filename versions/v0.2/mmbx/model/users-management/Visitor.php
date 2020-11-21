<?php

require_once 'controller/ControllerItem.php';
require_once 'model/ModelFunctionality.php';
require_once 'model/tools-management/Language.php';
require_once 'model/tools-management/Country.php';
require_once 'model/navigation/Location.php';
require_once 'model/tools-management/Measure.php';
require_once 'model/boxes-management/Basket.php';
// require_once 'model/special/Map.php';
require_once 'model/tools-management/Cookie.php';
require_once 'model/tools-management/Address.php';
require_once 'model/users-management/Visitor.php';

class Visitor extends ModelFunctionality
{
    /**
     * Holds Visitor's id
     * @var string
     */
    protected $userID;

    /**
     * Holds Visitor's hashed password
     * @var string
     */
    protected $hashcode;

    /**
     * Holds the Visitor's set date
     * @var string
     */
    protected $setDate;

    /**
     * The current language of the Visitor
     * @var Language 
     */
    protected $lang;

    /**
     * The current Currency of the Visitor
     * @var Currency
     */
    protected $currency;

    /**
     * The country of the Visitor. 
     * + If the real country of the Visitor is supported by the database it 
     * become his $country else the Visitor's country will be set with a 
     * default country value
     * @var Country
     */
    protected $country;

    /**
     * Hold location datas provided by the Visitor's IP address
     * @var Location
     */
    protected $location;

    /**
     * Hold data about the Visitor's device
     * @var Device
     */
    protected $device;

    /**
     * Hold Visitor's navigation data
     * @var Navigation
     */
    protected $navigation;

    /**
     * @var Basket
     */
    protected $basket;

    /**
     * Holds the visitor's measures
     * @var Measure[]
     */
    protected $measures;

    /**
     * Holds the visitor's cookies
     * @var Map a Map of Cookie
     * + use id of the cookie as acceess key
     */
    protected $cookies;

    /**
     * Holds how much measures can be holded
     * @var int
     */
    protected static $MAX_MEASURE;

    /**
     * Holds name of input
     */
    public const INPUT_SEX = "sex";
    public const INPUT_FIRSTNAME = "firstname";
    public const INPUT_LASTNAME = "lastname";
    public const INPUT_EMAIL = "email";
    public const INPUT_PASSWORD = "password";
    public const INPUT_CONFIRM_PASSWORD = "confirm_password";
    public const INPUT_CONDITION = "condition";
    public const INPUT_NEWSLETTER = "newsletter";

    /**
     * Holds privilege id
     * @var string
     */
    // public const PRIV_CLT = Cookie::COOKIE_CLT;
    // public const PRIV_ADM = Cookie::COOKIE_ADM;

    /**
     * @parram string $childCaller class of the caller (usualy User.php)
     */
    // public function __construct($childCaller = null)
    public function __construct($VIS_VAL)
    {
        // $isVisitor = empty($VIS_VAL);
        // $VIS_VAL = ($isVisitor) ? Cookie::getCookieValue(Cookie::COOKIE_VIS) : $VIS_VAL;

        // $tabLine = null;
        // if ($isVisitor && (!empty($VIS_VAL))) { // if empty its mean that the current user is a Visittor
        //     $sql = "SELECT u.* 
        //         FROM `Users-Cookies` uc
        //         JOIN `Users` u ON uc.`userId` = u.`userID`
        //         WHERE uc.`cookieId` = '" . Cookie::COOKIE_VIS . "'
        //         AND uc.`cookieValue` = '$VIS_VAL'";
        //     $tab = $this->select($sql);
        //     $tabLine = (count($tab) > 0) ? $tab[0] : null;
        // }

        // $this->setConstants();
        // $this->location = new Location();

        // $this->currency = ((!empty($tabLine)) && (!empty($tabLine["iso_currency"])))
        //     ? new Currency($tabLine["iso_currency"])
        //     : $this->location->getCurrency();

        // $this->country = ((!empty($tabLine)) && (!empty($tabLine["country_"])))
        //     ? new Country($tabLine["country_"])
        //     : new Country($this->location->getcountryName());

        // if ($isVisitor) {
        //     $this->userID = (!empty($tabLine)) ? $tabLine["userID"] : $this->generateCode(9, date("YmdHis")); // replacer par une sequance
        //     $this->setDate = (!empty($tabLine)) ? $tabLine["setDate"] : $this->getDateTime();
        //     $this->lang = (!empty($tabLine)) ? new Language($tabLine["lang_"]) : new Language();
        // }
        // $this->setMeasure();
        // ($isVisitor && (empty($tabLine))) ? $this->insertVisitor() : null;
        // $this->manageCookie(Cookie::COOKIE_VIS, false);

        $this->setConstants();
        $person = get_class($this);
        switch ($person) {
            case Visitor::class:
                if (empty($VIS_VAL)) {
                    $this->setNewVisitor();
                } else {
                    $this->setKnownVisitor($VIS_VAL);
                }
                break;
            case Administrator::class:
            case Client::class:
                # code...
                break;
            default:
                throw new Exception("Unkwon person '$person'");
                break;
        }
        $this->setMeasure();
        $this->manageCookie(Cookie::COOKIE_VIS, false);
    }

    /**
     * To create a new Visitor
     */
    private function setNewVisitor()
    {
        $this->userID = $this->generateCode(9, date("YmdHis")); // replacer par une sequance
        $this->location = new Location();
        $this->lang = new Language();
        $this->currency = $this->location->getCurrency();
        $this->country = new Country($this->location->getcountryName());
        $this->setDate = $this->getDateTime();
        $this->insertVisitor();
    }

    /**
     * To set a known Visitor
     * @param string $VIS_VAL Visitor's cookie used to access to his datas
     */
    private function setKnownVisitor($VIS_VAL)
    {
        $sql = "SELECT u.* 
        FROM `Users-Cookies` uc
        JOIN `Users` u ON uc.`userId` = u.`userID`
        WHERE uc.`cookieId` = '" . Cookie::COOKIE_VIS . "'
        AND uc.`cookieValue` = '$VIS_VAL'";
        $tab = $this->select($sql);
        if (empty($tab)) {
            throw new Exception("There's not Visitor with this Visitor Cookie '$VIS_VAL'");
        }
        if (count($tab) != 1) {
            throw new Exception("A visitor cookie('$VIS_VAL') can't be own by only one Visitor");
        }
        $tabLine = $tab[0];
        $this->userID = $tabLine["userID"];
        $this->location = new Location();
        $this->lang = new Language($tabLine["lang_"]);
        $this->currency = new Currency($tabLine["iso_currency"]);
        $this->country = new Country($tabLine["country_"]);
        $this->setDate = $tabLine["setDate"];
    }

    /**
     * Generate of update cookie with the id given in param
     * @param string $cookieID id of the cookie to managee
     * @param boolean $isSecure set true if it's a secued cookie else false
     * + a secued cookie is a cookie that will not be generated when it exist 
     * on Visitorr but not in db
     */
    protected function manageCookie($cookieID, $isSecure)
    {
        $cookieState = null;
        $userID = $this->getUserID();
        $usersCookiesMap = $this->getUsersCookiesMap($userID);
        $cookieIDs = $usersCookiesMap->getKeys();
        $inDb = in_array($cookieID, $cookieIDs);
        // $onUser = $this->existCookie($cookieID);
        // $onUser = (!empty($this->getCookie($cookieID)));
        $onUser = (!empty(Cookie::getCookieValue($cookieID)));
        if ($inDb && $onUser) {
            // --- cookie exist
            $cookieState = Cookie::STATE_UPDATE;
        } else if ($inDb && (!$onUser)) {
            // --- cookie expired
            $cookieState = Cookie::STATE_GIVE;
        } else if ((!$inDb) && $onUser) {
            // --- cookie invalid
            if ($isSecure) {
                throw new Exception("Can't generate a secured cookie that exist on user but not in db");
            }
            $cookieState = Cookie::STATE_GENERATE;
        } else if ((!$inDb) && (!$onUser)) {
            // --- cookie don't exist
            $cookieState = Cookie::STATE_GENERATE;
        }

        $cookies = $this->getCookies();
        switch ($cookieState) {
            case Cookie::STATE_GENERATE:
                $cookieValue = $this->generateDateCode(25);
                // $newCookie = Cookie::generateCookie($this->userID, $cookieID, $cookieValue);
                $newCookie = $this->generateCookie($cookieID, $cookieValue);
                $cookies->put($newCookie, $cookieID);
                break;
            case Cookie::STATE_UPDATE:
                $holdCookie = $this->getCookie($cookieID);
                $cookieValue = $holdCookie->getValue();
                $newCookie = $this->generateCookie($cookieID, $cookieValue);
                $cookies->put($newCookie, $cookieID);
                break;
            case Cookie::STATE_GIVE:
                // $holdCookie = $this->getCookie($cookieID);
                // $cookieValue = $holdCookie->getValue();
                $cookieValue = $usersCookiesMap->get($cookieID, Map::value);
                $newCookie = $this->generateCookie($cookieID, $cookieValue);
                $cookies->put($newCookie, $cookieID);
                break;
            default:
                throw new Exception("Unkwo cookie state, cookieState:'$cookieState");
                break;
        }
    }

    /**
     * Constructor used to create and give a new cookie
     * @param string $userID Visitor's id
     * @param string $cookieID id of the cookie
     * @param mixed $value value of the cookie
     */
    protected function generateCookie($cookieID, $value)
    {
        $userID = $this->getUserID();
        return Cookie::generateCookie($userID, $cookieID, $value);
    }

    /**
     * To destroy a cookie from Visitor and from db(optional)
     * @param string $userID Visitor's id
     * @param boolean $deleteDb set true to delete cookie from db else false or nothing
     */
    protected function destroyCookie($cookieID, $deleteDb = false)
    {
        $userID = $this->getUserID();
        return Cookie::destroyCookie($userID, $cookieID, $deleteDb);
    }

    /**
     * Initialize Visitor's constants
     */
    private function setConstants()
    {
        if (!isset(self::$MAX_MEASURE)) {
            self::$MAX_MEASURE = "MAX_MEASURE";
            self::$MAX_MEASURE = (int) $this->getConstantLine(self::$MAX_MEASURE)["stringValue"];
        }
    }

    /**
     * Setter for Visitor's basket
     */
    private function setBasket()
    {
        $this->basket = new Basket($this->userID, $this->getLanguage(), $this->getCountry(), $this->getCurrency());
    }

    /**
     * Setter for Visitor's measures
     */
    protected function setMeasure()
    {
        $this->measures = [];
        $sql = "SELECT * FROM `UsersMeasures` WHERE `userId` = '$this->userID'";
        $tab = $this->select($sql);
        if (count($tab) > 0) {
            foreach ($tab as $tabLine) {
                $values = [];
                $values["measureID"] = $tabLine["measureID"];
                $values["unitName"] = $tabLine["unit_name"];
                $values["measureName"] = $tabLine["measureName"];
                $values["bust"] = !empty($tabLine["userBust"]) ? (float) $tabLine["userBust"] : null;
                $values["arm"] = !empty($tabLine["userArm"]) ? (float) $tabLine["userArm"] : null;
                $values["waist"] = !empty($tabLine["userWaist"]) ? (float) $tabLine["userWaist"] : null;
                $values["hip"] = !empty($tabLine["userHip"]) ? (float) $tabLine["userHip"] : null;
                $values["inseam"] = !empty($tabLine["userInseam"]) ? (float) $tabLine["userInseam"] : null;
                $values["setDate"] = $tabLine["setDate"];
                $measureMap = Measure::getDatas4Measure($values);
                $measure = new Measure($measureMap);
                $key = $measure->getDateInSec();
                $this->measures[$key] = $measure;
            }
            krsort($this->measures);
            $this->sortMeasure();
            // $this->measures = [];
        }
    }

    // /**
    //  * Setter for Visitor's cookies
    //  * + check if cookie exist in db and $_COOKIE
    //  * + check if value of the cookie from $_COOKIE match the value in db
    //  */
    /**
     * Setter for Visitor's cookies
     * + get Visitor's cookies from db
     * + Note: only set cookie existing in db and on Vistor's driver 
     * and sharing the same value
     */
    protected function setCookies()
    {
        $this->cookies = new Map();
        $userID = $this->getUserID();
        $usersCookiesMap = $this->getUsersCookiesMap($userID);
        $cookieIDs = $usersCookiesMap->getKeys();
        if (!empty($cookieIDs)) {
            foreach ($cookieIDs as $cookieID) {
                $holdsCookieValue = Cookie::getCookieValue($cookieID);
                $value = $usersCookiesMap->get($cookieID, Map::value);
                if ((!empty($holdsCookieValue)) && ($holdsCookieValue == $value)) {
                    $setDate = $usersCookiesMap->get($cookieID, Map::setDate);
                    $settedPeriod = $usersCookiesMap->get($cookieID, Map::settedPeriod);
                    $cookie = new Cookie($cookieID, $value, $setDate, $settedPeriod);
                    $this->cookies->put($cookie, $cookieID);
                }
            }
        }
    }

    /**
     * Getter for Visitor's id
     * @return string Visitor's id
     */
    public function getUserID()
    {
        return $this->userID;
    }

    /**
     * Check if an email exist in the db
     * + if email exist the hashcode is saved in attribut Visitor::hashcode
     * @param string $email the email to check
     * @return boolean true if email exist in db else false
     */
    private function emailExist($email)
    {
        $exist = false;
        $sql = "SELECT * FROM `Users` WHERE `mail` = '$email'";
        $tab = $this->select($sql);
        if (count($tab) == 1) {
            $this->hashcode = $tab[0]["password"];
            $exist = true;
        }
        return $exist;
    }

    /**
     * To get Visitor's hashcode
     * @param string $email the email to check
     * @return string|null Visitor's hashcode
     */
    protected function getHashcode($email)
    {
        $hashcode = null;
        if ((!isset($this->hashcode)) && $this->emailExist($email)) {
            $hashcode = $this->hashcode;
        } else {
            $hashcode = $this->hashcode;
        }
        return $hashcode;
    }

    /**
     * Getter for creation date of the Visitor
     * @return string creation date of the Visitor
     */
    public function getSetDate()
    {
        return $this->setDate;
    }

    /**
     * Getter of the Language
     * @return Language a protected copy of the Visitor's current language
     */
    public function getLanguage()
    {
        return $this->lang;
    }

    /**
     * To set Visitor's currency
     * @param string $isoCurrency new currency's iso code
     */
    public function setCurrency($isoCurrency)
    {
        $currency = $this->getCurrency();
        $currency->setCurrency($isoCurrency);
    }

    /**
     * Getter of the Currency
     * @return Currency a protected copy of the Visitor's current Currency
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * To set Visitor's country
     * @param string $countryName new country's name
     */
    private function setCountry($countryName)
    {
        $country = $this->getCountry();
        $country->setCountry($countryName);
    }
    /**
     * Getter of the Country
     * @return Country a protected copy of the Visitor's current Country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Getter for Visitor's basket
     * @return Basket Visitor's basket
     */
    public function getBasket()
    {
        (!isset($this->basket)) ? $this->setBasket() : null;
        return $this->basket;
    }

    /**
     * To get box product from Visitor's basket
     * @param Response $response where to strore results
     * @param string $boxID id of box where is the product
     * @param string $newBoxID id of box where move the product
     * @param string $prodID id of the product to move
     * @param string $sequence product's size sequence
     * @return BoxProduct|null box product from Visitor's basket
     */
    public function getProduct(Response $response, $prodID, $sequence, $boxID = null)
    {
        $product = null;
        try {
            $sizeObj = new Size($sequence);
        } catch (\Throwable $th) {
            $response->addErrorStation("ER1", MyError::FATAL_ERROR);
        }
        if (!$response->containError()) {
            $basket = $this->getBasket();
            $tabLine = $this->getProductLine($prodID);
            switch ($tabLine["product_type"]) {
                case BasketProduct::BASKET_TYPE:
                    $product = $basket->getBasketProduct($prodID, $sizeObj);
                    break;
                case BoxProduct::BOX_TYPE:
                    $box = $basket->getBoxe($boxID);
                    // $isBoxProd = ((!empty($product)) && ($product->getType() == BoxProduct::BOX_TYPE));
                    if (empty($box)) {
                        $response->addErrorStation("ER1", MyError::FATAL_ERROR);
                    }
                    if (!$response->containError()) {
                        $product = $box->getProduct($prodID, $sizeObj);
                    }
                    break;
                default:
                    throw new Exception("Unknow product type");
            }
        }
        return $product;
    }

    /**
     * To get Visitor's Cookies
     * @return Map
     */
    public function getCookies()
    {
        (!isset($this->cookies)) ? $this->setCookies() : null;
        return $this->cookies;
    }

    /**
     * To get a Cookie
     * @param string $cookieID id of the cookie to get
     * @return Cookie|null
     */
    public function getCookie($cookieID)
    {
        $cookies = $this->getCookies();
        return $cookies->get($cookieID);
    }

    // /**
    //  * To check if Visitor holds a cookie in his session with the given id
    //  * @param string $cookieID id of the cookie to look for
    //  * @return boolean true if Visitor holds a cookie in his session else false
    //  */
    // private function existCookie($cookieID)
    // {
    //     return (!empty(Cookie::getCookieValue($cookieID)));
    // }

    /**
     * Check if Visitor has a cookie on his driver
     * @param string $cookieID cookie to check
     * @return boolean true if has privilege else false
     */
    public function hasCookie($cookieID)
    {
        $cookieValue = Cookie::getCookieValue($cookieID);
        $hasCookie = isset($cookieValue);
        // switch ($cookieID) {
        //     case Cookie::COOKIE_CLT:
        //         // $hasCookie = $this->existCookie(Cookie::COOKIE_CLT);
        //         $hasCookie = (!empty($this->getCookie(Cookie::COOKIE_CLT)));
        //         break;
        //     case Cookie::COOKIE_ADM:
        //         // $hasCookie = $this->existCookie(Cookie::COOKIE_ADM);
        //         $hasCookie = (!empty($this->getCookie(Cookie::COOKIE_ADM)));
        //         break;
        //     case Cookie::COOKIE_ADRS:
        //         // $hasCookie = $this->existCookie(Cookie::COOKIE_ADRS);
        //         $hasCookie = (!empty($this->getCookie(Cookie::COOKIE_ADRS)));
        //         break;
        //     default:
        //         throw new Exception("This id of cookie don't exist, cookieID:$cookieID");
        //         break;
        // }
        return $hasCookie;
    }

    /**
     * To get the measure with the id given in param
     * @param string $measureID id of the measure to look for
     * @return Measure|null Measure if it's found else return null
     */
    public function getMeasure($measureID)
    {
        $found = false;
        $measures = $this->getMeasures();
        foreach ($this->measures as $key => $measure) {
            // $found = $this->measures[$key]->getMeasureID() == $measureID;
            $found = $measures[$key]->getMeasureID() == $measureID;
            if ($found) {
                return $this->measures[$key];
            }
        }
        return null;
    }

    /**
     * Getter of the Measures
     * @return Measure[] a protected copy of the Visitor's Measures
     */
    public function getMeasures()
    {
        (!isset($this->measures) ? $this->setMeasure() : null);
        return $this->measures;
        // return [];
    }

    /**
     * Getter of the maximum measure a Visitor can holds
     * @return int the maximum measure a Visitor can holds
     */
    public static function getMAX_MEASURE()
    {
        return self::$MAX_MEASURE;
    }

    /**
     * To get the access key of the measure with the id given in param
     * @param string $measureID id of the measure to look for
     * @return int|null access key of the measure if it's found else return null
     */
    private function getMeasureKey($measureID)
    {
        $found = false;
        foreach ($this->measures as $key => $measure) {
            $found = $this->measures[$key]->getMeasureID() == $measureID;
            if ($found) {
                return $key;
            }
        }
        return null;
    }

    /**
     * To check if there is a measure with the id given in param
     * @param string $measureID measure id to look for
     * @return boolean true if measure exist else false
     */
    public function existMeasure($measureID)
    {
        return !($this->getMeasure($measureID) === null);
    }

    /**
     * Sort measures in descending order, according to the key (BiGGER to LOWER)
     */
    private function sortMeasure()
    {
        krsort($this->measures);
    }

    /**
     * Delete from Visitor the measure with the id given in param
     * @param string $measureID id of the measure to delete
     * @param Response $response to push in result or accured error
     */
    private function destroyMeasure($response, $measureID)
    {
        $measure = $this->getMeasure($measureID);
        if (empty($measure)) {
            throw new Exception("Impossible to unset measure cause it don't exist:");
        }
        $sql = "SELECT * 
        FROM `UsersMeasures` um
        JOIN `Box-Products` bp ON um.measureID = bp.measureId
        WHERE um.userId = '$this->userID' AND bp.measureId = '$measureID'";
        $tab = $this->select($sql);

        if (count($tab) > 0) {
            $errStation = "ER16";
            $response->addErrorStation($errStation, MyError::FATAL_ERROR);
        } else {
            $measure->deleteMeasure($response, $this->userID);
            if (!$response->containError()) {
                $this->unsetMeasure($measureID);
            }
        }
    }

    /**
     * To remove a measure in Visitor's measure list following the measure's id
     * @param string $measureID measure's id
     */
    private function unsetMeasure($measureID)
    {
        $found = false;
        foreach ($this->measures as $key => $measure) {
            $found = $this->measures[$key]->getMeasureID() == $measureID;
            if ($found) {
                $this->measures[$key] = null;
                unset($this->measures[$key]);
            }
        }
        return null;
    }

    /**
     * Check if Visitor has a privilege
     * @param string $privilege privilege to look for
     * @return boolean true if has privilege else false
     */
    private function hasPrivilege($privilege)
    {
        // $privileges = $this->getPrivileges();
    }

    /**
     * 
     */
    public function unlockStock()
    {
        if (get_class($this) != Visitor::class) {
            $userID = $this->getUserID();
            $usersCookiesMap = $this->getUsersCookiesMap($userID);
            if (!empty($usersCookiesMap->get(Cookie::COOKIE_LCK))) {
                $response = new Response();
                $this->destroyCookie(Cookie::COOKIE_LCK, true);
                BoxProduct::deleteAllLcok($response, $userID);
            }
        }
        // var_dump($response);
    }

    /*———————————————————————————— MANAGE CLASS UP ——————————————————————————*/
    /*———————————————————————————— GET DB TABLEDOWN —————————————————————————*/

    /**
     * Getter for db's BrandsMeasures table
     * @return string[] db's BrandsMeasures table
     */
    public function getBrandMeasures()
    {
        return $this->getBrandMeasuresTable();
    }

    /**
     * Getter for db's MeasureUnits table
     * @return string[] db's MeasureUnits table
     */
    public function getUnits()
    {
        return $this->getUnitsTable();
    }

    /*———————————————————————————— GET DB TABLE UP ——————————————————————————*/
    /*———————————————————————————— ALTER VISITOR DOWN ———————————————————————*/
    /**
     * To update Visitor's country
     * @param Response  $response       to push in result or accured error
     * @param string    $newIsoCountry  new country's iso country
     */
    public function updateCountry(Response $response, $newIsoCountry)
    {
        $countries = Country::getCountries();
        $isoCountries = $countries->getKeys();
        if (!in_array($newIsoCountry, $isoCountries)) {
            $response->addErrorStation("ER1", MyError::FATAL_ERROR);
        } else {
            $countryName = $countries->get($newIsoCountry, Map::countryName);
            $isoCurrency = $countries->get($newIsoCountry, Map::isoCurrency);
            $this->setCountry($countryName);
            $this->setCurrency($isoCurrency);
            $this->updateVisitor($response);
        }
    }
    /*———————————————————————————— ALTER VISITOR UP —————————————————————————*/
    /*———————————————————————————— ALTER MODEL DOWN —————————————————————————*/


    /**
     * To sign up a user
     * @param Response $response to push in result or accured error
     * @param Map $upMap map that contain datas submited for a sign up
     * + $upMap[Map::sex] holds sex submited
     * + $upMap[Map::condition] holds if condition has been checked
     * + $upMap[Map::newsletter] holds if newsletter has been checked
     * + $upMap[Map::firstname] holds firstname submited
     * + $upMap[Map::lastname] holds lastname submited
     * + $upMap[Map::email] holds email submited
     * + $upMap[Map::password] holds password submited
     * + $upMap[Map::confirmPassword] holds confirm password submited
     */
    public function signUp(Response $response, Map $upMap)
    {
        $sexes = $this->getTableValues("Sexes");
        $sex = $upMap->get(Map::sex);
        if (!in_array($sex, $sexes)) {
            $response->addErrorStation("ER1", MyError::FATAL_ERROR);
        } else {
            $condition = $upMap->get(Map::condition);
            (!$condition) ? $response->addErrorStation("ER22", self::INPUT_CONDITION) : null;
            $email = $upMap->get(Map::email);
            ($this->emailExist($email)) ? $response->addErrorStation("ER23", self::INPUT_EMAIL) : null;
            $password = $upMap->get(Map::password);
            $confirmPassword = $upMap->get(Map::confirmPassword);
            ($password != $confirmPassword) ? $response->addErrorStation("ER24", self::INPUT_CONFIRM_PASSWORD) : null;
            if (!$response->containError()) {
                $this->prepareVisitorToClient($response, $upMap);
                if (!$response->containError()) {
                    $this->manageCookie(Cookie::COOKIE_CLT, true); // Allure_homme97
                }
            }
        }
    }

    /**
     * To sign in a user
     * @param Response $response to push in result or accured error
     * @param Map $upMap map that contain datas submited for a sign up
     * + $inMap[Map::email] holds email submited
     * + $inMap[Map::password] holds password submited
     * + $inMap[Map::newsletter] holds if remember has been checked
     */
    public function signIn(Response $response, Map $inMap)
    {
        /**
         * @var string */
        $email = $inMap->get(Map::email);
        if (!$this->emailExist($email)) {
            $response->addErrorStation("ER25", self::INPUT_EMAIL);
        } else {
            $password = $inMap->get(Map::password);
            $hashcode = $this->getHashcode($email);
            if (!$this->passMatchHash($password, $hashcode)) {
                $response->addErrorStation("ER26", self::INPUT_PASSWORD);
            } else {
                // $this->manageCookie(Cookie::COOKIE_CLT); // Allure_homme97
                $client = $this->getClient($response, $email);
                $this->visitorToClient($response, $client);
                if ($response->containError()) {
                }
            }
        }
    }

    /**
     * To Clientt with the email given
     * @param string $email email a Client account
     * @return  Client a Client account
     */
    private function getClient(Response $response, $email)
    {
        $sql = "SELECT * 
        FROM `Users` u
        JOIN `Users-Cookies` uc ON u.`userID` = uc.`userId`
        WHERE u.`mail` = '$email' AND uc.`cookieId` = '" . Cookie::COOKIE_CLT . "'";
        $tab = $this->select($sql);
        if (count($tab) != 1) {
            throw new Exception("There any Client token for this email, email: $email");
        }
        $tabLine = $tab[0];
        $CLT_VAL = $tabLine["cookieValue"];
        $client = new Client($CLT_VAL);
        return $client;
    }

    /**
     * To addition Visitor's datas with datas from his Client account
     * @param Response $response to push in result or accured error
     * @param Client $client Visitor's Client account
     */
    private function visitorToClient(Response $response, Client $client)
    {
        $userID_VIS = $this->getUserID();
        $userID_CLT = $client->getUserID();
        $this->updateVisitorToClient($response, $userID_VIS, $userID_CLT);
        if (!$response->containError()) {
            $this->deleteVisitorToClient($response, $userID_VIS);
            if (!$response->containError()) {
                (count($this->getMeasures()) > 0) ? $this->mergeMeasures($response, $client) : null;
                // if(!$response->containError()){ put this method in basket
                //     (count($this->getBasket()->getBasketProducts()) > 0) ? $this->getBasket()->mergeBasket($response, $client) : null;
                // }
            }
        }
    }

    /** 
     * Crypt the password passed in parm
     * @param string $password password to crypt
     * @return string password's hashcode
     */
    private function encrypt($password)
    {
        return password_hash(sha1($password), PASSWORD_BCRYPT);
    }

    /** 
     * Check if the hashcode of password passed match the hashcode given in param
     * @param string $password the password to check
     * @param string $hashcode the hashcode to match
     * @return boolean true if the password match the hashcode given in param else false
     */
    private function passMatchHash($password, $hashcode)
    {
        return password_verify(sha1($password), $hashcode);
    }

    /**
     * Add a new measure to Visitor
     * @param Response $response to push in result or accured error
     * @param Map $measureMap contain measure's submited datas
     * + $measureMap[Map::measureID] holds measure's measureID
     * + $measureMap[Map::unitName] holds measure's unit name
     * + $measureMap[Map::measureName] holds measure's name
     * + $measureMap[Map::bust] holds measure's Bust value
     * + $measureMap[Map::arm] holds measure's Arm value
     * + $measureMap[Map::waist] holds measure's Waist value
     * + $measureMap[Map::hip] holds measure's Hip value
     * + $measureMap[Map::inseam] holds measure's Inseam value
     */
    public function addMeasure(Response $response, Map $measureMap)
    {
        $measures = $this->getMeasures();
        if (count($measures) < self::$MAX_MEASURE) {
            // $this->checkMeasureInput($response);
            if (!$response->containError()) {
                // $measureDatas = Measure::getDatas4MeasurePOST();
                // $measure = new Measure($measureDatas);
                $measure = new Measure($measureMap);
                $userID = $this->getUserID();
                // $saveResponse = $measure->save($this->userID);
                $measure->insertMeasure($response, $userID);
                if (!$response->containError()) {
                    $key = $measure->getDateInSec();
                    $this->measures[$key] = $measure;
                    $this->sortMeasure();
                    $response->addResult(ControllerItem::QR_MEASURE_CONTENT, $this->measures);
                } /*else {
                    if (!$response->existErrorKey(MyError::FATAL_ERROR)) {
                        $errorMsg = "ER1";
                        $response->addErrorStation($errorMsg, MyError::FATAL_ERROR);
                    }
                }*/
            }
        } else {
            $errorMsg = "ER1";
            $response->addErrorStation($errorMsg, MyError::FATAL_ERROR);
        }
    }

    /**
     * Update a Visitor's measure
     * @param Response $response to push in result or accured error
     * @param Map $measureMap contain measure's submited datas
     * + $measureMap[Map::measureID] holds measure's measureID
     * + $measureMap[Map::unitName] holds measure's unit name
     * + $measureMap[Map::measureName] holds measure's name
     * + $measureMap[Map::bust] holds measure's Bust value
     * + $measureMap[Map::arm] holds measure's Arm value
     * + $measureMap[Map::waist] holds measure's Waist value
     * + $measureMap[Map::hip] holds measure's Hip value
     * + $measureMap[Map::inseam] holds measure's Inseam value
     */
    public function updateMeasure(Response $response, Map $measureMap)
    {
        // $this->checkMeasureInput($response);
        // if (!$response->containError()) {
        // $measureDatas = Measure::getDatas4MeasurePOST();
        // $newMeasure = new Measure($measureDatas);
        $measureID = $measureMap->get(Map::measureID);
        $newMeasure = new Measure($measureMap);
        $userID = $this->getUserID();

        $oldMeasure = $this->getMeasure($measureID);

        // var_dump("newMeasure", $newMeasure);
        // var_dump("oldMeasure", $oldMeasure);
        $oldMeasure->updateMeasure($response, $userID, $newMeasure);
        if (!$response->containError()) {
            $key = $this->getMeasureKey($measureID);
            $this->unsetMeasure($measureID);
            $this->measures[$key] = $newMeasure;
            $this->sortMeasure();
        } else {
            if (!$response->existErrorKey(MyError::FATAL_ERROR)) {
                $errorMsg = "ER1";
                $response->addErrorStation($errorMsg, MyError::FATAL_ERROR);
            }
        }
        // }
    }

    /**
     * Delete from database and Visitor the measure with the id given in param
     * @param Response $response to push in result or accured error
     * @param string $measureID measure id to delete
     */
    public function deleteMeasure(Response $response, $measureID)
    {
        if (count($this->measures) > 0) {
            $measure = $this->getMeasure($measureID);
            if (!empty($measure)) {
                $this->destroyMeasure($response, $measureID);
                // if ((!$response->isSuccess()) && (!$response->existErrorKey(MyError::FATAL_ERROR))) {
                if ($response->containError() && (!$response->existErrorKey(MyError::FATAL_ERROR))) {
                    $errorMsg = "ER1";
                    $response->addErrorStation($errorMsg, MyError::FATAL_ERROR);
                }
            }
        } else {
            $errStation = "ER1";
            $response->addErrorStation($errStation, MyError::FATAL_ERROR);
        }
    }

    /**
     * Check if it's still stock for the product submited by Visitor
     * + it's still stock mean that there size that fit the Visitor's submited size
     * @param Response $response where to strore results
     * @param string $prodID Product's id
     * @param string|null $sizeType holds the type of measure
     * + SIZE_TYPE_ALPHANUM => "alphanum_size";
     * + SIZE_TYPE_MEASURE => "measurement_size";
     * @param string|null $size holds a aphanumeric size
     * @param Map $sizeMap map that contain data to build a Size
     * + $sizeMap[Map::size] holds a alphanumeric value of size
     * + $sizeMap[Map::brand] holds a brand name
     * + $sizeMap[Map::measureID] holds a measure id
     * + $sizeMap[Map::cut] holds a measure's cut
     * @return boolean true if it's are still stock else false
     */
    public function stillStock(Response $response, $prodID, $sizeType, Map $sizeMap)
    {
        $stillStock = false;
        $tabLine = $this->getProductLine($prodID);
        if (!empty($tabLine)) {
            switch ($tabLine["product_type"]) {
                case BasketProduct::BASKET_TYPE:
                    $stillStock = $this->stillBasketProductStock($response, $prodID, $sizeType, $sizeMap);
                    break;
                case BoxProduct::BOX_TYPE:
                    $stillStock = $this->stillBoxProductStock($response, $prodID, $sizeType, $sizeMap);
                    break;
                default:
                    throw new Exception("Unknow product type");
            }
        } else {
            $errorMsg = "ER1";
            $response->addErrorStation($errorMsg, MyError::FATAL_ERROR);
        }
        return $stillStock;
    }

    /**
     * To check if still stock for basket poduct
     * @param Response $response where to strore results
     * @param string $prodID Product's id
     * @param string|null $sizeType holds the type of measure
     * + SIZE_TYPE_ALPHANUM => "alphanum_size";
     * + SIZE_TYPE_MEASURE => "measurement_size";
     * @param Map $sizeMap map that contain data to build a Size
     * + $sizeMap[Map::size] holds a alphanumeric value of size
     * + $sizeMap[Map::brand] holds a brand name
     * + $sizeMap[Map::measureID] holds a measure id
     * + $sizeMap[Map::cut] holds a measure's cut
     * @return boolean true if it's are still stock else false
     */
    private function stillBasketProductStock(Response $response, $prodID, $sizeType, Map $sizeMap)
    {
        $stillStock = false;
        $sizeObj = $this->extractSizeBasketProduct($response, $sizeType, $sizeMap);
        if (!$response->containError()) {
            $product = new BasketProduct($prodID, $this->lang, $this->country, $this->currency);
            $stillStock = $product->stillStock($sizeObj);
        }
        return $stillStock;
    }

    /**
     * Exctract the Size of the basket product from the input submited
     * @param Response $response where to strore results
     * @param string|null $sizeType holds the type of measure
     * + SIZE_TYPE_ALPHANUM => "alphanum_size";
     * + SIZE_TYPE_MEASURE => "measurement_size";
     * @param Map $sizeMap map that contain data to build a Size
     * + $sizeMap[Map::size] holds a alphanumeric value of size
     * + $sizeMap[Map::brand] holds a brand name
     * + $sizeMap[Map::measureID] holds a measure id
     * + $sizeMap[Map::cut] holds a measure's cut
     * @return Size|null Exctracted Size of the basket product
     */
    private function extractSizeBasketProduct(Response $response, $sizeType, Map $sizeMap)
    {
        $sizeObj = null;
        $this->checkSizeInput($response, BasketProduct::BASKET_TYPE, $sizeType, $sizeMap);
        if (!$response->containError()) {
            // $size = Query::getParam(Size::SIZE_TYPE_ALPHANUM);
            $size = $sizeMap->get(Map::size);
            $sequence = Size::buildSequence($size, null, null, null);
            $sizeObj = new Size($sequence);
            $quantity = $sizeMap->get(Map::quantity);
            (!empty($quantity)) ? $sizeObj->setQuantity($quantity) : null;
        }
        return $sizeObj;
    }

    /**
     * To check if still stock for basket poduct
     * @param Response $response where to strore results
     * @param string $prodID Product's id
     * @param string|null $sizeType holds the type of measure
     * + SIZE_TYPE_ALPHANUM => "alphanum_size";
     * + SIZE_TYPE_MEASURE => "measurement_size";
     * @param Map $sizeMap map that contain data to build a Size
     * + $sizeMap[Map::size] holds a alphanumeric value of size
     * + $sizeMap[Map::brand] holds a brand name
     * + $sizeMap[Map::measureID] holds a measure id
     * + $sizeMap[Map::cut] holds a measure's cut
     * @return boolean true if it's are still stock else false
     */
    private function stillBoxProductStock(Response $response, $prodID, $sizeType, Map $sizeMap)
    {
        $stillStock = false;
        $sizeObj = $this->extractSizeBoxProduct($response, $sizeType, $sizeMap);
        if (!$response->containError()) {
            $basket = $this->getBasket();
            $product = new BoxProduct($prodID, $this->getLanguage(), $this->getCountry(), $this->getCurrency());
            $product->selecteSize($sizeObj);

            // $boxProductsMap = $basket->extractBoxProducts();
            $boxProductsMap = Box::extractBoxProducts($basket->getBoxes());
            $prodIDs = $boxProductsMap->getKeys();
            $boxProducts = (in_array($prodID, $prodIDs)) ? $boxProductsMap->get($prodID) : [];
            array_push($boxProducts, $product);
            $sizesMap = Product::extractSizes(...$boxProducts);
            $sizeObjs = $this->keysToAscInt($sizesMap->getMap());

            $stillStock = $product->stillStock(...$sizeObjs);
        }
        return $stillStock;
    }

    /**
     * Exctract the Size of the box product from the input submited
     * @param Response $response where to strore results
     * @param string|null $sizeType holds the type of measure
     * + SIZE_TYPE_ALPHANUM => "alphanum_size";
     * + SIZE_TYPE_MEASURE => "measurement_size";
     * @param Map $sizeMap map that contain data to build a Size
     * + $sizeMap[Map::size] holds a alphanumeric value of size
     * + $sizeMap[Map::brand] holds a brand name
     * + $sizeMap[Map::measureID] holds a measure id
     * + $sizeMap[Map::cut] holds a measure's cut
     * @return Size|null Exctracted Size of the box product
     */
    private function extractSizeBoxProduct(Response $response, $sizeType, Map $sizeMap)
    {
        $sizeObj = null;
        $this->checkSizeInput($response, BoxProduct::BOX_TYPE, $sizeType, $sizeMap);
        if (!$response->containError()) {
            switch ($sizeType) {
                case Size::SIZE_TYPE_ALPHANUM:
                    $size = $sizeMap->get(Map::size);
                    $brand = $sizeMap->get(Map::brand);
                    $sequence = Size::buildSequence($size, $brand, null, null);
                    $sizeObj = new Size($sequence);
                    $quantity = $sizeMap->get(Map::quantity);
                    (!empty($quantity)) ? $sizeObj->setQuantity($quantity) : null;
                    break;
                case Size::SIZE_TYPE_MEASURE:
                    $measureID = $sizeMap->get(Map::measureID);
                    $cut = $sizeMap->get(Map::cut);
                    $sequence = Size::buildSequence(null, null, $measureID, $cut);
                    $sizeObj = new Size($sequence);
                    $quantity = $sizeMap->get(Map::quantity);
                    (!empty($quantity)) ? $sizeObj->setQuantity($quantity) : null;
                    break;
                default:
                    throw new Exception("Any size type match system's size types");
                    break;
            }
        }
        return $sizeObj;
    }


    /**
     * Check size datas posted
     * @param Response $response where to strore results
     * @param string $prodType product's type
     * @param string|null $sizeType holds the type of measure
     * + SIZE_TYPE_ALPHANUM => "alphanum_size";
     * + SIZE_TYPE_MEASURE => "measurement_size";
     * @param Map $sizeMap map that contain data to build a Size
     * + $sizeMap[Map::size] holds a alphanumeric value of size
     * + $sizeMap[Map::brand] holds a brand name
     * + $sizeMap[Map::measureID] holds a measure id
     * + $sizeMap[Map::cut] holds a measure's cut
     * @return boolean true if the data is correct else false
     */
    private function checkSizeInput(Response $response, string $prodType, $sizeType, Map $sizeMap)
    {
        switch ($prodType) {
            case BasketProduct::BASKET_TYPE:
                $size = $sizeMap->get(Map::size);
                $this->checkSizeAlphaNum($response, $size);
                if (!$response->containError()) {
                    return true;
                }
                break;
            case BoxProduct::BOX_TYPE:
                $this->checkSizeType($response, $sizeType);
                if (!$response->containError()) {
                    switch ($sizeType) {
                        case Size::SIZE_TYPE_ALPHANUM:
                            $size = $sizeMap->get(Map::size);
                            $this->checkSizeAlphaNum($response, $size);
                            if (!$response->containError()) {
                                $brand = $sizeMap->get(Map::brand);
                                $this->checkBrand($response, $brand);
                                if (!$response->containError()) {
                                    return true;
                                }
                            }
                            break;
                        case Size::SIZE_TYPE_MEASURE:
                            $measureID = $sizeMap->get(Map::measureID);
                            if (!empty($measureID)) {
                                if (!$this->existMeasure($measureID)) {
                                    $errorMsg = "ER1";
                                    $response->addErrorStation($errorMsg, MyError::FATAL_ERROR);
                                } else {
                                    $cut = $sizeMap->get(Map::cut);
                                    $this->checkCut($response, $cut);
                                    return true;
                                }
                            } else {
                                $station = "ER12";
                                $response->addErrorStation($station, Measure::KEY_MEASURE_ID);
                            }
                            break;
                        default:
                            throw new Exception("Any size type match system's size types");
                            break;
                    }
                }
                break;
            default:
                throw new Exception("Any product type match system's product types");
                break;
        }
        return false;
    }

    /**
     * Check if the size type is correct
     * @param Response $response where to strore results
     * @return boolean true if the size type is correct else false
     */
    private function checkSizeType(Response $response, $sizeType)
    {
        if (!empty($sizeType)) {
            if (($sizeType == Size::SIZE_TYPE_ALPHANUM) || ($sizeType == Size::SIZE_TYPE_MEASURE)) {
                return true;
            } else {
                $station = "ER1";
                $response->addErrorStation($station, MyError::FATAL_ERROR);
            }
        } else {
            $station = "ER9";
            $response->addErrorStation($station, Size::INPUT_SIZE_TYPE);
        }
        return false;
    }

    /**
     * Check if the char size is correct
     * @param Response $response where to strore results
     * @return boolean true if the char size is correct else false
     */
    private function checkSizeAlphaNum(Response $response, $size)
    {
        if (!empty($size)) {
            $sizeList = $this->getTableValues("supoortedSizes");
            if (in_array($size, $sizeList)) {
                return true;
            } else {
                $station = "ER1";
                $response->addErrorStation($station, MyError::FATAL_ERROR);
            }
        } else {
            $station = "ER11";
            $response->addErrorStation($station, Size::INPUT_ALPHANUM_SIZE);
        }
        return false;
    }

    /**
     * Check if the brand is correct
     * @param Response $response where to strore results
     * @return boolean true if the brand is correct else false
     */
    private function checkBrand(Response $response, $brand)
    {
        if (!empty($brand)) {
            $brandMap = $this->getBrandMeasuresTable();
            if (key_exists($brand, $brandMap)) {
                return true;
            } else {
                $errorMsg = "ER1";
                $response->addErrorStation($errorMsg, MyError::FATAL_ERROR);
            }
        }
        return false;
    }

    /**
     * Check if cut is correct
     * @param Response $response where to strore results
     * @return boolean true if cut is correct else false
     */
    private function checkCut(Response $response, $cut)
    {
        $cutMap = $this->getTableValues("cuts");
        $isCorret = (!empty($cut)) ? key_exists($cut, $cutMap) : false;
        if (!$isCorret) {
            $errorMsg = "ER1";
            $response->addErrorStation($errorMsg, MyError::FATAL_ERROR);
        }
        return $isCorret;
    }

    /**
     * To add new box in Visitor's basket
     * @param Response $response where to strore results
     * @param int $colorCode the encrypted value of box color
     */
    public function addBox(Response $response, $colorCode)
    {
        $country = $this->getCountry();
        $currency = $this->getCurrency();
        $boxMap = $this->getBoxMap($country, $currency);
        $boxColor = $this->decryptString($colorCode);
        if (key_exists($boxColor, $boxMap)) {
            $userID = $this->getUserID();
            $basket = $this->getBasket();
            $basket->addBox($response, $userID, $boxColor);
        } else {
            $errorMsg = "ER1";
            $response->addErrorStation($errorMsg, MyError::FATAL_ERROR);
        }
    }

    /**
     * To delete box from Visitor's basket
     * @param Response $response where to strore results
     * @param string $boxID id of box in Visitor's basket
     */
    public function deleteBox(Response $response, $boxID)
    {
        $basket = $this->getBasket();
        $box = $basket->getBoxe($boxID);
        if (empty($box)) {
            $response->addErrorStation("ER1", MyError::FATAL_ERROR);
        } else {
            $basket->deleteBox($response, $boxID);
        }
    }

    /**
     * To add new product in box of Visitor's basket
     * @param Response $response where to strore results
     * @param string $boxID id of box in Visitor's basket
     * @param string $prodID id of the product to add in box
     * @param string|null $sizeType holds the type of measure
     * + SIZE_TYPE_ALPHANUM => "alphanum_size";
     * + SIZE_TYPE_MEASURE => "measurement_size";
     * @param Map $sizeMap map that contain data to build a Size
     * + $sizeMap[Map::size] holds a alphanumeric value of size
     * + $sizeMap[Map::brand] holds a brand name
     * + $sizeMap[Map::measureID] holds a measure id
     * + $sizeMap[Map::cut] holds a measure's cut
     */
    public function addBoxProduct(Response $response, $boxID, $prodID, $sizeType, Map $sizeMap)
    {
        $basket = $this->getBasket();
        $box = $basket->getBoxe($boxID);
        $existProd = $this->existProductInDb($prodID);
        $isBoxProd = $this->getProductLine($prodID)["product_type"] == BoxProduct::BOX_TYPE;
        if ((empty($box)) || (!$existProd) || (!$isBoxProd)) {
            $response->addErrorStation("ER1", MyError::FATAL_ERROR);
        } else {
            if (!$basket->stillSpace($boxID)) {
                $fullRate = "(" . $box->getQuantity() . "/" . $box->getSizeMax() . ")";
                $errStation = "ER14" . $fullRate;
                $response->addErrorStation($errStation, ControllerItem::A_ADD_BXPROD);
            } else {
                $stillStock = $this->stillStock($response, $prodID, $sizeType, $sizeMap);
                if ((!$response->containError()) && $stillStock) {
                    $sizeObj = $this->extractSizeBoxProduct($response, $sizeType, $sizeMap);
                    if (!$response->containError()) {
                        $basket->addBoxProduct($response, $boxID, $prodID, $sizeObj);
                    }
                }
            }
        }
    }

    /**
     * To update box product's size
     * @param Response $response where to strore results
     * @param string $boxID id of box in Visitor's basket
     * @param string $prodID id of the product to update
     * @param string $sequence sequence of the holds size
     * @param string|null $sizeType holds the new type of measure
     * + SIZE_TYPE_ALPHANUM => "alphanum_size";
     * + SIZE_TYPE_MEASURE => "measurement_size";
     * @param Map $sizeMap map that contain data to build a Size
     * + $sizeMap[Map::size] holds the new alphanumeric value of size
     * + $sizeMap[Map::brand] holds the new brand name
     * + $sizeMap[Map::measureID] holds the new measure id
     * + $sizeMap[Map::cut] holds the new measure's cut
     * + $sizeMap[Map::quantity] holds the new quantity of product
     */
    public function updateBoxProduct(Response $response, $boxID, $prodID, $sequence, $sizeType, Map $sizeMap)
    {
        $newQty = $sizeMap->get(Map::quantity);
        if ($newQty <= 0) {
            $response->addErrorStation("ER17", Size::INPUT_QUANTITY);
        } else {
            $basket = $this->getBasket();
            $box = $basket->getBoxe($boxID);
            if (empty($box)) {
                $response->addErrorStation("ER1", MyError::FATAL_ERROR);
            } else {
                try {
                    $refSize = new Size($sequence);
                } catch (\Throwable $th) {
                    $response->addErrorStation("ER1", MyError::FATAL_ERROR);
                }
                if (!$response->containError()) {
                    $product = $box->getProduct($prodID, $refSize);
                    if (empty($product)) {
                        $response->addErrorStation("ER1", MyError::FATAL_ERROR);
                    } else {
                        $quantity = $product->getQuantity();
                        $needleSpace = $newQty - $quantity;
                        if (!$basket->stillSpace($boxID, $needleSpace)) {
                            $response->addErrorStation("ER18", Size::INPUT_QUANTITY);
                        } else {
                            $newSize = $this->extractSizeBoxProduct($response, $sizeType, $sizeMap);
                            if (!$response->containError()) {
                                $TrueHoldSize = $product->getSelectedSize();
                                $product->selecteSize($newSize);

                                // $boxProductsMap = $basket->extractBoxProducts();
                                $boxProductsMap = Box::extractBoxProducts($basket->getBoxes());
                                $boxProducts = $boxProductsMap->get($prodID);
                                $sizesMap = Product::extractSizes(...$boxProducts);
                                $sizeObjs = $this->keysToAscInt($sizesMap->getMap());
                                $stillStock = $product->stillStock(...$sizeObjs);

                                $product->selecteSize($TrueHoldSize);
                                if (!$response->containError()) {
                                    if (!$stillStock) {
                                        $errStation = ($sizeType == Size::SIZE_TYPE_ALPHANUM) ?  "ER13" : "ER32";
                                        $response->addErrorStation($errStation, Size::INPUT_SIZE_TYPE);
                                    } else {
                                        $product = $box->getProduct($prodID, $newSize);
                                        $newIstHold = ($newSize->getSequence() == $TrueHoldSize->getSequence());
                                        if ((!$newIstHold) && (!empty($product))) {
                                            $errStation = ($sizeType == Size::SIZE_TYPE_ALPHANUM) ? "ER34" : "ER33";
                                            $errKey = ($sizeType == Size::SIZE_TYPE_ALPHANUM) ? Size::SIZE_TYPE_ALPHANUM : Measure::KEY_MEASURE_ID;
                                            $response->addErrorStation($errStation, $errKey);
                                        } else {
                                            $basket->updateBoxProduct($response, $boxID, $prodID, $TrueHoldSize, $newSize);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * To move a boxproduct to a other box
     * @param Response $response where to strore results
     * @param string $boxID id of box where is the product
     * @param string $newBoxID id of box where move the product
     * @param string $prodID id of the product to move
     * @param string $sequence product's size sequence
     */
    public function moveBoxProduct(Response $response, $boxID, $newBoxID, $prodID, $sequence)
    {
        if ($boxID == $newBoxID) {
            $response->addErrorStation("ER1", MyError::FATAL_ERROR);
        } else {
            try {
                $sizeObj = new Size($sequence);
            } catch (\Throwable $th) {
                $response->addErrorStation("ER1", MyError::FATAL_ERROR);
            }
            if (!$response->containError()) {
                $basket = $this->getBasket();
                $box = $basket->getBoxe($boxID);
                $newBox = $basket->getBoxe($newBoxID);
                if ((empty($box)) || (empty($newBox))) {
                    $response->addErrorStation("ER1", MyError::FATAL_ERROR);
                } else {
                    $product = $box->getProduct($prodID, $sizeObj);
                    $isBoxProd = ((!empty($product)) && ($product->getType() == BoxProduct::BOX_TYPE));
                    if (!$isBoxProd) {
                        $response->addErrorStation("ER1", MyError::FATAL_ERROR);
                    } else {
                        $selectedSize = $product->getSelectedSize();
                        $quantity = $selectedSize->getQuantity();
                        if (!$basket->stillSpace($newBoxID, $quantity)) {
                            $errStation = "ER15";
                            $response->addErrorStation($errStation, ControllerItem::A_MV_BXPROD);
                        } else {
                            $basket->moveBoxProduct($response, $boxID, $newBoxID, $prodID, $selectedSize);
                        }
                    }
                }
            }
        }
    }

    /**
     * To delete a boxproduct
     * @param Response $response where to strore results
     * @param string $boxID id of box where is the product
     * @param string $prodID id of the product to delete
     * @param string $sequence product's size sequence
     */
    public function deleteBoxProduct(Response $response, $boxID, $prodID, $sequence)
    {
        try {
            $sampleSize = new Size($sequence);
        } catch (\Throwable $th) {
            $response->addErrorStation("ER1", MyError::FATAL_ERROR);
        }
        if (!$response->containError()) {
            $basket = $this->getBasket();
            $box = $basket->getBoxe($boxID);
            if (empty($box)) {
                $response->addErrorStation("ER1", MyError::FATAL_ERROR);
            } else {
                $product = $box->getProduct($prodID, $sampleSize);
                $isBoxProd = ((!empty($product)) && ($product->getType() == BoxProduct::BOX_TYPE));
                if (!$isBoxProd) {
                    $response->addErrorStation("ER1", MyError::FATAL_ERROR);
                } else {
                    $selectedSize = $product->getSelectedSize();
                    $basket->deleteBoxProduct($response, $boxID, $prodID, $selectedSize);
                }
            }
        }
    }

    /**
     * To add Basket's prices in response
     * @param Response $response where to strore results
     */
    public function addSummaryPrices(Response $response)
    {
        $basket = $this->getBasket();
        $total = $basket->getTotal()->getFormated();
        $subtotal = $basket->getSubTotal()->getFormated();
        $vat = $basket->getVatAmount()->getFormated();
        $quantity = $basket->getQuantity();
        $shipping = $basket->getShipping()->getFormated();
        $response->addResult(Basket::KEY_TOTAL, $total);
        $response->addResult(Basket::KEY_SUBTOTAL, $subtotal);
        $response->addResult(Basket::KEY_VAT, $vat);
        $response->addResult(Basket::KEY_SHIPPING, $shipping);
        $response->addResult(Basket::KEY_BSKT_QUANTITY, $quantity);
    }

    /*———————————————————————————— ALTER MODEL UP ———————————————————————————*/
    /*———————————————————————————— SCRUD DOWN ———————————————————————————————*/
    /**
     * To insert new Visitor in db
     */
    private function insertVisitor()
    {
        $response = new Response();
        $bracket = "(?,?,?,?,?)"; // regex \[value-[0-9]*\]
        $sql = "INSERT INTO `Users`(`userID`, `lang_`, `country_`, `iso_currency`, `setDate`) 
                VALUES " . $this->buildBracketInsert(1, $bracket);
        $values = [];
        array_push(
            $values,
            $this->getUserID(),
            $this->getLanguage()->getIsoLang(),
            $this->getCountry()->getCountryName(),
            $this->getCurrency()->getIsoCurrency(),
            $this->getSetDate()
        );
        $this->insert($response, $sql, $values);
    }

    /**
     * To update Visitor's datas
     * @param Response $response to push in results or accured errors
     */
    private function updateVisitor(Response $response)
    {
        $userID = $this->getUserID();
        $sql =
            "UPDATE `Users` SET
            `lang_`=?,
            `country_`=?,
            `iso_currency`=?
            WHERE `userID`='$userID'";
        $values = [];
        array_push(
            $values,
            $this->getLanguage()->getIsoLang(),
            $this->getCountry()->getCountryName(),
            $this->getCurrency()->getIsoCurrency()
        );
        $this->update($response, $sql, $values);
    }

    /**
     * To prepare Visitor to becoming a Client by giving him datas from sign up form
     * @param Response $response to push in results or accured errors
     *  contain the error thrown
     * @param Map $upMap map that contain datas submited for a sign up
     * + $upMap[Map::sex] holds sex submited
     * + $upMap[Map::condition] holds if condition has been checked
     * + $upMap[Map::newsletter] holdsif newsletter has been checked
     * + $upMap[Map::firstname] holds firstname submited
     * + $upMap[Map::lastname] holds lastname submited
     * + $upMap[Map::email] holds email submited
     * + $upMap[Map::password] holds password submited
     * + $upMap[Map::confirmPassword] holds confirm password submited
     */
    private function prepareVisitorToClient(Response $response, Map $upMap) // regex \[value-[0-9]*\]
    {
        $userID = $this->getUserID();
        $hashedPassword = $this->encrypt($upMap->get(Map::password));
        $newsletter = ($upMap->get(Map::newsletter)) ? 1 : 0;
        $sql =
            "UPDATE `Users` SET
            `mail`=?,
            `password`=?,
            `firstname`=?,
            `lastname`=?,
            `newsletter`=?,
            `sexe_`=?
            WHERE `userID`='$userID'";
        $values = [];
        array_push($values, $upMap->get(Map::email));
        array_push($values, $hashedPassword);
        array_push($values, $upMap->get(Map::firstname));
        array_push($values, $upMap->get(Map::lastname));
        array_push($values, $newsletter);
        array_push($values, $upMap->get(Map::sex));
        $this->update($response, $sql, $values);
    }

    /**
     * To transfer Visitor's datas to his Client account
     * @param Response $response to push in result or accured error
     * @param string $userID_VIS Visitor's id
     * @param string $userID_CLT Client's id
     */
    private function updateVisitorToClient(Response $response, $userID_VIS, $userID_CLT)
    {
        $sql =
            "UPDATE `Devices` SET `userId`= ? WHERE `userId`= ?;
            UPDATE `Pages` SET `userId`= ? WHERE `userId`= ?;
            UPDATE `Baskets-Box` SET `userId`= ? WHERE `userId`= ?;
            UPDATE `Basket-DiscountCodes` SET `userId`= ? WHERE `userId`= ?;";
        // UPDATE `Users-Cookies` SET `userId`= ? WHERE `userId`= ?;
        $values = [];
        // Devices
        array_push($values, $userID_CLT);
        array_push($values, $userID_VIS);
        // Pages
        array_push($values, $userID_CLT);
        array_push($values, $userID_VIS);
        // Users-Cookies
        // array_push($values, $userID_CLT);
        // array_push($values, $userID_VIS);
        // Baskets-Box
        array_push($values, $userID_CLT);
        array_push($values, $userID_VIS);
        // Basket-DiscountCodes
        array_push($values, $userID_CLT);
        array_push($values, $userID_VIS);
        $this->update($response, $sql, $values);
    }

    /**
     * To delete Visitor's datas
     * + used when datas are transfered to a Client account
     * @param Response $response to push in result or accured error
     * @param string $userID_VIS Visitor's id
     */
    private function deleteVisitorToClient(Response $response, $userID_VIS)
    {
        $sql =
            "DELETE FROM `Devices` WHERE `userId`= '$userID_VIS';
            DELETE FROM  `Pages` WHERE `userId`= '$userID_VIS';
            DELETE FROM `Box-Products` WHERE `boxId` IN (SELECT `boxId` FROM `Baskets-Box` WHERE `userId` = '$userID_VIS');
            DELETE FROM `Baskets-Box` WHERE `userId`= '$userID_VIS';
            DELETE FROM `Basket-DiscountCodes` WHERE `userId`= '$userID_VIS';
            DELETE FROM `Users-Cookies` WHERE `userId`= '$userID_VIS' AND `cookieId` = '" . Cookie::COOKIE_VIS . "';
            DELETE FROM `Users` WHERE `userID` = '$userID_VIS';";
        $this->delete($response, $sql, []);
        // DELETE FROM `Boxes` WHERE `boxID` NOT IN (SELECT bb.`boxId` FROM `Baskets-Box` bb JOIN `Boxes` b ON bb.`boxId` = b.`boxID`);
    }

    /**
     * To merge Visitor's measures with measure holds by his Client account
     * + if number of measure exceeds the max measure authorized it will 
     * delete that exceed from olders to newest
     * @param Response $response to push in result or accured error
     * @param Client $client Visitor's Client account
     */
    private function mergeMeasures(Response $response, Client $client)
    {
        $measures_VIS = $this->getMeasures();
        $measures_CLT = $client->getMeasures();
        $userID_VIS = $this->getUserID();
        $userID_CLT = $client->getUserID();
        /**
         * @var Measure[] */
        $keys = array_merge(array_keys($measures_VIS), array_keys($measures_CLT));
        $mergedMeasures = array_merge($measures_VIS, $measures_CLT);
        $measures = array_combine($keys, $mergedMeasures);
        krsort($measures); // order from newest to older
        $surplus = count($measures) - $this->getMAX_MEASURE();
        if ($surplus > 0) {
            $measures = $this->deleteExcessMeasures($response, $measures, $surplus, $client);
        }
        if (!$response->containError()) {
            foreach ($measures as $key => $measure) {
                if (key_exists($key, $measures_VIS)) {
                    $measure->insertMeasure($response, $userID_CLT);
                    if ($response->containError()) {
                        break;
                    } else {
                        $measure->deleteMeasure($response, $userID_VIS);
                        if ($response->containError()) {
                            break;
                        } else {
                            $measures[$key] = null;
                            unset($measures[$key]);
                        }
                    }
                }
            }
        }
    }

    /**
     * Delete measure that exceed the max measure authorized from older to newest
     * @param Measure[] $measures measure from Visitor and his Client account
     * @param string $userID_CLT Client's id
     * @return Measure[] measure stilling
     */
    private function deleteExcessMeasures(Response $response, $measures, $surplus, Client $client)
    {
        $measures_CLT = $client->getMeasures();
        $userID_CLT = $client->getUserID();

        ksort($measures); // order from older to newest
        $deleted = 0;
        $userID_VIS = $this->getUserID();
        foreach ($measures as $key => $measure) {
            if ($surplus <= $deleted) {
                break;
            } else {
                if (key_exists($key, $measures_CLT)) {
                    $measure->deleteMeasure($response, $userID_CLT);
                } else {
                    $measure->deleteMeasure($response, $userID_VIS);
                }
                if ($response->containError()) {
                    break;
                } else {
                    $measures[$key] = null;
                    unset($measures[$key]);
                }
            }
            $deleted++;
        }
        krsort($measures); // order from newest to older
        return $measures;
    }
}
