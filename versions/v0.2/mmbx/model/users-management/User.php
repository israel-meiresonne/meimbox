<?php

use Stripe\Stripe;

require_once 'model/users-management/Visitor.php';
require_once 'model/tools-management/Address.php';
require_once 'model/orders-management/payement/stripe/StripeAPI.php';
require_once 'model/orders-management/Order.php';
// require_once 'model/tools-management/mailers/BlueAPI/BlueAPI.php';

abstract class User extends Visitor
{

    // protected $password;

    /**
     * Holds the email of the user
     * @var string
     */
    protected $email;

    /**
     * Holds User's id in Stripe's system
     * @var string
     */
    protected $custoID;

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
     * Holds User's orders
     * + use creation date as access key
     * @var Map
     */
    protected $orders;

    /**
     * Holds user's db line
     * + this attribut is used to avoid multiple request for each children
     * @var string[]
     */
    protected $userLine;

    /**
     * Holds access to Stripe's API
     * @var StripeAPI
     */
    protected static  $stripeAPI;

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
        // $VIS_VAL = $this->getCookie(Cookie::COOKIE_VIS)->getValue();
        $usersCookiesMap = $this->getUsersCookiesMap($this->userID);
        $VIS_VAL = $usersCookiesMap->get(Cookie::COOKIE_VIS, Map::value);
        parent::__construct($VIS_VAL);

        $this->setDate = $this->userLine["setDate"];
        $this->lang = new Language($this->userLine["lang_"]);
        $this->currency = new Currency($this->userLine["iso_currency"]);
        $this->country = new Country($this->userLine["country_"]);
        $this->email = $this->userLine["mail"];
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
     * Setter for orders
     */
    private function setOrders()
    {
        $this->orders = new Map();
    }

    /**
     * To set User's id in Stripe's system
     */
    private function setCustoID()
    {
        $userID = $this->getUserID();
        $sql = "SELECT * FROM `StripeCheckoutSessions` WHERE `userId` = '$userID' 
                AND `custoID` IS NOT NULL 
                ORDER BY `setDate` DESC";
        $tab = $this->select($sql);
        if (!empty($tab)) {
            $this->custoID = $tab[0]["custoID"];
        } else {
            $this->custoID = "";
        }
    }

    /**
     * To get User's email
     * @return string User's email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * To get User's id in Stripe's system
     * @return string|null User's id in Stripe's system
     */
    public function getCustoIDStripe()
    {
        (!isset($this->custoID)) ? $this->setCustoID() : null;
        /* checking  custoID with empty() cause it's can be setted with an 
        empty string if this function has already be called */
        return (!empty($this->custoID)) ? $this->custoID : null;
    }

    /**
     * To get User's firstname
     * @return string User's firstname
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * To get User's lastname
     * @return string User's lastname
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * To get User's birthday
     * @return string User's birthday
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * To get User's sexe
     * @return string User's sexe
     */
    public function getSexe()
    {
        return $this->sexe;
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

    /**
     * To get User's orders
     * @return Map User's orders
     */
    public function getOrders()
    {
        (!isset($this->orders)) ? $this->setOrders() : null;
        return $this->orders;
    }

    /**
     * To get User's order with the given id
     * @param string $orderID id of a order
     * + return the last order if id is empty
     * @return Order|null order with the given id
     */
    public function getOrder($orderID)
    {
        // $order = null;
        // $orders = $this->getOrders();
        // $keys = $orders->getKeys();
        // if (empty($orderID)) {

        // } else if (!empty($keys)) {
        //     foreach ($keys as $key) {
        //         if ($orderID);
        //     }
        // }
    }

    /**
     * To get User's last order
     * @return Order|null last order passed by the User
     */
    public function getLastOrder()
    {
        $order = null;
        $orders = $this->getOrders();
        $keys = $orders->getKeys();
        if (!empty($keys)) {
            $key = $keys[0];
            $order = $orders->get($key);
        }
        return $order;
    }

    /**
     * To get access to the Stripe's API
     * @return StripeAPI access to the Stripe's API
     */
    private function getStripeAPI()
    {
        if (!isset(self::$stripeAPI)) {
            self::$stripeAPI = new StripeAPI();
        }
        return self::$stripeAPI;
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
        $countries = Country::getCountriesPriced();
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
    /*———————————————————————————— PAYEMENT DOWN ————————————————————————————*/
    /**
     * To create a new CheckoutSession
     * @param Response $response to push in result or accured error
     * @param string $payMethod payement method like [card, bancontact, ideal, etc...]
     * @return string id of the CheckoutSession created
     */
    public function createNewCheckout(Response $response, string $payMethod)
    {
        $id = null;
        $basket = $this->getBasket();
        if ($basket->getQuantity() <= 0) {
            $response->addErrorStation("ER31", MyError::FATAL_ERROR);
        } else {
            $soldOutProdMap = $basket->stillStock();
            $soldOutKeys = $soldOutProdMap->getKeys();
            if (!empty($soldOutKeys)) {
                    $response->addError("there's not enought stock", MyError::FATAL_ERROR);
                    // $response->addErrorStation("ER1", MyError::FATAL_ERROR);
                $response->addError($soldOutProdMap, Product::KEY_PROD_SOLD_OUT);
            } else {
                $lockedProductMap = $basket->stillUnlockedStock();
                $prodKeys = $lockedProductMap->getKeys();
                if (!empty($prodKeys)) {
                    $response->addError("there's locked stock", MyError::FATAL_ERROR);
                    $response->addError($lockedProductMap, Product::KEY_PROD_LOCKED);
                } else {
                    $userID = $this->getUserID();
                    $basket->lock($response, $userID);

                    $haveDelete = $basket->deleteEmptyBoxes($response);
                    (!empty($haveDelete)) ? $response->addResultStation(Response::RSP_NOTIFICATION, "US69") : null;
                    
                    $cookieValue = $this->generateDateCode(25);
                    $this->generateCookie(Cookie::COOKIE_LCK, $cookieValue);
                    try {
                        $stripeAPI = $this->getStripeAPI();
                        $stripeAPI->initializeNewCheckout($payMethod, $this);
                        $id = $stripeAPI->getCheckoutSessionId();
                    } catch (\Throwable $th) {
                        $response->addErrorStation("ER1", MyError::FATAL_ERROR);
                        $response->addError($th->__toString(), MyError::ADMIN_ERROR);
                    }
                }
            }
        }
        return $id;
    }

    /**
     * To handle all Stripe's events
     * @param Response $response to push in result or accured error
     * @return string|null the event occured
     */
    public function handleStripeEvents(Response $response)
    {
        $stripeAPI = $this->getStripeAPI();
        $stripeCheckoutID = $stripeAPI->getCheckoutSessionId();
        $this->createOrder($response, $stripeCheckoutID);
        return $stripeAPI->getEvent();
    }

    /**
     * To convert User's basket into a order
     * @param Response $response to push in result or accured error
     * @param string $stripeCheckoutID id of Stripe's session used to paid the order
     */
    private  function createOrder(Response $response, $stripeCheckoutID)
    {
        $userID = $this->getUserID();
        $basket = $this->getBasket();
        $this->manageCookie(Cookie::COOKIE_ADRS, false);
        $address = $this->getSelectedAddress();
        $order = new Order();
        $order->create($response, $userID, $stripeCheckoutID, $address, $basket);
        $this->destroyCookie(Cookie::COOKIE_LCK, true);
        $key = $order->getDateInSec();
        // $this->orders[$key] = $order;
        $orders = $this->getOrders();
        $orders->put($order, $key);
        $orders->sortKeyDesc();
        // krsort($this->orders);
    }
    /*———————————————————————————— PAYEMENT UP ——————————————————————————————*/
}
