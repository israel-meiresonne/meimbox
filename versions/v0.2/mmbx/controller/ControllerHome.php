<?php

require_once 'ControllerSecure.php';

class ControllerHome extends ControllerSecure
{
    public const A_SIGN_UP = "home/signUp";
    public const A_SIGN_IN = "home/signIn";

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

    public function test()
    {
        header('content-type: application/json');

        //    foreach($_SERVER as $key => $data){
        //        echo "$key => ";
        //        var_dump($data);
        //        echo "<hr>";
        //    }
        // $a = false;
        // var_dump($a);
        // echo "<hr>";
        // $b = (int) $a;
        // var_dump($b);
        // $product = new BoxProduct("1", $this->person->getLanguage(), $this->person->getCountry(), $this->person->getCurrency());
        // // $sizes = [32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56];
        // $sizes = ['xxs', 'xs', 's', 'm', 'l', 'xl'];
        // foreach($sizes as $size){
        //     // var_dump();
        //     // echo "<br>";
        //     $sizeObj = new Size(Size::buildSequence($size, null, null, null));
        //     $sizeObj->setQuantity(3);
        //     $product->selecteSize($sizeObj);
        //     var_dump("To convert: ", $sizeObj->getsize());
        //     echo "<br>";
        //     var_dump("Converted: ", $product->SelectedToRealSize()->getsize());
        //     echo "<br>";
        //     var_dump("quantity: ", $product->SelectedToRealSize()->getQuantity());
        //     echo "<hr>";
        // }

        // $sizes = [32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56];
        // $measureIDs = [
        //     '803g420892212029wn05e10cq',
        //     // 'c39521az182vv0012250220n0',
        //     // 'a5rn30s0gtn2x2998j3000221', 
        //     '1001nq54od2c002o903219929', 
        //     '0jj2g3rj131923p1560b90d01', 
        //     '2191802te91kv3ee27a280h02', 
        //     '651853948740'
        // ];
        // foreach ($measureIDs as $measureID) {
        //     // var_dump();
        //     // echo "<br>";
        //     $sizeObj = new Size(Size::buildSequence(null, null, $measureID, "wide"));
        //     $product->selecteSize($sizeObj);
        //     var_dump("To convert: ", $sizeObj->getmeasure()->getMeasureName());
        //     echo "<br>";
        //     var_dump("Converted: ", $product->SelectedToRealSize()->getsize());
        //     echo "<hr>";
        // }

        // $a = strtotime("2020-10-12 12:00:00");
        // $a = strtotime(null);
        // $setDate = strtotime("2020-10-12 15:00:45");
        // // $setDate = time();
        // $lockLimit = 60;
        // // var_dump(time() > ($setDate + $lockLimit));
        // var_dump((int)strtotime("1971-10-12 15:00:45"));

        // $product = new BoxProduct("1", $this->person->getLanguage(), $this->person->getCountry(), $this->person->getCurrency());
        // // $sizes = [32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56];
        // // $sizes = ['xxs', 'xs', 's', 'm', 'l', 'xl'];
        // $sizes = ['xxs'];
        // foreach ($sizes as $size) {
        //     $sizeObj = new Size(Size::buildSequence($size, null, null, null));
        //     $sizeObj->setQuantity(17);
        //     // $product->selecteSize($sizeObj);
        //     var_dump("still stock: ", $product->stillStock($sizeObj));
        //     echo "<br>";
        //     echo "<hr>";
        // }

        // $product = new BoxProduct("1", $this->person->getLanguage(), $this->person->getCountry(), $this->person->getCurrency());
        // // $sizes = [32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56];
        // // $sizes = ['xxs', 'xs', 's', 'm', 'l', 'xl'];
        // $measureIDs = [
        //     'decrease_s_2',
        //     // 'c39521az182vv0012250220n0',
        //     // 'a5rn30s0gtn2x2998j3000221', 
        //     // '1001nq54od2c002o903219929', 
        //     // '0jj2g3rj131923p1560b90d01', 
        //     // '2191802te91kv3ee27a280h02', 
        //     // '651853948740'
        // ];
        // foreach ($measureIDs as $measureID) {
        //     $sizeObj = new Size(Size::buildSequence(null, null, $measureID, "fit"));
        //     $sizeObj->setQuantity(15);
        //     // $product->selecteSize($sizeObj);
        //     var_dump("still stock: ", $product->stillStock($sizeObj));
        //     echo "<br>";
        //     echo "<hr>";
        // }

        // $product = new BoxProduct("1", $this->person->getLanguage(), $this->person->getCountry(), $this->person->getCurrency());
        // // $sizes = [32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56];
        // // $sizes = ['xxs', 'xs', 's', 'm', 'l', 'xl'];
        // $sizes = ['xxs'];
        // $response = new Response();
        // foreach ($sizes as $size) {
        //     $sizeObj = new Size(Size::buildSequence($size, null, null, null));
        //     $sizeObj->setQuantity(3);
        //     $product->selecteSize($sizeObj);
        //     $product->lock($response, $this->person->getUserID());
        //     var_dump("response: ", $response->getAttributs());
        //     echo "<br>";
        //     echo "<hr>";
        // }

        // $product = new BoxProduct("1", $this->person->getLanguage(), $this->person->getCountry(), $this->person->getCurrency());
        // var_dump($product);
        // echo "<hr>";
        // echo "<hr>";
        // $copy = $product->getCopy();
        // var_dump($copy);
        // $response = new Response();
        // $this->person->getBasket()->lock($response, $this->person->getUserID());
        // $soldOut = $this->person->getBasket()->stillStock();
        // $keys = $soldOut->getKeys();
        // // var_dump($soldOut);
        // // echo "<hr>";
        // foreach($keys as $key){
        //     var_dump($soldOut->get($key));
        //     echo "<hr>";
        // }
        // echo "<hr>";

        // $response = new Response();
        // // $this->person->getBasket()->unlock($response, $this->person->getUserID());
        // // $this->person->getBasket()->lock($response, $this->person->getUserID());
        // var_dump($response->getAttributs());
        // echo "<hr>";
        // var_dump($response->getAttributs());

        // $this->person->generateCookie(Cookie::COOKIE_LCK, "test");
        // $this->person->destroyCookie(Cookie::COOKIE_LCK, true);

        // $response = new Response();
        // $this->person->getBasket()->empty($response);
        // var_dump($response->getAttributs());
        // echo "<hr>";

        // $boxes = $this->person->getBasket()->getBoxes();
        // $toDecreaseProds = [];
        // foreach ($boxes as $box) {
        //     $products = $box->getProducts();
        //     if (!empty($products)) {
        //         foreach ($products as $product) {
        //             array_push($toDecreaseProds, $product);
        //         }
        //     }
        // }
        // foreach($toDecreaseProds as $x){
        //     var_dump($x);
        //     echo "<hr>";
        // }
        // $response = new Response();
        // BoxProduct::decreaseStock($response, $toDecreaseProds);
        // var_dump($response->getAttributs());
        // echo "<hr>";

        // require_once 'model/tools-management/mailers/sendinblue/BlueAPI.php';
        // $blueAPI = new BlueAPI();
        // $blueAPI->sendOrderConfirmation($this->person);
        // echo $sendinBlueAPI->getInfo();

        // $a = "[{&quot;name&quot;:&quot;Jimmy&quot;, &quot;email&quot;:&quot;jimmy98@example.com&quot;}, {&quot;name&quot;:&quot;Joe&quot;, &quot;email&quot;:&quot;joe@example.com&quot;}]";
        // $b = "[{&quot;url&quot;:&quot;https://attachment.domain.com/myAttachmentFromUrl.jpg&quot;, &quot;name&quot;:&quot;myAttachmentFromUrl.jpg&quot;}, {&quot;content&quot;:&quot;base64 example content&quot;, &quot;name&quot;:&quot;myAttachmentFromBase64.jpg&quot;}]";
        // $b = "{&quot;code&quot;:&quot;invalid_parameter&quot;,&quot;message&quot;:&quot;valid htmlContent is required&quot;}";
        // var_dump($a);
        // echo "<hr>";
        // var_dump($b);
        // Vous voulez afficher un pdf
        // header('Content-Type: application/pdf');
        // $response = new Response();
        // var_dump($response->getAttributs());

        // Il sera nommé downloaded.pdf
        // header('Content-Disposition: attachment; filename="downloaded.pdf"');

        // ob_start();
        // require 'model/view-management/emails/orderConfirmation.php';

        // $htmlContent = (string) ob_clean();
        // var_dump(ob_get_clean());
        // 1598634509

        // var_dump(date('Y-m-d H:i:s',15986345091));
        // echo "<hr>";
        // var_dump((string)time());

        // require_once 'model/tools-management/mailers/sendinblue/BlueMessage.php';
        // $blueMeassage = new BlueMessage();

        // try {
        //     throw new Exception("Error Processing Request");
        // } catch (\Throwable $th) {
        //     $a = ($th->__toString());
        // }

        // $response = new Response();
        // $response->addError($a);
        // var_dump($response->getAttributs());
    }
}
