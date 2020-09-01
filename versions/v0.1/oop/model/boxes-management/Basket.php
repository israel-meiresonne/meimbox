<?php

class Basket
{
    /**
     * Holds Boxes
     * @var Box[]
     */
    private $boxes = [];

    /**
     * Holds Product witch go only to the basket.
     * NOTE: Use set date in format Unix as access key like
     * $basketProducts = [setdateUnix => basketProduct]
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
     * Get user's basket from Database
     * @var int $userID identifiant of the user
     */
    function __construct($dbMap)
    {
        $productMap = $dbMap["productMap"];

        Basket::initBoxes($productMap[BoxProduct::BOX_TYPE], $dbMap);
        Basket::initBasketProducts($productMap[BasketProduct::BASKET_TYPE], $dbMap);
        Basket::initDiscountCodes($dbMap);
    }

    /**
     * Fill the $boxes attribute of boxes
     * @var array $currencyMap
     * @var array $countryMap
     * @var array $boxMap
     * @var array $boxProdMap
     */
    private function initBoxes($boxProdMap, $dbMap)
    {
        foreach ($dbMap["boxMap"]["boxes"] as $boxID => $boxDatas) {
            $box = new Box($boxID, $boxProdMap, $dbMap);
            $key = $box->getDateInSec();
            $this->boxes[$key] = $box;
        }
        ksort($this->boxes);
    }

    /**
     * Fill the $basket with basketProduct 
     * @var array $currencyMap
     * @var array $countryMap
     * @var array $basketProdMap
     */
    private function initBasketProducts($basketProdMap, $dbMap)
    {
        foreach ($basketProdMap as $prodID => $product) {
            foreach ($product["datas"]["basket"] as $userId => $sequenceIDs) {
                foreach ($sequenceIDs as $sequenceID => $datas) {
                    $basketProduct = new BasketProduct($prodID, $dbMap);
                    $size = $datas["size_name"];
                    $brand = $datas["brand_name"];
                    $cut = $datas["cut_name"];
                    $quantity = $datas["quantity"];
                    $setDate = $datas["setDate"];
                    
                    $measureId = $datas["measureId"];
                    $measureDatas = $dbMap["usersMap"]["usersMeasures"][$measureId];
                    if (!empty($measureDatas)) {
                        $values["measureID"] = $measureDatas["measureID"];
                        $values["measure_name"] = $measureDatas["measure_name"];
                        $values["bust"] = $measureDatas["userBust"];
                        $values["arm"] = $measureDatas["userArm"];
                        $values["waist"] = $measureDatas["userWaist"];
                        $values["hip"] = $measureDatas["userHip"];
                        $values["inseam"] = $measureDatas["userInseam"];
                        $values["unit_name"] = $measureDatas["unit_name"];
                        $values["size"] = $measureDatas["size_name"];
                        $values["setDate"] = $datas["setDate"];
                        $measure = new Measure($values, $dbMap);
                    } else {
                        $measure = null;
                    }
                    $basketProduct->setSize($size, $brand, $cut, $quantity, $setDate, $measure);
                    $key = $basketProduct->getDateInSec();
                    $this->basketProducts[$key] = $basketProduct;
                }
            }
        }
        ksort($this->basketProducts);
    }

    /**
     * Fill the $discountCode with DiscountCode 
     * @var array $countryMap
     * @var array $discountCodeMap
     */
    private function initDiscountCodes($dbMap)
    {
        foreach ($dbMap["discountCodeMap"] as $code => $discount) {
            $discountCode = new DiscountCode($code, $dbMap);
            $this->discountCodes[$code] = $discountCode;
        }
    }

    /**
     * @return Box[] a protected copy of the $boxes attribute
     */
    public function getCopyBoxes(){
        $copy = [];
        foreach($this->boxes as $setDateUnix => $box){
            $copy[$setDateUnix] = $box->getCopy();
        }
        ksort($copy);
        return $copy;
    }
    
    /**
     * @return BasketProduct[] a protected copy of the $basketProduct attribute
     */
    public function getCopyBasketProducts(){
        $copy = [];
        foreach($this->basketProducts as $setDateUnix => $basketProduct){
            $copy[$setDateUnix] = $basketProduct->getCopy();
        }
        ksort($copy);
        return $copy;
    }
    
    /**
     * To get a protected copy of the DiscountCode list
     * Use the code as access key like $discountCodes[code => DiscountCode]
     * @return DiscountCode[] a protected copy of the $discountCodes attribute
     */
    public function getCopyDiscountCodes(){
        $copy = [];
        foreach($this->discountCodes as $code => $discountCode){
            $copy[$code] = $discountCode->getCopy();
        }
        return $copy;
    }

    public function __toString()
    {
        foreach ($this->boxes as $box) {
            $box->__toString();
        }

        foreach ($this->basketProducts as $basketProduct) {
            $basketProduct->__toString();
        }

        foreach ($this->discountCodes as $discountCode) {
            $discountCode->__toString();
        }
    }
}
