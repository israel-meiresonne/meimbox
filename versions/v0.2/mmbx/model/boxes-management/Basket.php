<?php

require_once 'model/ModelFunctionality.php';
require_once 'model/boxes-management/Box.php';
require_once 'model/boxes-management/BasketProduct.php';
require_once 'model/boxes-management/BoxProduct.php';
require_once 'model/boxes-management/DiscountCode.php';
require_once 'model/boxes-management/Size.php';

class Basket extends ModelFunctionality
{
    /**
     * Holds basket's boxes
     * @var Box[]
     */
    private $boxes;

    /**
     * Holds basketproduct
     * + NOTE: Use set date in format Unix as access key like
     * + $basketProducts = [setdateUnix => basketProduct]
     * @var BasketProduct[]
     */
    private $basketProducts;

    /**
     * Liste of discount code of the basket.
     * Use the code as access key like $discountCodes[code => DiscountCode]
     * @var DiscountCode[] $discountCodes
     */
    private $discountCodes;

    /**
     * Constructor
     * @var int $userID identifiant of the user
     * @param Country $country Visitor's current Country
     * @param Currency $currency Visitor's current Currency
     */
    function __construct($userID = null, Country $country = null, Currency $currency = null)
    {
        $this->boxes = [];
        $this->basketProducts = [];
        $this->discountCodes = [];
        if (!empty($userID)) {
            if (empty($country) || empty($currency)) {
                throw new Exception("Param '\$country' and '\$currency' can't be empty");
            }
            $sql = "SELECT * FROM `Users` WHERE `userID` = '$userID'";
            $tab = $this->select($sql);
            if (count($tab) > 0) {
                $this->setBoxes($userID, $country, $currency);
                $this->setBasketProducts($userID, $country, $currency);
            }
        } else {
        }
    }

    /**
     * Setter for boxes
     * @var int $userID identifiant of the user
     * @param Country $country Visitor's current Country
     * @param Currency $currency Visitor's current Currency
     */
    private function setBoxes($userID, Country $country, Currency $currency)
    {
        $sql = "SELECT * FROM `Baskets-Box` WHERE  `userId` = '$userID'";
        $tab = $this->select($sql);
        if (count($tab) > 0) {
            foreach ($tab as $tabLine) {
                $boxID = $tabLine["boxId"];
                $box = new Box($boxID, $userID, $country, $currency);
                $key = $box->getDateInSec();
                $this->boxes[$key] = $box;
            }
            krsort($this->boxes);
        }
    }

    /**
     * Setter for basketproducts
     * @var int $userID identifiant of the user
     * @param Country $country Visitor's current Country
     * @param Currency $currency Visitor's current Currency
     */
    private function setBasketProducts($userID, Country $country, Currency $currency)
    {
        $sql = "SELECT * FROM `Baskets-Products` WHERE `userId` = '$userID'";
        $tab = $this->select($sql);
        if (count($tab) > 0) {
            foreach ($tab as $tabLine) {
                $product = new BasketProduct($tabLine["prodId"], $country, $currency);
                $sequence = Size::buildSequence($tabLine["size_name"], null, null);
                $size = new Size($sequence, $tabLine["setDate"]);
                $product->setSize($size);
                $quantity = (int) $tabLine["quantity"];
                $product->setQuantity($quantity);
                $key = $product->getDateInSec();
                $this->basketProducts[$key] = $product;
            }
            krsort($this->basketProducts);
        }
    }

    /**
     * Getter for basket's boxes
     * @return Box[] basket's boxes
     */
    public function getBoxes()
    {
        return $this->boxes;
    }

    /**
     * Getter for basket's basketproduct
     * @return BasketProduct[] basket's basketproduct
     */
    public function getBasketProducts()
    {
        return $this->basketProducts;
    }

    /**
     * Getter for basket's content
     * + content is ordered from newest to older
     * @return Box[]|BasketProduct[] basket's content
     */
    public function extractCart()
    {
        $cart = array_merge($this->getBoxes(), $this->getBasketProducts());
        krsort($cart);
        return $cart;
    }

    // /**
    //  * Fill the $boxes attribute of boxes
    //  * @var array $currencyMap
    //  * @var array $countryMap
    //  * @var array $boxMap
    //  * @var array $boxProdMap
    //  */
    // private function initBoxes($boxProdMap, $dbMap)
    // {
    //     foreach ($dbMap["boxMap"]["boxes"] as $boxID => $boxDatas) {
    //         $box = new Box($boxID, $boxProdMap, $dbMap);
    //         $key = $box->getDateInSec();
    //         $this->boxes[$key] = $box;
    //     }
    //     ksort($this->boxes);
    // }

    // /**
    //  * Fill the $basket with basketProduct 
    //  * @var array $currencyMap
    //  * @var array $countryMap
    //  * @var array $basketProdMap
    //  */
    // private function initBasketProducts($basketProdMap, $dbMap)
    // {
    //     foreach ($basketProdMap as $prodID => $product) {
    //         foreach ($product["datas"]["basket"] as $userId => $sequenceIDs) {
    //             foreach ($sequenceIDs as $sequenceID => $datas) {
    //                 $basketProduct = new BasketProduct($prodID, $dbMap);
    //                 $size = $datas["size_name"];
    //                 $brand = $datas["brand_name"];
    //                 $cut = $datas["cut_name"];
    //                 $quantity = $datas["quantity"];
    //                 $setDate = $datas["setDate"];

    //                 $measureId = $datas["measureId"];
    //                 $measureDatas = $dbMap["usersMap"]["usersMeasures"][$measureId];
    //                 if (!empty($measureDatas)) {
    //                     $values["measureID"] = $measureDatas["measureID"];
    //                     $values["measure_name"] = $measureDatas["measure_name"];
    //                     $values["bust"] = $measureDatas["userBust"];
    //                     $values["arm"] = $measureDatas["userArm"];
    //                     $values["waist"] = $measureDatas["userWaist"];
    //                     $values["hip"] = $measureDatas["userHip"];
    //                     $values["inseam"] = $measureDatas["userInseam"];
    //                     $values["unit_name"] = $measureDatas["unit_name"];
    //                     $values["size"] = $measureDatas["size_name"];
    //                     $values["setDate"] = $datas["setDate"];
    //                     $measure = new Measure($values, $dbMap);
    //                 } else {
    //                     $measure = null;
    //                 }
    //                 $basketProduct->setSize($size, $brand, $cut, $quantity, $setDate, $measure);
    //                 $key = $basketProduct->getDateInSec();
    //                 $this->basketProducts[$key] = $basketProduct;
    //             }
    //         }
    //     }
    //     ksort($this->basketProducts);
    // }

    // /**
    //  * Fill the $discountCode with DiscountCode 
    //  * @var array $countryMap
    //  * @var array $discountCodeMap
    //  */
    // private function initDiscountCodes($dbMap)
    // {
    //     foreach ($dbMap["discountCodeMap"] as $code => $discount) {
    //         $discountCode = new DiscountCode($code, $dbMap);
    //         $this->discountCodes[$code] = $discountCode;
    //     }
    // }

    // /**
    //  * @return Box[] a protected copy of the $boxes attribute
    //  */
    // public function getCopyBoxes(){
    //     $copy = [];
    //     foreach($this->boxes as $setDateUnix => $box){
    //         $copy[$setDateUnix] = $box->getCopy();
    //     }
    //     ksort($copy);
    //     return $copy;
    // }

    // /**
    //  * @return BasketProduct[] a protected copy of the $basketProduct attribute
    //  */
    // public function getCopyBasketProducts(){
    //     $copy = [];
    //     foreach($this->basketProducts as $setDateUnix => $basketProduct){
    //         $copy[$setDateUnix] = $basketProduct->getCopy();
    //     }
    //     ksort($copy);
    //     return $copy;
    // }

    // /**
    //  * To get a protected copy of the DiscountCode list
    //  * Use the code as access key like $discountCodes[code => DiscountCode]
    //  * @return DiscountCode[] a protected copy of the $discountCodes attribute
    //  */
    // public function getCopyDiscountCodes(){
    //     $copy = [];
    //     foreach($this->discountCodes as $code => $discountCode){
    //         $copy[$code] = $discountCode->getCopy();
    //     }
    //     return $copy;
    // }

    // public function __toString()
    // {
    //     foreach ($this->boxes as $box) {
    //         $box->__toString();
    //     }

    //     foreach ($this->basketProducts as $basketProduct) {
    //         $basketProduct->__toString();
    //     }

    //     foreach ($this->discountCodes as $discountCode) {
    //         $discountCode->__toString();
    //     }
    // }
}
