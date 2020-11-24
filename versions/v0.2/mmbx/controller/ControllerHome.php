<?php

require_once 'ControllerSecure.php';

class ControllerHome extends ControllerSecure
{
    public const A_SIGN_UP = "home/signUp";
    public const A_SIGN_IN = "home/signIn";
    public const QR_LOG_OUT = "home/logOut";
    public const QR_UPDATE_COUNTRY = "home/updateCountry";

    /**
     * The index layout
     */
    public function index()
    {
        $language = $this->person->getLanguage();
        $this->generateView([], $this->person);
    }

    /**
     * To sign up a new User
     */
    public function signUp()
    {
        $response = new Response();
        $datasView = [];
        // $newsletter = Query::getParam(Visitor::INPUT_NEWSLETTER);
        // $condition = Query::getParam(Visitor::INPUT_CONDITION);
        // $link = Query::getParam(self::INPUT_REDIRECT);
        // $link = $this->checkInput(
        //     $response,
        //     self::INPUT_REDIRECT,
        //     Query::getParam(self::INPUT_REDIRECT),
        //     [self::TYPE_LINK],
        //     $this->person->getDataLength("Users", "password")
        // );
        $newsletter = $this->checkInput(
            $response,
            Visitor::INPUT_NEWSLETTER,
            Query::getParam(Visitor::INPUT_NEWSLETTER),
            [self::CHECKBOX, self::TYPE_BOOLEAN],
            null,
            false
        );
        $condition = $this->checkInput(
            $response,
            Visitor::INPUT_CONDITION,
            Query::getParam(Visitor::INPUT_CONDITION),
            [self::CHECKBOX, self::TYPE_BOOLEAN],
            null,
            false
        );
        $sex = $this->checkInput(
            $response,
            Visitor::INPUT_SEX,
            Query::getParam(Visitor::INPUT_SEX),
            [self::CHECKBOX, self::STRING_TYPE]
        );
        $firstname = $this->checkInput(
            $response,
            Visitor::INPUT_FIRSTNAME,
            Query::getParam(Visitor::INPUT_FIRSTNAME),
            [self::NAME],
            $this->person->getDataLength("Users", "firstname")
        );
        $lastname = $this->checkInput(
            $response,
            Visitor::INPUT_LASTNAME,
            Query::getParam(Visitor::INPUT_LASTNAME),
            [self::NAME],
            $this->person->getDataLength("Users", "lastname")
        );
        $email = $this->checkInput(
            $response,
            Visitor::INPUT_EMAIL,
            Query::getParam(Visitor::INPUT_EMAIL),
            [self::EMAIL],
            $this->person->getDataLength("Users", "mail")
        );
        $password = $this->checkInput(
            $response,
            Visitor::INPUT_PASSWORD,
            Query::getParam(Visitor::INPUT_PASSWORD),
            [self::PASSWORD],
            $this->person->getDataLength("Users", "password")
        );
        // $confirmPassword = Query::getParam(Visitor::INPUT_CONFIRM_PASSWORD);
        $confirmPassword = $this->checkInput(
            $response,
            Visitor::INPUT_CONFIRM_PASSWORD,
            Query::getParam(Visitor::INPUT_CONFIRM_PASSWORD),
            [],
            null,
            true
        );

        if (!$response->containError()) {
            $upMap = new Map();
            $upMap->put($sex, Map::sex);
            $upMap->put($condition, Map::condition);
            $upMap->put($newsletter, Map::newsletter);
            $upMap->put($firstname, Map::firstname);
            $upMap->put($lastname, Map::lastname);
            $upMap->put($email, Map::email);
            $upMap->put($password, Map::password);
            $upMap->put($confirmPassword, Map::confirmPassword);
            $this->person->signUp($response, $upMap);
            if (!$response->containError()) {
                $response->addResult(self::A_SIGN_UP, true);
            }
        }
        $this->generateJsonView($datasView, $response, $this->person);
    }

    /**
     * To sign in a User
     */
    public function signIn()
    {
        $response = new Response();
        $datasView = [];
        $remember = $this->checkInput(
            $response,
            Visitor::INPUT_NEWSLETTER,
            Query::getParam(Visitor::INPUT_NEWSLETTER),
            [self::CHECKBOX, self::TYPE_BOOLEAN],
            null,
            false
        );
        $email = $this->checkInput(
            $response,
            Visitor::INPUT_EMAIL,
            Query::getParam(Visitor::INPUT_EMAIL),
            [],
            null
        );
        $password = $this->checkInput(
            $response,
            Visitor::INPUT_PASSWORD,
            Query::getParam(Visitor::INPUT_PASSWORD),
            [],
            null
        );

        if (!$response->containError()) {
            $email = Query::getParam(Visitor::INPUT_EMAIL);
            $password = Query::getParam(Visitor::INPUT_PASSWORD);
            $inMap = new Map();
            $inMap->put($email, Map::email);
            $inMap->put($password, Map::password);
            $inMap->put($remember, Map::remember);
            $this->person->signIn($response, $inMap);
            if (!$response->containError()) {
                $response->addResult(self::A_SIGN_IN, true);
            }
        }
        $this->generateJsonView($datasView, $response, $this->person);
    }

    /**
     * To log out a User
     */
    public function logOut()
    {
        $response = new Response();
        /**
         * @var  User */
        $person = $this->person;
        $person->logOut();
        $response->addResult(self::QR_LOG_OUT, true);
        $this->generateJsonView([], $response, $person);
    }

    /**
     * To update Visitor's Country
     */
    public function updateCountry()
    {
        $response = new Response();
        $person = $this->person;
        $datasView = [];
        // $inputName = Country::INPUT_ISO_COUNTRY . Country::INPUT_EXT_VISITOR;
        $inputName = Country::INPUT_ISO_COUNTRY_VISITOR;
        if (empty(Query::getParam($inputName))) {
            $response->addErrorStation("ER1", MyError::FATAL_ERROR);
        } else {
            $newIsoCountry = Query::getParam($inputName);
            $person->updateCountry($response, $newIsoCountry);
            if (!$response->containError()) {
                $person->addSummaryPrices($response);
            }
        }
        $this->generateJsonView($datasView, $response, $person);
    }

    /*———————————————————————————— TESTS DOWN ———————————————————————————————*/

    public function test()
    {
        header('content-type: application/json');
        // var_dump($_SERVER);
        require_once 'model/navigation/Device.php';
        new Device();
    }
    public function test_orderBoxes()
    {
        header('content-type: application/json');
        $person = $this->person;

        $orderID = "test";
        $boxes = $person->getBasket()->getBoxes();
        $response = new Response();
        // var_dump(Box::getProductToBox(...$boxes));
        echo str_repeat("-", 50) . " INSERT " . str_repeat("-", 50);
        echo "\n";
        var_dump(Box::orderBoxes($response, $boxes, $orderID));
        echo "\n";
        echo str_repeat("-", 50) . " RESPONSE " . str_repeat("-", 50);
        echo "\n";
        var_dump($response->getAttributs());
    }

    public function test_size()
    {
        header('content-type: application/json');
        $s = ["s", "xxs", "4xl", "m", "l"];
        // var_dump(Size::orderSizes($s));
        // var_dump(Size::extractBiggest($s));
        var_dump(Size::getSizeMeasure("s"));
        var_dump(Size::getSizeMeasure("m"));
    }

    public function test_measure()
    {
        header('content-type: application/json');
        $a = ["s", "xxs", "4xl", "m", "l"];
        // var_dump(Size::orderSizes($s));
        // var_dump(Size::extractBiggest($s));
        $s = Size::getSizeMeasure("m");
        $m = Size::getSizeMeasure("xl");
        $cut = "wide";
        var_dump(Measure::isUnderLimite($s, $m, $cut));
    }

    public function test_measureToRealSize()
    {
        header('content-type: application/json');
        $person = $this->person;
        $measure = $person->getMeasure("decrease_s_2");
        // $cut = "fit";
        $cut = "wide";
        $product = new BoxProduct(1, $person->getLanguage(), $person->getCountry(), $person->getCurrency());
        $sizesStock = $product->getSizeStock();
        var_dump(BoxProduct::measureToRealSize(array_keys($sizesStock), $measure, $cut));
    }

    public function test_convertSizeToRealSize()
    {
        header('content-type: application/json');
        $person = $this->person;
        $product = new BoxProduct(1, $person->getLanguage(), $person->getCountry(), $person->getCurrency());
        $size = "4xl";
        $brand = "asos";
        $measureID = null;
        $cut = null;
        $sequence = Size::buildSequence($size, $brand, $measureID, $cut);
        $sizeObj = new Size($sequence);
        $sizesStock = $product->getSizeStock();
        var_dump($product->convertSizeToRealSize($sizesStock, $sizeObj));
    }

    public function test_getRealSelectedSize()
    {
        header('content-type: application/json');
        $person = $this->person;
        $product = new BoxProduct(1, $person->getLanguage(), $person->getCountry(), $person->getCurrency());
        $size = null;
        $brand = null;
        $measureID = "decrease_m_6";
        $cut = "fit";
        $sequence = Size::buildSequence($size, $brand, $measureID, $cut);
        $sizeObj = new Size($sequence);
        $product->selecteSize($sizeObj);
        var_dump($product->getRealSelectedSize());
    }

    public function test_updateStock()
    {
        header('content-type: application/json');
        $person = $this->person;
        $products = [];

        $product = new BoxProduct(1, $person->getLanguage(), $person->getCountry(), $person->getCurrency());
        $size = "m";
        $brand = null;
        $measureID = null;
        $cut = null;
        $sequence = Size::buildSequence($size, $brand, $measureID, $cut);
        $sizeObj = new Size($sequence);
        $sizeObj->setQuantity(7);
        $product->selecteSize($sizeObj);
        array_push($products, $product);

        $product = new BoxProduct(1, $person->getLanguage(), $person->getCountry(), $person->getCurrency());
        $size = null;
        $brand = null;
        $measureID = "decrease_s";
        $cut = "fit";
        $sequence = Size::buildSequence($size, $brand, $measureID, $cut);
        $sizeObj = new Size($sequence);
        $sizeObj->setQuantity(2);
        $product->selecteSize($sizeObj);
        array_push($products, $product);

        $product = new BoxProduct(1, $person->getLanguage(), $person->getCountry(), $person->getCurrency());
        $size = null;
        $brand = null;
        $measureID = "a5rn30s0gtn2x2998j3000221";
        $cut = "fit";
        $sequence = Size::buildSequence($size, $brand, $measureID, $cut);
        $sizeObj = new Size($sequence);
        $sizeObj->setQuantity(2);
        $product->selecteSize($sizeObj);
        array_push($products, $product);


        $response = new Response();
        BoxProduct::updateStock($response, $products);
        var_dump($response->getAttributs());
    }

    public function test_decreaseStock()
    {
        header('content-type: application/json');
        $person = $this->person;
        $product = new BoxProduct(1, $person->getLanguage(), $person->getCountry(), $person->getCurrency());
        $sizesStock = $product->getSizeStock();

        $sizeObjs = [];

        $size = null;
        $brand = null;
        $measureID = "a5rn30s0gtn2x2998j3000221";
        $cut = "fit";
        $sequence = Size::buildSequence($size, $brand, $measureID, $cut);
        $sizeObj = new Size($sequence);
        $sizeObj->setQuantity(5);
        array_push($sizeObjs, $sizeObj);

        // $size = "m";
        // $brand = null;
        // $measureID = null;
        // $cut = null;
        // $sequence = Size::buildSequence($size, $brand, $measureID, $cut);
        // $sizeObj = new Size($sequence);
        // $sizeObj->setQuantity(11);
        // array_push($sizeObjs, $sizeObj);

        // $size = "m";
        // $brand = null;
        // $measureID = null;
        // $cut = null;
        // $sequence = Size::buildSequence($size, $brand, $measureID, $cut);
        // $sizeObj = new Size($sequence);
        // $sizeObj->setQuantity(11);
        // array_push($sizeObjs, $sizeObj);

        $supported = Size::getSupportedSizes(array_keys($sizesStock)[0]);
        // $response = new Response();
        var_dump($sizesStock);
        var_dump(BoxProduct::decreaseStock($supported, $sizesStock, $sizeObjs));
        // var_dump($response->getAttributs());
    }

    public function test_lock()
    {
        header('content-type: application/json');
        $person = $this->person;
        $products = [];

        $product = new BoxProduct(1, $person->getLanguage(), $person->getCountry(), $person->getCurrency());
        $size = "m";
        $brand = null;
        $measureID = null;
        $cut = null;
        $sequence = Size::buildSequence($size, $brand, $measureID, $cut);
        $sizeObj = new Size($sequence);
        $sizeObj->setQuantity(7);
        $product->selecteSize($sizeObj);
        array_push($products, $product);

        $product = new BoxProduct(1, $person->getLanguage(), $person->getCountry(), $person->getCurrency());
        $size = null;
        $brand = null;
        $measureID = "decrease_s";
        $cut = "fit";
        $sequence = Size::buildSequence($size, $brand, $measureID, $cut);
        $sizeObj = new Size($sequence);
        $sizeObj->setQuantity(6);
        $product->selecteSize($sizeObj);
        array_push($products, $product);

        $response = new Response();
        $userID = $person->getUserID();
        BoxProduct::lock($response, $userID, $products);
        var_dump($response->getAttributs());
    }

    public function test_basket_lock()
    {
        header('content-type: application/json');
        $person = $this->person;
        $response = new Response();
        $userID = $person->getUserID();
        $person->getBasket()->lock($response, $userID);
        var_dump($response->getAttributs());
    }

    public function test_stillUnlockedStock()
    {
        header('content-type: application/json');
        $person = $this->person;
        $products = [];

        $product = new BoxProduct(1, $person->getLanguage(), $person->getCountry(), $person->getCurrency());
        $size = null;
        $brand = null;
        $measureID = "a5rn30s0gtn2x2998j3000221";
        $cut = "wide";
        $sequence = Size::buildSequence($size, $brand, $measureID, $cut);
        $sizeObj = new Size($sequence);
        $sizeObj->setQuantity(7);
        $product->selecteSize($sizeObj);
        array_push($products, $product);

        $product = new BoxProduct(1, $person->getLanguage(), $person->getCountry(), $person->getCurrency());
        $size = "m";
        $brand = null;
        $measureID = null;
        $cut = null;
        $sequence = Size::buildSequence($size, $brand, $measureID, $cut);
        $sizeObj = new Size($sequence);
        $sizeObj->setQuantity(6);
        $product->selecteSize($sizeObj);
        array_push($products, $product);

        $product = new BoxProduct(1, $person->getLanguage(), $person->getCountry(), $person->getCurrency());
        $size = "l";
        $brand = null;
        $measureID = null;
        $cut = null;
        $sequence = Size::buildSequence($size, $brand, $measureID, $cut);
        $sizeObj = new Size($sequence);
        $sizeObj->setQuantity(2);
        $product->selecteSize($sizeObj);
        array_push($products, $product);

        var_dump("stillUnlockedStock: ", BoxProduct::stillUnlockedStock($products));
        // var_dump($response->getAttributs());
    }

    public function test_basket_stillUnlockedStock()
    {
        header('content-type: application/json');
        $person = $this->person;

        var_dump($person->getBasket()->stillUnlockedStock());
        // var_dump($response->getAttributs());
    }

    public function test_basket_existMeasure()
    {
        header('content-type: application/json');
        $person = $this->person;
        $measureID = "decrease_s";
        var_dump($person->getBasket()->existMeasure($measureID));
        // var_dump($response->getAttributs());
    }

    public function test_order()
    {
        $datasViewMap = new Map();
        $templateFile = 'view/EmailTemplates/orderConfirmation.php';
        // $templateFile = 'view/EmailTemplates/orderConfirmation2.php';
        // $templateFile = 'view/EmailTemplates/orderConfirmation1.php';
        $datasViewMap->put($templateFile, Map::templateFile);

        $firstname = $this->person->getFirstname();
        $lastname = $this->person->getLastname();
        $toName = ($firstname . " " . $lastname);
        $toEmail = $this->person->getEmail();
        $templateFile = 'view/EmailTemplates/orderConfirmation/orderConfirmation.php';
        // $company = $this->person->getCompanyInfos();
        $company = new Map(Configuration::getFromJson(Configuration::JSON_KEY_COMPANY));
        $order = $this->person->getLastOrder();
        $order = $this->person->getBasket();
        $address = $this->person->getSelectedAddress();     //🚨to delete cause delivery addres is  already in order
        $datasViewMap = new Map();
        $datasViewMap->put($toName, Map::name);
        $datasViewMap->put($toEmail, Map::email);
        $datasViewMap->put($templateFile, Map::templateFile);
        $datasViewMap->put($company, Map::company);
        $datasViewMap->put($firstname, Map::firstname);
        $datasViewMap->put($lastname, Map::lastname);
        $datasViewMap->put($order, Map::order);
        $datasViewMap->put($address, Map::address);     //🚨to delete cause delivery addres is  already in order
        $this->previewEmail($this->person, $datasViewMap);
    }
}
