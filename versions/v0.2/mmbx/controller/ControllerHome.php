<?php

require_once 'ControllerSecure.php';

class ControllerHome extends ControllerSecure
{
    public const A_SIGN_UP = "home/signUp";
    public const A_SIGN_IN = "home/signIn";
    public const QR_LOG_OUT = "home/logOut";
    public const QR_UPDATE_COUNTRY = "home/updateCountry";
    public const QR_EVENT = "home/event";

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
        $person = $this->getPerson();
        $datasView = [];
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
            $person->getDataLength("Users", "firstname")
        );
        $lastname = $this->checkInput(
            $response,
            Visitor::INPUT_LASTNAME,
            Query::getParam(Visitor::INPUT_LASTNAME),
            [self::NAME],
            $person->getDataLength("Users", "lastname")
        );
        $email = $this->checkInput(
            $response,
            Visitor::INPUT_EMAIL,
            Query::getParam(Visitor::INPUT_EMAIL),
            [self::EMAIL],
            $person->getDataLength("Users", "mail")
        );
        $password = $this->checkInput(
            $response,
            Visitor::INPUT_PASSWORD,
            Query::getParam(Visitor::INPUT_PASSWORD),
            [self::PASSWORD],
            $person->getDataLength("Users", "password")
        );
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

                // $userID = $person->getUserID();
                $eventCode = "evt_cd_47";
                // $person->getNavigation()->handleEvent((new Response), $userID, $eventCode);
                $person->handleEvent($eventCode);
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
        $person = $this->getPerson();
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
            $client = $person->signIn($response, $inMap);
            if (!$response->containError()) {
                $response->addResult(self::A_SIGN_IN, true);

                $eventCode = "evt_cd_49";
                // $eventRsp = new Response();
                // $client->getNavigation()->handleEvent(($eventRsp), $client->getUserID(), $eventCode);
                $client->handleEvent($eventCode);
            }
        }
        $this->generateJsonView($datasView, $response, $person);
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

        $inputName = (Query::existParam(Country::INPUT_ISO_COUNTRY_VISITOR)) ? Country::INPUT_ISO_COUNTRY_VISITOR : null;
        $inputName = (empty($inputName) && Query::existParam(Country::INPUT_ISO_COUNTRY_ADRS)) ? Country::INPUT_ISO_COUNTRY_ADRS : $inputName;

        if (empty(Query::getParam($inputName))) {
            $response->addErrorStation("ER1", MyError::FATAL_ERROR);
        } else {
            $newIsoCountry = Query::getParam($inputName);
            $person->updateCountry($response, $newIsoCountry);
            if (!$response->containError()) {
                $person->addSummaryPrices($response);

                $eventDattasMap = new Map();
                $eventDattasMap->put($newIsoCountry, Country::KEY_ISO_CODE);
                $eventCode = "evt_cd_22";
                // $person->getNavigation()->handleEvent((new Response()), $person->getUserID(), $eventCode, $datasMap);
                $person->handleEvent($eventCode, $eventDattasMap);
            }
        }
        $this->generateJsonView($datasView, $response, $person);
    }

    /**
     * To handle Events
     */
    public function event()
    {
        $response = new Response();
        $person = $this->getPerson();
        $navigation = $person->getNavigation();
        /**
         * @var Xhr */
        $xhr = $navigation->getUrlPage();
        $holdsEvent = $xhr->getEvent();
        if (!empty($holdsEvent)) {
            $xhrID = $xhr->getXhrID();
            $eventID = $holdsEvent->getEventID();
            $errorMsg = "This Xhr '$xhrID' request already holds a Event '$eventID'";
            $response->addError($errorMsg, MyError::ADMIN_ERROR);
        } else {
            if (empty(Query::getParam(Event::KEY_EVENT))) {
                $errorMsg = "empty event sent";
                $response->addError($errorMsg, MyError::ADMIN_ERROR);
            } else {
                $eventCode = Query::getParam(Event::KEY_EVENT);
                if (empty(Event::retreiveEventLine($eventCode))) {
                    $errorMsg = "Unkow event code '$eventCode'";
                    $response->addError($errorMsg, MyError::ADMIN_ERROR);
                } else {
                    $json = (!is_null(Query::getParam(Event::KEY_DATA))) ? htmlspecialchars_decode(Query::getParam(Event::KEY_DATA)) : null;
                    $datas = json_decode($json, true, 2);
                    if ((isset($json)) && ($datas == false)) {
                        $errorMsg = "The json submited is invalid '$json'";
                        $response->addError($errorMsg, MyError::ADMIN_ERROR);
                    } else {
                        $userID = $person->getUserID();
                        $eventDattasMap = (!empty($datas)) ? new  Map($datas) : null;
                        if (!empty($eventDattasMap)) {
                            $keys = $eventDattasMap->getKeys();
                            $hide = str_repeat("*", 5);
                            (in_array(Visitor::INPUT_PASSWORD, $keys)) ? $eventDattasMap->put($hide, Visitor::INPUT_PASSWORD) : null;
                            (in_array(Visitor::INPUT_CONFIRM_PASSWORD, $keys)) ? $eventDattasMap->put($hide, Visitor::INPUT_CONFIRM_PASSWORD) : null;
                        }
                        $person->handleEvent($eventCode, $eventDattasMap);
                        if (!$response->containError()) {
                            $response->addResult(self::QR_EVENT, true);
                        }
                    }
                }
            }
        }
        $this->generateJsonView([], $response, $person);
    }

    /*———————————————————————————— TESTS DOWN ———————————————————————————————*/

    public function test()
    {
        header('content-type: application/json');
        $person = $this->person;
        $person->generateCookie(Cookie::COOKIE_CHKT_LNCHD, time());
        // $session = $person->getSession();
        // $session->unset(Session::KEY_CHECKOUT_LAUNCH);
        // $session->set(Session::KEY_CHECKOUT_LAUNCH, time());
        $d = 1606920365;
        var_dump(date(ModelFunctionality::DATE_FORMAT, $d));
        $d = 1606921657905;
        var_dump(date("Y-m-d H:i:s.u", $d));
        var_dump($_COOKIE);
    }

    public function test_xhr()
    {
        header('content-type: application/json');
        $person = $this->person;
        $response = new Response();
        $userID = $person->getUserID();
        // $pageID = "nav_52c033d81cbe";
        $pageID = "nav_52c033d81cbe";
        $url = "https://52c033d81cbe.eu.ngrok.io/versions/v0.2/mmbx/grid?xhr=nav_52c033d81cbe";
        $datasMap = new Map(["k1" => "v1", 1 => 2, "k3" => null]);
        $event = new Event("01", $datasMap);
        $xhr = new Xhr($url, $event);
        $xhr->insertXhr($response, $userID, $pageID);
        // $xhr->addEvent($response, $event);
        // var_dump($xhr);
        var_dump($response->getAttributs());
    }
    public function test_redirector_sign()
    {
        header('content-type: application/json');
        // sleep(5);
        $ctr = $this->extractController(get_class($this));
        $this->redirect($ctr, "qr/test_redirector_checkout");
    }
    public function test_redirector_checkout()
    {
        header('content-type: application/json');
        // sleep(5);
        $ctr = $this->extractController(get_class($this));
        $this->redirect($ctr, "qr/test");
    }

    public function test_Navigation()
    {
        header('content-type: application/json');
        $person = $this->person;
        $userID = $person->getUserID();
        $session = $person->getSession();
        $nav = new Navigation($userID);
        echo str_repeat("-", 50) . " _SESSION " . str_repeat("-", 50);
        echo "\n";
        var_dump($_SESSION);
        echo str_repeat("-", 50) . " _GET " . str_repeat("-", 50);
        echo "\n";
        var_dump($_GET);
        $nav->handleRequest($session);
        // $nav->locate($session);
        // $nav->detectDevice(); nav_080t2d09b1e115p12112l23m2
        // $session->destroy();
        echo str_repeat("-", 50) . " _SESSION " . str_repeat("-", 50);
        echo "\n";
        var_dump($_SESSION);
        echo str_repeat("-", 50) . " _GET " . str_repeat("-", 50);
        echo "\n";
        var_dump($_GET);
    }

    public function test_Location()
    {
        header('content-type: application/json');
        $person = $this->person;
        $userID = $person->getUserID();
        $session = $person->getSession();
        $response = new Response();
        // $session->destroy();
        $localtion = new Location("nav_ip21049o3iz202u02u3s821z1");
        var_dump($localtion);
        $localtion->insertLocation($response);
        var_dump($response->getAttributs());
        var_dump($_SESSION);
        var_dump($_GET);
        // $navDate = "2020-11-26 01:01:22";
        // $localtion->insertLocation($response, $userID, $navDate);
    }

    public function test_Device()
    {
        header('content-type: application/json');
        $person = $this->person;
        $response = new Response;
        $device = new Device("nav_ip21049o3iz202u02u3s821z1");
        var_dump($device);
        $device->insertDevice($response);
        var_dump($response->getAttributs());
        var_dump($_SESSION);
        var_dump($_GET);
    }
    public function test_Page()
    {
        header('content-type: application/json');
        $person = $this->person;
        // var_dump($_SERVER);
        // var_dump(Page::extractUrl());
        // require_once 'model/navigation/Device.php';
        // require_once 'model/navigation/Location.php';
        // var_dump(Configuration::getEnvironement());
        // var_dump(new Location());

        // $nav =  new Navigation();
        $userID = $person->getUserID();
        // $session = $person->getSession();
        $response = new Response;
        $page = new Page(Page::extractUrl());
        $pageID = $page->getPageID();
        // $page = Page::retreivePage("nav_ip21049o3iz202u02u3s821z1");
        // $page->updatePage($response);
        // var_dump(Page::retreivePage("nav_ip21049o3iz202u02u3s821z1"));
        // $page->insertPage($response, $userID);
        $url = "https://52c033d81cbe.eu.ngrok.io/versions/v0.2/mmbx/grid?xhr=$pageID";
        $datasMap = new Map(["k1" => "v1", 1 => 2, "k3" => null]);
        $event = new Event("01", $datasMap);
        $xhr = new Xhr($url, $event);
        // $xhr->insertXhr($response, $userID, $pageID);
        $page->addXhr($xhr);
        var_dump($page->insertPage($response, $userID));
        var_dump($response->getAttributs());
        // $page = new Page("3330090", "2020-11-25 20:40:30");
        // $session->unset(Session::KEY_LAST_LOAD);
        // $session->set(Session::KEY_LAST_LOAD, $page->getPageID($userID));
        // $session->destroy();
        // $page->updatePage($response, $userID);
        // $pageID = $page->generatePageID($userID);
        // var_dump($page->getPageType($session));
        // var_dump($_SESSION);
        // var_dump($_GET);
        // var_dump($pageID);
        // var_dump(Page::explodePageID($pageID));
        // var_dump($page->isXHR());
        // var_dump($page->getParams());
        // var_dump($page->getPath());
        // $userID = $person->getUserID();
        // $response = new Response;
        // $page->savePage($response, $userID);
        // var_dump($response->getAttributs());
        // $page = new Page("localhost:8090/versions/v0.2/mmbx/home/qr/test?param1=A&param2=B", "2021-01-01 01:01:01");
        // var_dump($page->getPath());
        // var_dump($_GET);
        // $nav->addPage();
        // $nav->addPage($page);
        // var_dump($nav);

        // $webroot = "/versions/v0.2/mmbx/";
        // // $webroot = "/";
        // $url = "https://3a1baf8702c4.eu.ngrok.io". $webroot ."home/qr/test?param1=A&param2=B";
        // // $url = "localhost:8090". $webroot ."home/qr/test?param1=A&param2=B";
        // var_dump("url: $url");
        // $parsed = parse_url($url);
        // var_dump($parsed);
        // $query = $parsed["query"];
        // $query = null;
        // parse_str($query, $params);
        // var_dump($params);
        // $webrootPath = $parsed["path"];
        // $nb = 1;
        // // $path = str_replace($webroot, "", $parsed["path"], $nb);
        // $path = substr_replace($webrootPath, "", 0, strlen($webroot));
        // var_dump("path: $path");
    }

    public function test_Session()
    {
        header('content-type: application/json');
        require_once 'model/special/Session.php';
        $person = $this->person;
        $session = $person->getSession();
        $key = "hello";
        $value = "world";
        $session->set($key, 0);
        var_dump($_SESSION);
        // var_dump("value: ", $session->get($key));
        $session->destroy();
        var_dump($_SESSION);
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
