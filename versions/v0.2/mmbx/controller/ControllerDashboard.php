<?php
require_once 'ControllerSecure.php';


class ControllerDashboard extends ControllerSecure
{
    /**
     * Holds action function
     */
    private const ACTION_SHOPBAG = "shopbag";

    public const QR_ADD_ADDRESS = "dashboard/addAddress";

    /**
     * Holds page link (href)
     */
    public const HREF_SHOPBAG = "dashboard/shopbag";

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
        $datasView = [];
        $country = Query::getParam(Country::INPUT_ISO_COUNTRY);
        $address = $this->checkInput(
            $response,
            Address::INPUT_ADDRESS,
            Query::getParam(Address::INPUT_ADDRESS),
            [self::TYPE_ALPHANUM_SPACE_HYPHEN_UNDER],
            $this->person->getDataLength("Addresses", "address")
        );
        $appartement = $this->checkInput(
            $response,
            Address::INPUT_APPARTEMENT,
            Query::getParam(Address::INPUT_APPARTEMENT),
            [self::TYPE_ALPHANUM_SPACE_HYPHEN_UNDER],
            $this->person->getDataLength("Addresses", "appartement"),
            false
        );
        $province = $this->checkInput(
            $response,
            Address::INPUT_PROVINCE,
            Query::getParam(Address::INPUT_PROVINCE),
            [self::TYPE_STRING_SPACE_HYPHEN_UNSER],
            $this->person->getDataLength("Addresses", "province")
        );
        $city = $this->checkInput(
            $response,
            Address::INPUT_CITY,
            Query::getParam(Address::INPUT_CITY),
            [self::TYPE_STRING_SPACE_HYPHEN_UNSER],
            $this->person->getDataLength("Addresses", "city")
        );
        $zipcode = $this->checkInput(
            $response,
            Address::INPUT_ZIPCODE,
            Query::getParam(Address::INPUT_ZIPCODE),
            [self::TYPE_ALPHANUM_SPACE_HYPHEN_UNDER],
            $this->person->getDataLength("Addresses", "zipcode")
        );
        $phone = $this->checkInput(
            $response,
            Address::INPUT_PHONE,
            Query::getParam(Address::INPUT_PHONE),
            [self::NUMBER_INT],
            $this->person->getDataLength("Addresses", "phoneNumber"),
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
            $this->person->addAddress($response, $addressMap);
            (!$response->containError()) ? $response->addResult(self::QR_ADD_ADDRESS, true) : null;
        }
        $this->generateJsonView($datasView, $response, $this->person);
    }
}
