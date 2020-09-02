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


    /**
     * Constructor
     * @param int $prodID product's id
     * @param Language $language Visitor's language
     * @param Country $country the Visitor's country
     * @param Currency $currency the Visitor's current Currency
     */
    public function __construct($prodID, Language $language, Country $country, Currency $currency)
    {
        parent::__construct($prodID, $language, $country, $currency);
        // $this->setMeasure();
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

    // /**
    //  * To set all other properties that nat in Product table
    //  * @param Language $lang Visitor's language
    //  * @param Country $country the Visitor's country
    //  * @param Currency the Visitor's current Currency
    //  */
    // public function CompleteProperties(Language $lang, $country = null, $currency = null)
    // {
        // $this->setPictures();
        // $this->setSizesStock();

        // $this->decupleSizeStock();

        // $this->setCollections();
        // $this->setProdFunctions();
        // $this->setCategories();
        // $this->setDescriptions($lang);
        // $this->setSameProducts();
    // }

    /**
     * Setter for product's size and stock
     */
    protected function setSizesStock()
    {
       parent::setSizesStock();
       $this->sizesStock = $this->decupleSizeStock($this->sizesStock);
    }

    /**
     * Set sizeStock by decupling stock for each size
     * + decline each size in all size below and increase the stock
     * @param int[] $sizesStock list of size to decuple and their stock
     * + size => stock
     * @return int[] list of size => stock decupled
     */
    private function decupleSizeStock($sizesStock)
    {
        // $this->setSizesStock();
        // $sizesStock = $this->getSizeStock();
        $json = $this->getConstantLine(Size::SUPPORTED_SIZES)["jsonValue"];
        $dbSizes = json_decode($json);
        // $firstK = array_keys($this->sizesStock)[0];
        $firstK = array_keys($sizesStock)[0];
        $nbList = count($dbSizes);
        for ($i = 0; $i < $nbList; $i++) {
            if (in_array($firstK, $dbSizes[$i])) {
                break;
            }
        }
        // foreach ($this->sizesStock as $size => $stock) {
        foreach ($sizesStock as $size => $stock) {
            if (!in_array($size, $dbSizes[$i])) {
                throw new Exception("The size '$size' is not supported by the system");
            }
        }
        $sizes = $dbSizes[$i];
        $newSizesStock = array_fill_keys($sizes, 0);
        $sizesPos = array_flip($sizes); // [$size => $pos] use size as key and index as value, each indix indicate the position of the size in $newSizesStock
        // foreach ($this->sizesStock as $size => $stock) {
        foreach ($sizesStock as $size => $stock) {
            $pos = $sizesPos[$size];
            $keys = array_keys(array_slice($newSizesStock, $pos));
            $newSizesStock = $this->increaseStock($newSizesStock, $keys, $stock);
        }
        foreach ($newSizesStock as $size => $stock) {
            // if (($stock == 0) && (!key_exists($size, $this->sizesStock))) {
            if (($stock == 0) && (!key_exists($size, $sizesStock))) {
                $newSizesStock[$size] = null;
                unset($newSizesStock[$size]);
            }
        }
        $ordSizeStock =  [];
        foreach ($sizes as $size) {
            if (key_exists($size, $newSizesStock)) {
                $ordSizeStock[$size] = $newSizesStock[$size];
            }
        }
        $ordSizeStock = array_reverse($ordSizeStock);
        // $this->sizesStock = $ordSizeStock;
        return $ordSizeStock;
    }

    /**
     * Increase stock value at keys given in param
     * @param string[] $newSizesStock list of size stock to increase
     * + $newSizesStock = [
     *      size{string|int} => stock{int}
     * ]
     * @param string[] $keys list of size to increase
     * @param int $stock amount of stock to add
     */
    private function increaseStock($newSizesStock, $keys, int $stock)
    {
        foreach ($keys as $size) {
            $newSizesStock[$size] += $stock;
        }
        return $newSizesStock;
    }

    /**
     * Fill the same product list with product sharing the same name that the 
     * current product.
     */
    private function setSameProducts()
    {
        $this->sameProducts = [];
        $language = $this->getLanguage();
        $country = $this->getCountry();
        $currency =$this->getCurrency();
        $sql = "SELECT `prodID` 
        FROM `Products` 
        WHERE isAvailable = 1 AND `prodID`!= '$this->prodID' AND `prodName` = '$this->prodName'  
        ORDER BY `Products`.`prodID` ASC";
        $tab = $this->select($sql);
        if (count($tab) > 0) {
            foreach ($tab as $tabLine) {
                $product = new BoxProduct($tabLine["prodID"], $language, $country, $currency);
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
     * Getter for product's stock for each size
     * @return int[] product's stock for each size
     */
    protected function getSizeStock()
    {
        (!isset($this->sizesStock)) ? $this->setSizesStock() : null;
        return $this->sizesStock;
    }

    /**
     * Getter for sameProducts
     * @return BoxProduct[] a prodtected copy of sameProducts
     */
    public function getSameProducts()
    {
        (!isset($this->sameProducts)) ? $this->setSameProducts() : null;
        return $this->sameProducts;
    }

    /**
     * Build a HTML displayable price
     * @param Country $country Visitor's current Country
     * @param Currency $currency Visitor's current Currency
     * @return string[] product's HTML displayable price
     */
    public function getDisplayablePrice()
    {
        $country = $this->getCountry();
        $currency =$this->getCurrency();
        $tab = $this->getBoxMap($country, $currency);
        $boxesPrices = [];
        foreach ($tab as $boxColor => $datas) {
            $boxPriceVal = $tab[$boxColor]["price"];

            $priceKey = number_format($boxPriceVal * 100, 2, "", "");
            $prodPrice = $boxPriceVal / $datas["sizeMax"];
            $prodPriceObj = new Price($prodPrice, $currency);

            $boxesPrices[$priceKey]["boxColor"] = $boxColor;
            $boxesPrices[$priceKey]["sizeMax"] = $datas["sizeMax"];
            $boxesPrices[$priceKey]["boxColorRGB"] = $datas["boxColorRGB"];
            $boxesPrices[$priceKey]["priceRGB"] = $datas["priceRGB"];
            $boxesPrices[$priceKey]["textualRGB"] = $datas["textualRGB"];
            $boxesPrices[$priceKey]["price"] = $prodPriceObj;
        }
        ksort($boxesPrices);
        ob_start();
        require 'view/elements/boxPrice.php';
        return ob_get_clean();
    }

    /**
     * Check if it's still stock for the product submited by Visitor
     * + it's still stock mean that there size that fit the Visitor's submited size
     * @param string $size to check if stock is available
     * @param string $brand never set for basket product
     * @param Measure $measure never set for basket product
     * @return boolean true if the stock is available
     */
    public function stillStock($size = null, $brand = null, Measure $measure = null)
    {
        if (empty($size) && empty($measure)) {
            throw new Exception("Size and measurement can't both be NULL");
        }
        if (!empty($size)) {
            // (!isset($this->sizesStock)) ? $this->decupleSizeStock() : null;
            $sizesStock = $this->getSizeStock();
            // if (!key_exists($size, $this->sizesStock)) {
            if (!key_exists($size, $sizesStock)) {
                throw new Exception("This size '$size' don't exist in sizesStock");
            }
            // return ($this->sizesStock[$size] > 0);
            return ($sizesStock[$size] > 0);
        }
        if (!empty($measure)) {
            // treat measure
        }
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
