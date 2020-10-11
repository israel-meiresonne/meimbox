<?php

require_once 'model/tools-management/Measure.php';
require_once 'model/boxes-management/Product.php';

class BoxProduct extends Product
{

    /**
     * Holds the sizesStock attribut extended
     * @var int[]
     */
    private $virtualSizeStock;

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

    // /**
    //  * Setter for product's virtual size and stock
    //  */
    // protected function setSizeStock()
    // {
    //     parent::setSizeStock();
    //     $this->virtualSizeStock = $this->setVirtualSizeStock($this->sizesStock);
    // }

    /**
     * To get from db the supported sizes
     * @return StdClass the supported sizes get from db
     */
    private function getSupportedSizes()
    {
        $json = $this->getConstantLine(Size::SUPPORTED_SIZES)["jsonValue"];
        $dbSizes = json_decode($json);
        return $dbSizes;
    }

    /**
     * Set virtualSizeStock by decupling stock for each size
     * + decline each size in all size below and increase the stock
     * @param int[] $sizesStock list of size to decuple and their stock
     * + size => stock
     * @return int[] list of size => stock decupled
     */
    private function setVirtualSizeStock()
    {
        $this->virtualSizeStock = [];
        $sizesStock = $this->getSizeStock();
        // $json = $this->getConstantLine(Size::SUPPORTED_SIZES)["jsonValue"];
        // $dbSizes = json_decode($json);
        $dbSizes = $this->getSupportedSizes();
        $sizeSample = array_keys($sizesStock)[0];
        $sizeType = $this->extractSizeType($sizeSample);
        $this->checkSizeIsSupported($dbSizes, $sizesStock, $sizeType);

        $supportedSizes = $dbSizes->$sizeType;
        $newSizesStock = array_fill_keys($supportedSizes, 0);
        $sizesPos = array_flip($supportedSizes); // [$size => $pos] use size as key and index as value, each indix indicate the position of the size in $newSizesStock
        foreach ($sizesStock as $size => $stock) {
            $pos = $sizesPos[$size];
            $keys = array_keys(array_slice($newSizesStock, $pos));
            $newSizesStock = $this->increaseStock($newSizesStock, $keys, $stock);
        }
        foreach ($newSizesStock as $size => $stock) {
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
        // return $ordSizeStock;
        $this->virtualSizeStock = $ordSizeStock;
    }

    /**
     * To determinate the type of size holds by the current product
     * + Use a exemple of product's size to determinate the size type of the product
    //  * @param StdClass $dbSizes liste of size supported ordered by size type (access key)
     * @param string $sizeSample sample of size holds by the current prroduct
     * @return string the type of size holds by the current product
     */
    private  function extractSizeType($sizeSample)
    {
        $sizeType = null;
        // $json = $this->getConstantLine(Size::SUPPORTED_SIZES)["jsonValue"];
        // $dbSizes = json_decode($json);
        $dbSizes = $this->getSupportedSizes();
        foreach ($dbSizes as $type => $supportedSizes) {
            $sizeType = $type;
            if (in_array($sizeSample, $dbSizes->$type)) {
                break;
            }
        }
        if (empty($sizeType)) {
            throw new Exception("This type of size is not supported, size:$sizeSample");
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
     * To get sizeStock extanded with virtual sizes
     * @return int[] sizeStock extanded with virtual sizes
     */
    private function getVirtualSizeStock()
    {
        (!isset($this->virtualSizeStock)) ? $this->setVirtualSizeStock() : null;
        return $this->virtualSizeStock;
    }

    /**
     * Getter for product's sizes
     * + virtual and real size
     * @return string[] product's stock for each size
     */
    public function getSizes()
    {
        return array_keys($this->getVirtualSizeStock());
    }

    /**
     * To convert the selected size to a real size (existing in tthe db)
     * @return Size a new Size containing a real size
     */
    // private function SelectedToRealSize()
    public function SelectedToRealSize()
    {
        $selectedSize = $this->getSelectedSize();
        $size = null;
        $sizeType = $selectedSize->getType();
        switch ($sizeType) {
            case Size::SIZE_TYPE_ALPHANUM:
                $holdsSize = $selectedSize->getsize();
                $size = $this->virtualToRealSize($holdsSize);
                if (empty($size)) {
                    throw new Exception("this size '$holdsSize' can't be converted into real size");
                }
                break;
            case Size::SIZE_TYPE_MEASURE:
                // $holdsSize = $selectedSize->getsize();
                $measure = $selectedSize->getMeasure();
                $cut = $selectedSize->getCut();
                $size = $this->measureToRealSize($measure, $cut);
                if (empty($size)) {
                    $measureID = $measure->getMeasureID();
                    throw new Exception("this measure '$measureID' can't be converted into real size");
                }
                break;

            default:
                throw new Exception("This size type is not supported, sizeType:$sizeType");
                break;
        }
        $sequence = Size::buildSequence($size, null, null, null);
        $newSizeObj = new Size($sequence);
        $quantity = $selectedSize->getQuantity();
        $newSizeObj->setQuantity($quantity);
        return $newSizeObj;
    }

    /**
     * To convert a virtual size to a real size
     * @param string $size the virtual size to convert into real size
     * @return string the lower real size
     */
    private function virtualToRealSize($size)
    {
        $convertedSize = null;
        $sizeType = $this->extractSizeType($size);
        $supported = $this->getSupportedSizes()->$sizeType;
        $supportedFliped = array_flip($supported);

        $sizesStock = $this->getSizeStock();
        $realSizes  = array_keys($sizesStock);
        $realSizesIndexed = [];

        foreach ($realSizes as $realSize) {
            $index =  $supportedFliped[$realSize];
            $realSizesIndexed[$index] = $realSize;
        }
        ksort($realSizesIndexed);
        $sizeIndex = $supportedFliped[$size];
        $i = $sizeIndex;
        while ($i >= 0) {
            if (key_exists($i, $realSizesIndexed)) {
                $convertedSize = $realSizesIndexed[$i];
                break;
            }
            $i--;
        }
        return $convertedSize;
    }

    /**
     * To convert a measure size to a real size
     * @param Measure $measure the measure to convert
     * @param string $cut used to get the margin error
     * @return string the lower real size
     */
    private function measureToRealSize(Measure $measure, $cut)
    {
        $convertedSize = null;
        $comonSizes = [];
        $bodyPartSizes = [];
        $cutMap = parent::getTableValues("cuts");
        $value = $cutMap[$cut]["cutMeasure"];
        $unitName = $cutMap[$cut]["unit_name"];
        $cutObj = new MeasureUnit($value, $unitName);
        if (!empty($measure->getarm())) {
            $bodyPart = $measure->getarm();
            $value = ($bodyPart->getValue() * $bodyPart->getToSystUnit()) + ($cutObj->getValue() * $cutObj->getToSystUnit());
            $bodyPartSizes = $this->getSizesOver(Measure::INPUT_ARM, $value);
            $comonSizes = $bodyPartSizes;
        }
        if (!empty($measure->getbust())) {
            $bodyPart = $measure->getbust();
            $value = ($bodyPart->getValue() * $bodyPart->getToSystUnit()) + ($cutObj->getValue() * $cutObj->getToSystUnit());
            $bodyPartSizes = $this->getSizesOver(Measure::INPUT_BUST, $value);
            $comonSizes = $this->keepComon($comonSizes, $bodyPartSizes);
        }
        if (!empty($measure->gethip())) {
            $bodyPart = $measure->gethip();
            $value = ($bodyPart->getValue() * $bodyPart->getToSystUnit()) + ($cutObj->getValue() * $cutObj->getToSystUnit());
            $bodyPartSizes = $this->getSizesOver(Measure::INPUT_HIP, $value);
            $comonSizes = $this->keepComon($comonSizes, $bodyPartSizes);
        }
        if (!empty($measure->getInseam())) {
            $bodyPart = $measure->getInseam();
            $value = ($bodyPart->getValue() * $bodyPart->getToSystUnit()) + ($cutObj->getValue() * $cutObj->getToSystUnit());
            $bodyPartSizes = $this->getSizesOver(Measure::INPUT_INSEAM, $value);
            $comonSizes = $this->keepComon($comonSizes, $bodyPartSizes);
        }
        if (!empty($measure->getwaist())) {
            $bodyPart = $measure->getwaist();
            $value = ($bodyPart->getValue() * $bodyPart->getToSystUnit()) + ($cutObj->getValue() * $cutObj->getToSystUnit());
            $bodyPartSizes = $this->getSizesOver(Measure::INPUT_WAIST, $value);
            $comonSizes = $this->keepComon($comonSizes, $bodyPartSizes);
        }
        if(!empty($comonSizes)){
            $minIndex = min(array_keys($comonSizes));
            $convertedSize = $comonSizes[$minIndex];
        }
        return $convertedSize;
    }

    /**
     * To merge two map by keeping line whith the same value
     * @return string[]
     */
    private function keepComon($map1, $map2)
    {
        $newMap = [];
        if ($map1) {
            foreach ($map1 as $key1 => $value1) {
                if (in_array($value1, $map2)) {
                    $newMap[$key1] = $value1;
                }
            }
        }
        return $newMap;
    }

    /**
     * To get size name where dimension value is overt than the give dimension
     * @param string $bodyPart 
     * @param string $value 
     * @return string set of size where dimension value is overt than the give dimension
     */
    private function getSizesOver($bodyPart, $value)
    {
        $sizesOver = [];
        $prodID = $this->getProdID();
        $sql = "SELECT *
        FROM `ProductsMeasures`
        WHERE `prodId`='$prodID' AND (`body_part`='$bodyPart' AND `value`>=$value)  
        ORDER BY `ProductsMeasures`.`value` ASC";
        $tab = $this->select($sql);
        if (!empty($tab)) {
            foreach ($tab as $tabLine) {
                $size = $tabLine["size_name"];
                array_push($sizesOver, $size);
            }
        }
        return $sizesOver;
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
     * To get the biggest  measure available for this product
     * @return Measure the biggest  measure available for this product
     */
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
     * @param Size $sizeObj thee selected size to check if still stock for it
     * @return boolean true if the stock is available
     */
    public function stillStock(Size $sizeObj)
    {
        $size = $sizeObj->getsize();
        $measure = $sizeObj->getMeasure();
        if (empty($size) && empty($measure)) {
            throw new Exception("Size and measurement can't both be NULL");
        }
        if (isset($size) && isset($measure)) {
            throw new Exception("Size and measurement can't both be setted");
        }
        $stillStock = false;
        if (!empty($size)) {
            $virtualSizesStock = $this->getVirtualSizeStock();
            if (!key_exists($size, $virtualSizesStock)) {
                throw new Exception("This size '$size' don't exist in virtualSizesStock");
            }
            $stillStock = ($virtualSizesStock[$size] > 0);
        }
        if (!empty($measure)) {
            $prodMeasure = $this->getMeasure();
            $cut = $sizeObj->getCut();
            $stillStock = Measure::compare($measure, $prodMeasure, $cut);
        }
        return $stillStock;
    }

    /*———————————————————————————— SCRUD DOWN —————————————————————————————————————————*/

    /**
     * Insert product in db
     * @param Response $response to push in results or accured errors
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
     * @param Response $response to push in results or accured errors
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
     * @param Response $response to push in results or accured errors
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

    /**
     * To insert boxProduct ordred
     * @param Response $response to push in results or accured errors
     * @param Box[] $boxes set of boxes ordered
     * @param string $orderID id of an order
     */
    public static function orderProducts(Response $response, $boxes, $orderID)
    {
        $measures = [];
        // $measureValues = [];
        $values = [];
        $nbProd = 0;
        $stockResponse = new Response();
        $toDecreaseProds = [];
        foreach ($boxes as $box) {
            $products = $box->getBoxProducts();
            $nbProd += count($products);
            if (!empty($products)) {
                foreach ($products as $product) {
                    array_push($toDecreaseProds, $product);
                    $size = $product->getSelectedSize();
                    if ($size->getType() == Size::SIZE_TYPE_MEASURE) {
                        $measure = $size->getMeasure();
                        $measureID = $measure->getMeasureID();
                        if (!key_exists($measureID, $measures)) {
                            $measures[$measureID] = $measure;
                        }
                    }
                    $stillStock = $product->stillStock($size);
                    ((!$stillStock) && (!$stockResponse->existErrorKey(MyError::ERROR_STILL_STOCK)))
                        ? $stockResponse->addError($stillStock, MyError::ERROR_STILL_STOCK)
                        : null;
                    array_push(
                        $values,
                        $box->getBoxID(),
                        $product->getProdID(),
                        $size->getSequence(),
                        $product->getType(),
                        $product->SelectedToRealSize()->getSize(),
                        $product->getWeight(),
                        $size->getsize(),
                        $size->getbrandName(),
                        $size->getmeasureID(),
                        $size->getCut(),
                        $size->getQuantity(),
                        $size->getSetDate(),
                        ((int) $stillStock)
                    );
                }
            }
        }
        $bracket = "(?,?,?,?,?,?,?,?,?,?,?,?,?)"; // regex \[value-[0-9]*\]
        $sql = "INSERT INTO `Orders-BoxProducts`(`boxId`, `prodId`, `sequenceID`, `product_type`, `realSize`, `weight`, `size_name`, `brand_name`, `measureId`, `cut_name`, `quantity`, `setDate`, `stillStock`)
                VALUES " . self::buildBracketInsert($nbProd, $bracket);
        (!empty($measures)) ?  Measure::insertOrderMeasures($response, $measures, $orderID) : null;
        if (!$response->containError()) {
            self::insert($response, $sql, $values);
        }
        if ($stockResponse->existErrorKey(MyError::ERROR_STILL_STOCK)) {
            $stillStock = $stockResponse->getError(MyError::ERROR_STILL_STOCK)->getMeassage();
            $response->addError($stillStock, MyError::ERROR_STILL_STOCK);
        }
        self::decreaseStock($response, $toDecreaseProds);
    }

    /**
     * To decrease the stock of a set of products
     * @param Response $response to push in results or accured errors
     * @param BoxProduct[] $products set of product to decrease
     */
    private static function decreaseStock(Response $response, $products)
    {
        $sql = "";
        foreach ($products as $product) {
            $sizeObj = $product->SelectedToRealSize();
            $size = $sizeObj->getSize();
            $quantity = $sizeObj->getQuantity();
            $prodID = $product->getProdID();
            $sql .= "UPDATE `Products-Sizes` SET `stock`=`stock`-$quantity WHERE `prodId` = '$prodID' AND `size_name` = '$size';\n";
        }
        self::update($response, $sql, []);
    }
}