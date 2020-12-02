<?php
require_once 'ControllerSecure.php';


class ControllerDashboard extends ControllerSecure
{
    /**
     * Holds action function
     */
    private const ACTION_SHOPBAG = "shopbag";


    /**
     * Holds link (href)
     * + also used for ajax request
     */
    public const QR_ADD_ADRS = "dashboard/addAddress";
    public const QR_SHOPBAG = "dashboard/shopbag";
    public const QR_GET_ADRS_SET = "dashboard/getAddressesSet";

    /**
     * The default layout: the dashboard
     */
    public function index()
    {
        var_dump("The layout for the dashboard page");
        var_dump($_GET);
    }

    /**
     * The layout for the shopping bag page
     */
    public function shopbag()
    {
        $datasView = [];
        $this->generateView($datasView, $this->person, self::ACTION_SHOPBAG);
    }

    /**
     * The layout for the orders page
     */
    public function orders()
    {
        var_dump("The layout for the orders page");
        var_dump($_GET);
    }

    /**
     * To add an address to the Client
     */
    public function addAddress()
    {
        $response = new Response();
        /**
         * @var User */
        $person = $this->getPerson();
        $datasView = [];
        $country = Query::getParam(Country::INPUT_ISO_COUNTRY_ADRS);
        $address = $this->checkInput(
            $response,
            Address::INPUT_ADDRESS,
            Query::getParam(Address::INPUT_ADDRESS),
            [self::TYPE_ALPHANUM_SPACE_HYPHEN_UNDER],
            $person->getDataLength("Addresses", "address")
        );
        $appartement = $this->checkInput(
            $response,
            Address::INPUT_APPARTEMENT,
            Query::getParam(Address::INPUT_APPARTEMENT),
            [self::TYPE_ALPHANUM_SPACE_HYPHEN_UNDER],
            $person->getDataLength("Addresses", "appartement"),
            false
        );
        $province = $this->checkInput(
            $response,
            Address::INPUT_PROVINCE,
            Query::getParam(Address::INPUT_PROVINCE),
            [self::TYPE_STRING_SPACE_HYPHEN_UNDER],
            $person->getDataLength("Addresses", "province")
        );
        $city = $this->checkInput(
            $response,
            Address::INPUT_CITY,
            Query::getParam(Address::INPUT_CITY),
            [self::TYPE_STRING_SPACE_HYPHEN_UNDER],
            $person->getDataLength("Addresses", "city")
        );
        $zipcode = $this->checkInput(
            $response,
            Address::INPUT_ZIPCODE,
            Query::getParam(Address::INPUT_ZIPCODE),
            [self::TYPE_ALPHANUM_SPACE_HYPHEN_UNDER],
            $person->getDataLength("Addresses", "zipcode")
        );
        $phone = $this->checkInput(
            $response,
            Address::INPUT_PHONE,
            Query::getParam(Address::INPUT_PHONE),
            [self::NUMBER_INT],
            $person->getDataLength("Addresses", "phoneNumber"),
            false
        );
        if (!$response->containError()) {
            $addressMap = new Map();
            $addressMap->put($address, Map::address);
            $addressMap->put($appartement, Map::appartement);
            $addressMap->put($province, Map::province);
            $addressMap->put($city, Map::city);
            $addressMap->put($zipcode, Map::zipcode);
            $addressMap->put($country, Map::isoCountry);
            $addressMap->put($phone, Map::phone);
            $person->addAddress($response, $addressMap);
            if (!$response->containError()) {
                $response->addResult(self::QR_ADD_ADRS, true);

                $eventDatasMap = new Map();
                $eventDatasMap->put(Address::buildSequence($address, $zipcode, $country), Address::KEY_ADRS_SEQUENCE);
                $eventCode = "evt_cd_39";
                // $person->getNavigation()->handleEvent((new Response()), $person->getUserID(), $eventCode, $datasMap);
                $person->handleEvent($eventCode, $eventDatasMap);
            }
        }
        $this->generateJsonView($datasView, $response, $person);
    }
    
    /**
     * To get address set element
     */
    public function getAddressesSet()
    {
        $response = new Response();
        /**
         * @var User */
        $person = $this->getPerson();
        $datasView = [];
        if (!$person->hasCookie(Cookie::COOKIE_CLT)) {
            $response->addErrorStation("ER1", MyError::FATAL_ERROR);
        } else {
            $addressMap = $person->getAddresses();
            if (empty($addressMap->getKeys())) {
                $response->addErrorStation("ER1", MyError::FATAL_ERROR);
            } else {
                $datasView = [
                    "addressMap" => $addressMap
                ];
                $response->addFiles(self::QR_GET_ADRS_SET, 'view/Dashboard/files/addressSet.php');
            }
        }
        $this->generateJsonView($datasView, $response, $person);
    }
}
