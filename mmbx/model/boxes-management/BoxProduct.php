<?php

require_once 'model/tools-management/Measure.php';
require_once 'model/boxes-management/Product.php';

class BoxProduct extends Product
{

    /**
     * Holds the BoxProduct's measures
     * @var Measure
     */
    private $measure;

    /**
     * Product type to know where to put it
     * @var string Product witch can be puted only into a box
     */
    const BOX_TYPE = "boxproduct";


    public function __construct($prodID)
    {
        parent::__construct($prodID);
        $this->setMeasure();
    }

    /**
     * Setter for BoxProduct's measure
     */
    private function setMeasure()
    {
        $sql = "SELECT * FROM `ProductsMeasures` WHERE `prodId` = '$this->prodID'";
        $tab = $this->select($sql);
        if (count($tab) == 0) {
            throw new Exception("This product has any measure: id=$this->prodID");
        }
        $measureDatas  = [];
        foreach ($tab as $tabLine) {
            if (!isset($measureDatas["unit_name"])) {
                $measureDatas["unit_name"] = $tabLine["unit_name"];
            }
            if ($measureDatas["unit_name"] != $tabLine["unit_name"]) {
                throw new Exception("Product unit measure must be the same for all its measures: id=$this->prodID, " . $measureDatas['unit_name'] . "!=" . $tabLine["unit_name"]);
            }
            $measureDatas[$tabLine["body_part"]] = (float) $tabLine["value"];
        }
        $this->measure = new Measure($measureDatas);
    }

    /**
     * To set all other properties that nat in Product table
     * @param Language $lang Visitor's language
     * @param Country $country the Visitor's country
     * @param Currency the Visitor's current Currency
     */
    public function CompleteProperties($lang, $country = null, $currency = null)
    {
        $this->setPictures();
        $this->setSizesStock();
        $this->setCollections();
        $this->setProdFunctions();
        $this->setCategories();
        $this->setDescriptions($lang);
        $this->setSameProducts();
    }

    /**
     * Fill the same product list with product sharing the same name that the 
     * current product.
     */
    private function setSameProducts()
    {
        $this->sameProducts = [];
        $sql = "SELECT `prodID` 
        FROM `Products` 
        WHERE isAvailable = 1 AND `prodID`!= '$this->prodID' AND `prodName` = '$this->prodName'  
        ORDER BY `Products`.`prodID` ASC";
        $tab = $this->select($sql);
        if (count($tab) > 0) {
            foreach ($tab as $tabLine) {
                $product = new BoxProduct($tabLine["prodID"]);
                $this->sameProducts[$product->getProdID()] = $product;
            }
        }
    }

    /**
     * Getter of $BOX_TYPE
     * @return string the type of the product
     */
    public function getType()
    {
        return self::BOX_TYPE;
    }

    /**
     * Check if the product is a basket product
     * @return boolean true if the product is a basket product else false
     */
    public function isBasketProduct()
    {
        return false;
    }
}
