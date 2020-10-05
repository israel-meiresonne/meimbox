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
        $prodID = $this->getProdID();
        // $sql = "SELECT * FROM `ProductsMeasures` WHERE `prodId` = '$this->prodID'";
        $sql = "SELECT * FROM `ProductsMeasures` 
                WHERE `prodId` = '$prodID'
                AND `value` IN	(SELECT MAX(`value`) FROM `ProductsMeasures` 
                                WHERE `prodId` = '$prodID'
                                GROUP BY `body_part` ASC)";
        $tab = $this->select($sql);
        if (count($tab) == 0) {
            throw new Exception("This product has any measure: id=$prodID");
        }
        $measureDatas  = [];
        foreach ($tab as $tabLine) {
            if (!isset($measureDatas["unitName"])) {
                $measureDatas["unitName"] = $tabLine["unit_name"];
            }
            if ($measureDatas["unitName"] != $tabLine["unit_name"]) {
                throw new Exception("Product unit measure must be the same for all its measures: id=$prodID, " . $measureDatas['unit_name'] . "!=" . $tabLine["unit_name"]);
            }
            // $bodyPart = "user" . ucfirst($tabLine["body_part"]);
            $bodyPart = $tabLine["body_part"];
            $measureDatas[$bodyPart] = (float) $tabLine["value"];
        }
        $measureMap = Measure::getDatas4Measure($measureDatas);

        // $this->measure = new Measure($measureDatas);
        $this->measure = new Measure($measureMap);
    }

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
        $sizeSample = array_keys($sizesStock)[0];
        $sizeType = $this->extractSizeType($dbSizes, $sizeSample);
        $this->checkSizeIsSupported($dbSizes, $sizesStock, $sizeType);

        $supportedSizes = $dbSizes->$sizeType;
        $newSizesStock = array_fill_keys($supportedSizes, 0);
        $sizesPos = array_flip($supportedSizes); // [$size => $pos] use size as key and index as value, each indix indicate the position of the size in $newSizesStock
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
        foreach ($supportedSizes as $size) {
            if (key_exists($size, $newSizesStock)) {
                $ordSizeStock[$size] = $newSizesStock[$size];
            }
        }
        $ordSizeStock = array_reverse($ordSizeStock);
        // $this->sizesStock = $ordSizeStock;
        return $ordSizeStock;
    }

    /**
     * To determinate the type of size holds by the current product
     * + Use a exemple of product's size to determinate the size type of the product
     * @param StdClass $dbSizes liste of size supported ordered by size type (access key)
     * @param string $sizeSample sample of size holds by the current prroduct
     * @return string the type of size holds by the current product
     */
    private  function extractSizeType($dbSizes, $sizeSample)
    {
        $sizeType = null;
        foreach ($dbSizes as $type => $supportedSizes) {
            $sizeType = $type;
            if (in_array($sizeSample, $dbSizes->$type)) {
                break;
            }
        }
        return $sizeType;
    }

    /**
     * To check if all sizes holds by the product is supported
     * @param StdClass $dbSizes liste of size supported ordered by size type (access key)
     * @param int[] $sizesStock list of size holds by the product
     * + size => stock
     * @param string $sizeType the type of size holds by the current product
     * @throw Exception if at less one are'nt supported
     */
    private function checkSizeIsSupported($dbSizes, $sizesStock, $sizeType)
    {
        foreach ($sizesStock as $size => $stock) {
            // if (!in_array($size, $dbSizes[$i])) {
            if (!in_array($size, $dbSizes->$sizeType)) {
                throw new Exception("The size '$size' is not supported by the system");
            }
        }
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
        $prodID = $this->getProdID();
        $language = $this->getLanguage();
        $country = $this->getCountry();
        $currency = $this->getCurrency();
        $sql = "SELECT `prodID` 
        FROM `Products` 
        WHERE isAvailable = 1 AND `prodID`!= '$prodID' AND `prodName` = '$this->prodName'  
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
     * Check if the product is a basket product
     * @return boolean true if the product is a basket product else false
     */
    public function isBasketProduct()
    {
        return false;
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

    private function getMeasure()
    {
        (!isset($this->measure)) ? $this->setMeasure() : null;
        return $this->measure;
    }

    /**
     * Getter for product's prrice
     * @return Price product's prrice
     * + for boxProduct will return Price with a zero as value
     */
    public function getPrice()
    {
        $currency = $this->getCurrency();
        $price = new Price(0, $currency);
        return $price;
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
        $currency = $this->getCurrency();
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
     * @param Size $sizeObj
     * @param string|null $size to check if stock is available
     * @param string|null $brand never set for basket product
     * @param Measure|null $measure never set for basket product
     * @return boolean true if the stock is available
     */
    // public function stillStock($size = null, $brand = null, Measure $measure = null)
    public function stillStock(Size $sizeObj)
    {
        $size = $sizeObj->getsize();
        $measure = $sizeObj->getMeasure();
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
            $prodMeasure = $this->getMeasure();
            $cut = $sizeObj->getCut();
            return Measure::compare($measure, $prodMeasure, $cut);
        }
    }

    /*———————————————————————————— SCRUD DOWN —————————————————————————————————————————*/

    /**
     * Insert product in db
     * @param Response $response if its success Response.isSuccess = true else Response
     *  contain the error thrown
     * @param string $boxID id of box that holds the product
     */
    public function insertProduct(Response $response, $boxID)
    {
        $bracket = "(?,?,?,?,?,?,?,?,?)"; // regex \[value-[0-9]*\]
        $sql = "INSERT INTO `Box-Products`(`boxId`, `prodId`, `sequenceID`, `size_name`, `brand_name`, `measureId`, `cut_name`, `quantity`, `setDate`)
            VALUES " . $this->buildBracketInsert(1, $bracket);
        $values = [];
        $sizeObj = $this->getSelectedSize();
        array_push($values, $boxID);
        array_push($values, $this->getProdID());
        array_push($values, $sizeObj->getSequence());
        array_push($values, $sizeObj->getsize());
        array_push($values, $sizeObj->getbrandName());
        array_push($values, $sizeObj->getmeasureID());
        array_push($values, $sizeObj->getCut());
        array_push($values, $this->getQuantity());
        array_push($values, $sizeObj->getSetDate());
        $this->insert($response, $sql, $values);
    }

    /**
     * Update product's quantity in db
     * + this function also update product's set date
     * @param Response $response if its success Response.isSuccess = true else Response
     *  contain the error thrown
     * @param string $boxID id of box that holds the product
     * @param Size $holdSize product's holds Size
     */
    public function updateProduct(Response $response, $boxID, Size $holdSize = null) // regex \[value-[0-9]*\]
    {
        $prodID = $this->getProdID();
        $sizeObj = $this->getSelectedSize();
        // $holdSize = (empty($holdSize)) ? $sizeObj : $holdSize;
        $sequence = (!empty($holdSize)) ? $holdSize->getSequence() : $sizeObj->getSequence();
        $sql =
            "UPDATE `Box-Products` SET 
            `sequenceID`= ?,
            `size_name`= ?,
            `brand_name`= ?,
            `measureId`= ?,
            `cut_name`= ?,
            `quantity`= ?,
            `setDate`= ? 
            WHERE `boxId`= '$boxID' 
            AND `prodId`= '$prodID' 
            AND `sequenceID`= '$sequence'";
        $values = [];
        array_push($values, $sizeObj->getSequence());
        array_push($values, $sizeObj->getsize());
        array_push($values, $sizeObj->getbrandName());
        array_push($values, $sizeObj->getmeasureID());
        array_push($values, $sizeObj->getCut());
        array_push($values, $this->getQuantity());
        array_push($values, $sizeObj->getSetDate());
        $this->update($response, $sql, $values);
    }

    /**
     * Delete from a box
     * @param Response $response if its success Response.isSuccess = true else Response
     *  contain the error thrown
     * @param string $boxID id of box that holds the product
     */
    public function deleteProduct(Response $response, $boxID)
    {
        $prodID = $this->getProdID();
        $sequence = $this->getSelectedSize()->getSequence();
        $sql = "DELETE FROM `Box-Products` 
            WHERE `Box-Products`.`boxId` = '$boxID' 
            AND `Box-Products`.`prodId` = '$prodID' 
            AND `Box-Products`.`sequenceID` = '$sequence';";
        $this->delete($response, $sql);
    }
}
