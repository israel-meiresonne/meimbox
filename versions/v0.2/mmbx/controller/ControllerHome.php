<?php

require_once 'ControllerSecure.php';

class ControllerHome extends ControllerSecure
{
    public const A_SIGN_UP = "home/signUp";
    public const A_SIGN_IN = "home/signIn";
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
     * To sign up a new user
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
     * To sign in a user
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
     * To update Visitor's Country
     */
    public function updateCountry()
    {
        $response = new Response();
        $person = $this->person;
        $datasView = [];
        $inputName = Country::INPUT_ISO_COUNTRY . Country::INPUT_EXT_VISITOR;
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

    public function testA()
    {
        header('content-type: application/json');
        $person = $this->person;
        // $sizeObjs = [];
        // $product = new BoxProduct(1, $person->getLanguage(), $person->getCountry(), $person->getCurrency());
        // $size = null;
        // $brand = null;
        // $measureID = "decrease_s_2";
        // $cut = "fit";
        // $sequence = Size::buildSequence($size, $brand, $measureID, $cut);
        // $sizeObj = new Size($sequence);
        // $sizeObj->setQuantity(7);
        // array_push($sizeObjs, $sizeObj);

        // $size = "xxs";
        // $brand = null;
        // $measureID = null;
        // $cut = null;
        // $sequence = Size::buildSequence($size, $brand, $measureID, $cut);
        // $sizeObj = new Size($sequence);
        // $sizeObj->setQuantity(2);
        // array_push($sizeObjs, $sizeObj);

        // var_dump("stillStock: ", $product->stillStock(...$sizeObjs));

        // $a = ["a", "b", "c"];
        // $nb = count($a);
        // var_dump($nb);
        // var_dump($a);
        // $a[$nb] = "z";
        // var_dump($a);

        var_dump($person->getBasket()->stillStock());

        // $a = [
        //     "k1" => "a", 
        //     "k2" => "b", 
        //     "k3" => "c"
        // ];
        // var_dump($a);
        // $b = ModelFunctionality::keysToInt($a);
        // var_dump($b);

        // $this->generateView([], $this->person, "test");
    }

    private function multiparam(...$params)
    {
        var_dump($params);
    }

    public function test()
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
