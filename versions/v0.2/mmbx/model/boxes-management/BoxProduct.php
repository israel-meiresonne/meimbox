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
     * Holds the selected size converted into a real stock size
     * @var Size
     */
    private $realSelectedSize;

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
    // public function __construct($prodID, Language $language, Country $country, Currency $currency)
    public function __construct()
    {
        $args = func_get_args();
        $nb = func_num_args();
        switch ($nb) {
            case 4:
                $this->__construct4($args[0], $args[1], $args[2], $args[3]);
                break;
            case 0:
                $this->__construct0();
                break;

            default:
                throw new Exception("The number of param is incorrect, number:$nb");
                break;
        }
        // parent::__construct($prodID, $language, $country, $currency);
        // $this->setMeasure();
    }

    private function __construct0()
    {
    }

    private function __construct4($prodID, Language $language, Country $country, Currency $currency)
    {
        parent::__construct($prodID, $language, $country, $currency);
    }

    // /**
    //  * Setter for BoxProduct's measure
    //  */
    // private function setMeasure()
    // {
    //     $prodID = $this->getProdID();
    //     // $sql = "SELECT * FROM `ProductsMeasures` WHERE `prodId` = '$this->prodID'";
    //     $sql = "SELECT * FROM `ProductsMeasures` 
    //             WHERE `prodId` = '$prodID'
    //             AND `value` IN	(SELECT MAX(`value`) FROM `ProductsMeasures` 
    //                             WHERE `prodId` = '$prodID'
    //                             GROUP BY `body_part` ASC)";
    //     $tab = $this->select($sql);
    //     if (count($tab) == 0) {
    //         throw new Exception("This product has any measure: id=$prodID");
    //     }
    //     $measureDatas  = [];
    //     foreach ($tab as $tabLine) {
    //         if (!isset($measureDatas["unitName"])) {
    //             $measureDatas["unitName"] = $tabLine["unit_name"];
    //         }
    //         if ($measureDatas["unitName"] != $tabLine["unit_name"]) {
    //             throw new Exception("Product unit measure must be the same for all its measures: id=$prodID, " . $measureDatas['unit_name'] . "!=" . $tabLine["unit_name"]);
    //         }
    //         // $bodyPart = "user" . ucfirst($tabLine["body_part"]);
    //         $bodyPart = $tabLine["body_part"];
    //         $measureDatas[$bodyPart] = (float) $tabLine["value"];
    //     }
    //     $measureMap = Measure::getDatas4Measure($measureDatas);

    //     // $this->measure = new Measure($measureDatas);
    //     $this->measure = new Measure($measureMap);
    // }

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
        $sizeSample = array_keys($sizesStock)[0];
        $supportedSizes = $this->getSupportedSizes($sizeSample);
        // $supportedSizes = $dbSizes->$sizeType;
        $newSizesStock = array_fill_keys($supportedSizes, 0);
        foreach ($sizesStock as $size => $stock) {
            $newSizesStock = $this->increaseStockBelow($newSizesStock, $size, $stock);
        }

        /** To remove sizes that are bigger than the bigger real size */
        $ordSizesStock =  $this->orderSizes($supportedSizes, $newSizesStock);
        $biggerRealSize = array_reverse(array_keys($sizesStock))[0];
        $ordSizesStockReversed = array_reverse($ordSizesStock);
        foreach ($ordSizesStockReversed as $size => $stock) {
            if ($size == $biggerRealSize) {
                break;
            } else {
                $ordSizesStock[$size] = null;
                unset($ordSizesStock[$size]);
            }
        }
        $this->virtualSizeStock = $ordSizesStock;
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
     * Increase stock value of given the size and sizes below
     * @param string[]  $newSizesStock  list of size
     *                                  + $newSizesStock[size{string|int}] => stock{int}
     * @param string    $startSize      size from which to start to increase
     * @param int       $stock          amount of stock to add
     * @return string[] size stock increased
     */
    private function increaseStockBelow($newSizesStock, $startSize, int $stock)
    {
        $supportedSizes = $this->getSupportedSizes($startSize);
        $sizesToPos = array_flip($supportedSizes); // to flip array from [$index => $size] to [$size => $index] 
        $startIndex = $sizesToPos[$startSize];
        for ($i = $startIndex; $i >= 0; $i--) {
            $size = $supportedSizes[$i];
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
     * @return string[] product's sizes
     */
    public function getSizes()
    {
        return array_keys($this->getVirtualSizeStock());
    }

    /**
     * Set product's selected size
     * @param Size $size 
     */
    public function selecteSize(Size $size)
    {
        $this->realSelectedSize = null;
        $this->selectedSize = $size;
    }

    /**
     * To convert the selected size to a real size (existing in tthe db)
     */
    private function setRealSelectedSize()
    {
        $selectedSize = $this->getSelectedSize();
        $sizesStock = $this->getSizeStock();
        $newSizeObj = $this->convertSizeToRealSize($sizesStock, $selectedSize);
        $this->realSelectedSize =  $newSizeObj;
    }

    /**
     * To convert a Size object into a size of sizeStock
     * + Note: Size with Measure can be unconvertible if Measure suit any real size from sizeStock
     * @param mixed[] $sizesStock product's stock
     * @param Size $sizeObj the Size to convert
     * @return Size|null Size converrted into a size of sizeStock else null if Size is unconvertible
     */
    // public static function convertSizeToRealSize($sizesStock, Size $sizeToconvert)
    private static function convertSizeToRealSize($sizesStock, Size $sizeToconvert)
    {
        $size = null;
        $sizeConverted = null;
        $sizeType = $sizeToconvert->getType();
        switch ($sizeType) {
            case Size::SIZE_TYPE_ALPHANUM:
                $virtualSize = $sizeToconvert->getsize();
                $size = self::virtualToRealSize($sizesStock, $virtualSize);
                break;
            case Size::SIZE_TYPE_MEASURE:
                $measure = $sizeToconvert->getMeasure();
                $cut = $sizeToconvert->getCut();
                $sizes = array_keys($sizesStock);
                $size = self::measureToRealSize($sizes, $measure, $cut);
                break;

            default:
                throw new Exception("This size type '$sizeType' is not supported");
                break;
        }
        if (isset($size)) {
            $sequence = Size::buildSequence($size, null, null, null);
            $sizeConverted = new Size($sequence);
            $quantity = $sizeToconvert->getQuantity();
            $sizeConverted->setQuantity($quantity);
        }
        return $sizeConverted;
    }

    /**
     * To convert a virtual size to a real size
     * @param mixed[] $sizesStock product's stock
     * @param string $virtualSize the virtual size to convert into real size
     * @return string the lower real size
     */
    private static function virtualToRealSize($sizesStock, $virtualSize)
    {
        $convertedSize = null;
        // $sizesStock = $this->getSizeStock();
        $sizeSample = array_keys($sizesStock)[0];
        $supported = array_reverse(Size::getSupportedSizes($sizeSample));
        $supportedFliped = array_flip($supported);

        $realSizes  = array_keys($sizesStock);
        $realSizesIndexed = [];     // [index => realSize]

        foreach ($realSizes as $realSize) {
            $index =  $supportedFliped[$realSize];
            $realSizesIndexed[$index] = $realSize;
        }
        ksort($realSizesIndexed);   // low to hight index
        $sizeIndex = $supportedFliped[$virtualSize];
        if (!isset($sizeIndex)) {
            throw new Exception("This size '$virtualSize' is not valid");
        }

        $i = $sizeIndex;
        while ($i >= 0) {
            if (key_exists($i, $realSizesIndexed)) {
                $convertedSize = $realSizesIndexed[$i];
                break;
            }
            $i--;
        }
        if (empty($convertedSize)) {
            throw new Exception("This size '$convertedSize' can't be converted into real size");
        }
        return $convertedSize;
    }

    /**
     * To convert a measure size to a real size
     * @param Measure $measure the measure to convert
     * @param mixed[]   $sizes  product's real sizes
     *                          + $sizes[index] => size{string|int}
     * @param string    $cut    used to get the margin error
     * @return string|null the lower real size with dimension over those of the measure given
     */
    private static function measureToRealSize($sizes, Measure $measure, $cut)
    {
        $convertedSize = null;
        $orderedSizesLH = Size::orderSizes($sizes);
        foreach ($orderedSizesLH as $size) {
            $sizeMeasure = Size::getSizeMeasure($size);
            if (Measure::isUnderLimite($measure, $sizeMeasure, $cut)) {
                $convertedSize = $size;
                break;
            }
        }
        return $convertedSize;
    }

    // /**
    //  * To merge two map by keeping key/value couple present in the both array
    //  * @return string[]
    //  */
    // private function keepCommon($map1, $map2)
    // {
    //     $newMap = [];
    //     if ($map1) {
    //         foreach ($map1 as $key1 => $value1) {
    //             if (in_array($value1, $map2)) {
    //                 $newMap[$key1] = $value1;
    //             }
    //         }
    //     }
    //     return $newMap;
    // }

    // /**
    //  * To get size name where dimension value is overt than the give dimension
    //  * @param string $bodyPart 
    //  * @param string $value 
    //  * @return string[] set of size where dimension value is overt than the give dimension
    //  */
    // private function getSizesOver($bodyPart, $value)
    // {
    //     // var_dump("body part: $bodyPart");
    //     // var_dump("value: $value");
    //     $sizesOver = [];
    //     $prodID = $this->getProdID();
    //     $sql = "SELECT *
    //     FROM `ProductsMeasures`
    //     WHERE `prodId`='$prodID' AND (`body_part`='$bodyPart' AND `value`>=$value)  
    //     ORDER BY `ProductsMeasures`.`value` ASC";
    //     $tab = $this->select($sql);
    //     if (!empty($tab)) {
    //         foreach ($tab as $tabLine) {
    //             $size = $tabLine["size_name"];
    //             array_push($sizesOver, $size);
    //         }
    //     }
    //     // var_dump("sizesOver:", $sizesOver);
    //     return $sizesOver;
    // }

    /**
     * To get the selected size converted into a real size present in stock
     * @return Size|null the selected size converted into a real size present 
     * in stock else null if unconvertible
     */
    public function getRealSelectedSize()
    {
        (!isset($this->realSelectedSize)) ? $this->setRealSelectedSize() : null;
        return $this->realSelectedSize;
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

    // /**
    //  * To get the biggest  measure available for this product
    //  * @return Measure the biggest  measure available for this product
    //  */
    // private function getMeasure()
    // {
    //     (!isset($this->measure)) ? $this->setMeasure() : null;
    //     return $this->measure;
    // }

    /**
     * Getter for product's price
     * @return Price product's price
     * + for boxProduct will return Price with a zero as value
     */
    public function getPrice()
    {
        $currency = $this->getCurrency();
        $price = new Price(0, $currency);
        return $price;
    }

    /**
     * Getter for product's formated price
     * @return string product's formated price
     */
    public function getFormatedPrice()
    {
        // $price = $this->getPrice();
        // return $price->getFormated();
        return "—";
    }

    // /**
    //  * Build a HTML displayable price
    //  * @param Country $country Visitor's current Country
    //  * @param Currency $currency Visitor's current Currency
    //  * @return string[] product's HTML displayable price
    //  */
    // public function getDisplayablePrice()
    // {
    //     $country = $this->getCountry();
    //     $currency = $this->getCurrency();
    //     $tab = $this->getBoxMap($country, $currency);
    //     $boxesPrices = [];
    //     foreach ($tab as $boxColor => $datas) {
    //         $boxPriceVal = $tab[$boxColor]["price"];

    //         $priceKey = number_format($boxPriceVal * 100, 2, "", "");
    //         $prodPrice = $boxPriceVal / $datas["sizeMax"];
    //         $prodPriceObj = new Price($prodPrice, $currency);

    //         $boxesPrices[$priceKey]["boxColor"] = $boxColor;
    //         $boxesPrices[$priceKey]["sizeMax"] = $datas["sizeMax"];
    //         $boxesPrices[$priceKey]["boxColorRGB"] = $datas["boxColorRGB"];
    //         $boxesPrices[$priceKey]["priceRGB"] = $datas["priceRGB"];
    //         $boxesPrices[$priceKey]["textualRGB"] = $datas["textualRGB"];
    //         $boxesPrices[$priceKey]["price"] = $prodPriceObj;
    //     }
    //     ksort($boxesPrices);
    //     ob_start();
    //     require 'view/elements/boxPrice.php';
    //     return ob_get_clean();
    // }

    /**
     * Check if it's still stock for the product submited by Visitor
     * + it's still stock mean that there size that fit the Visitor's submited size
     * @param Size $sizeObjs selected sizes to check if still stock for it
     * + Note: sizes need to be from product with the same id
     * @return boolean true if the stock is available
     */
    public function stillStock(Size ...$sizeObjs)
    {
        $stillStock = false;
        $sizesStock = $this->getSizeStock();
        $sizeSample = array_keys($sizesStock)[0];
        $supported = array_reverse($this->getSupportedSizes($sizeSample)); // hight size to low
        foreach ($sizeObjs as $sizeObj) {
            $realSelectedSize = self::convertSizeToRealSize($sizesStock, $sizeObj);
            if (!isset($realSelectedSize)) {
                $stillStock = false;
                break;
            }
            $realSize = $realSelectedSize->getsize();
            $index = array_search($realSize, $supported);
            $quantity = $sizeObj->getQuantity();
            while ($index >= 0) {
                if (key_exists($realSize, $sizesStock)) {
                    $stock = $sizesStock[$realSize];
                    $delta = $quantity - $stock;
                    if ($delta > 0) {
                        $quantity = $delta;
                        $sizesStock[$realSize] = 0;
                    } else { // $delta <= 0
                        $quantity = 0;
                        $sizesStock[$realSize] = abs($delta);
                        break;
                    }
                }
                $index--;
                $realSize = ($index >= 0) ? $supported[$index] : $realSize;
            }
            $stillStock = ($quantity == 0);
            if (!$stillStock) {
                break;
            }
        }
        return $stillStock;
    }

    /**
     * Check if there's enought stock after removing locked stock from stock
     * + Note: use this function after checked if still stock with BoxProduct::stillStock()
     * @param BoxProduct[]  $products set of product to decrease
     *                      + Note: products must share the same id
     * @return boolean true if still stock else false
     */
    public static function stillUnlockedStock(array $products)
    {
        $stillUnlockedStock = true;
        $product =  $products[0];
        $prodID = $product->getProdID();
        $sizesStock = $product->getSizeStock();
        $supported = Size::getSupportedSizes(array_keys($sizesStock)[0]);

        $lockLimit = parent::getCookiesMap()->get(Cookie::COOKIE_LCK, Map::period);
        $endTime = time() - $lockLimit;
        $endDate = date('Y-m-d H:i:s', $endTime);
        $sql = "SELECT * FROM `StockLocks`WHERE `prodId`='$prodID' AND `setDate`>='$endDate'";
        $tab = parent::select($sql);
        if (!empty($tab)) {
            $sizesLockedMap = new Map();
            foreach ($tab as $tabLine) {
                $size = $tabLine["size_name"];
                $setDate = $tabLine["setDate"];
                $quantity = $tabLine["quantity"];
                $sequence = Size::buildSequence($size, null, null, null);
                $sizeObj = new Size($sequence, $setDate);
                $sizeObj->setQuantity($quantity);
                $keys = $sizesLockedMap->getKeys();
                $sizesLockedMap->put($sizeObj, count($keys));
            }
            $lockedSizeObjs = $sizesLockedMap->getMap();
            $lockedResultMap = self::decreaseStock($supported, $sizesStock, $lockedSizeObjs);
            $lockedQuantity = $lockedResultMap->get(Map::quantity);
            $stillUnlockedStock = ($lockedQuantity == 0);
            $freeSizesStock = $lockedResultMap->get(Map::size);
            $notifAdmin = new Response();
            self::handleDecreaseErrors($notifAdmin, $lockedResultMap, $prodID, __METHOD__);
        }
        if ($stillUnlockedStock) {
            $freeSizesStock = (!empty($freeSizesStock)) ? $freeSizesStock : $sizesStock;
            $sizesMap = Product::extractSizes($products);
            $freeSizeObjs = parent::keysToAscInt($sizesMap->getMap());
            $freeResultMap = self::decreaseStock($supported, $freeSizesStock, $freeSizeObjs);
            $freeQuantity = $freeResultMap->get(Map::quantity);
            $stillUnlockedStock = ($freeQuantity == 0);
            $notifAdmin = (!empty($notifAdmin)) ? $notifAdmin : new Response();
            self::handleDecreaseErrors($notifAdmin, $freeResultMap, $prodID, __METHOD__);
        }
        // var_dump(str_repeat("-", 10) . " endDate: $endDate " . str_repeat("-", 10));                            // ❌
        // echo "\n";                                                                                              // ❌
        // var_dump(str_repeat("-", 10) . " tab " . str_repeat("-", 10), $tab);                                    // ❌
        // echo "\n";                                                                                              // ❌
        // var_dump(str_repeat("-", 10) . " sizesStock " . str_repeat("-", 10), $sizesStock);                      // ❌
        // echo "\n";                                                                                              // ❌
        // var_dump(str_repeat("-", 10) . " sizesLockedMap " . str_repeat("-", 10), $sizesLockedMap);              // ❌
        // echo "\n";                                                                                              // ❌
        // var_dump(str_repeat("-", 10) . " lockedResultMap " . str_repeat("-", 10), $lockedResultMap);            // ❌
        // echo "\n";                                                                                              // ❌
        // var_dump(str_repeat("-", 10) . " freeSizeObjs " . str_repeat("-", 10), $freeSizeObjs);                  // ❌
        // echo "\n";                                                                                              // ❌
        // var_dump(str_repeat("-", 10) . " freeResultMap " . str_repeat("-", 10), $freeResultMap);                // ❌
        // echo "\n";                                                                                              // ❌
        // var_dump(str_repeat("-", 10) . " notifAdmin " . str_repeat("-", 10), $notifAdmin);                      // ❌
        // echo "\n";
        return $stillUnlockedStock;
    }

    /**
     * To reserve ,for a duration, the selected stock of the product
     * @param Response      $response   where to strore results
     * @param string        $userID     Client's id
     * @param BoxProduct[]  $products   products sharing the same id
     */
    public static function lock(Response $response, $userID, array $products)
    {
        $product =  $products[0];
        $sizesStock = $product->getSizeStock();
        $prodID = $product->getProdID();
        $sizesMap = Product::extractSizes($products);
        $selectedSizes = parent::keysToAscInt($sizesMap->getMap());
        $supported = Size::getSupportedSizes(array_keys($sizesStock)[0]);
        $resultMap = self::decreaseStock($supported,  $sizesStock, $selectedSizes);
        $stillingSizesStock = $resultMap->get(Map::size);
        $stockToLocks = [];
        foreach ($stillingSizesStock as $size => $stillingStock) {
            if ($sizesStock[$size] != $stillingSizesStock[$size]) {
                $stock = $sizesStock[$size];
                $stockToLocks[$size] = ($stock - $stillingStock);
            }
        }
        $quantity = $resultMap->get(Map::quantity);
        if ($quantity > 0) {
            $notifAdmin = new Response();
            $erMsg = "Not enough stock (missing stock:'$quantity') for product '$prodID' in " . __METHOD__;
            $notifAdmin->addError($erMsg, MyError::ADMIN_ERROR);
        }
        $errors = $resultMap->get(Map::error);
        foreach ($errors as $erMsg) {
            $notifAdmin = (!empty($notifAdmin)) ? $notifAdmin : new Response();
            $erMsg .= " in " . __METHOD__;
            $notifAdmin->addError($erMsg, MyError::ADMIN_ERROR);
        }
        // var_dump("sizesStock: ", $sizesStock);      // ❌
        // var_dump("resultMap: ", $resultMap);        // ❌
        // var_dump("stockToLocks:", $stockToLocks);   // ❌
        // var_dump("notifAdmin:", $notifAdmin);       // ❌
        self::insertLocks($response, $userID, $prodID, $stockToLocks);
    }

    /**
     * To deacrease stock
     * @param Response  $response to push in results or accured errors
     * @param mixed[]   $supported  list of supported size ordered from low to hight
     * @param int[]     $sizesStock  stock to decrease
     * @param Size[]    $sizeObjs   list of Size from products sharing the same id
     * @return Map      result of the decrreasing
     *                  + Map[Map::quantity]        =>  int holds surplus of size asked
     *                  + Map[Map::size]            =>  stock decreased
     *                  + Map[Map::error][index]    =>  set of error messages occured
     */
    // public static function decreaseStock(array $supported, array $sizesStock, array $sizeObjs)
    private static function decreaseStock(array $supported, array $sizesStock, array $sizeObjs)
    {
        $stillStock = false;
        $errors = [];
        $result = new Map();
        $supported = array_reverse($supported);
        foreach ($sizeObjs as $sizeObj) {
            $realSelectedSize = self::convertSizeToRealSize($sizesStock, $sizeObj);
            if (!isset($realSelectedSize)) {
                $sequence = $sizeObj->getSequence();
                $erMsg = "Size '$sequence' can't be converted into real size";
                array_push($errors, $erMsg);
                continue;
            }
            $realSize = $realSelectedSize->getsize();
            $index = array_search($realSize, $supported);
            $quantity = $sizeObj->getQuantity();
            while ($index >= 0) {
                if (key_exists($realSize, $sizesStock)) {
                    $stock = $sizesStock[$realSize];
                    $delta = $quantity - $stock;
                    if ($delta > 0) {
                        $quantity = $delta;
                        $sizesStock[$realSize] = 0;
                    } else { // $delta <= 0
                        $quantity = 0;
                        $sizesStock[$realSize] = abs($delta);
                        break;
                    }
                }
                $index--;
                $realSize = ($index >= 0) ? $supported[$index] : $realSize;
            }
            $stillStock = ($quantity == 0);
            if (!$stillStock) {
                break;
            }
        }
        $result->put($quantity, Map::quantity);
        $result->put($sizesStock, Map::size);
        $result->put($errors, Map::error);
        return $result;
    }

    /**
     * To handle result returned by the BoxProduct::decreasStock
     * @param Response      $response   where to strore results
     * @param Map           $resultMap  containt result returned 
     */
    private static function handleDecreaseErrors(Response $response, Map $resultMap, $prodID, string $method)
    {
        $quantity = $resultMap->get(Map::quantity);
        if ($quantity > 0) {
            $erMsg = "Not enough stock (missing stock:'$quantity') for product '$prodID' in $method";
            $response->addError($erMsg, MyError::ADMIN_ERROR);
        }
        $errors = $resultMap->get(Map::error);
        foreach ($errors as $erMsg) {
            $erMsg .= " in $method";
            $response->addError($erMsg, MyError::ADMIN_ERROR);
        }
    }

    /**
     * To get A copy of the currrent instance
     * @return BasketProduct
     */
    public function getCopy()
    {
        $map = get_object_vars($this);
        $attributs = array_keys($map);
        $class = get_class($this);
        $copy = new $class();
        foreach ($attributs as $attribut) {
            switch (gettype($this->{$attribut})) {
                    // case 'object':
                    //     $copy->{$attribut} = $this->{$attribut}->getCopy();
                    //     break;
                default:
                    $copy->{$attribut} = $this->{$attribut};
                    break;
            }
        }
        return $copy;
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
        $values = [];
        $nbProd = 0;
        $stockResponse = new Response();

        /** To boxes to know in witch box is each product */
        $prodToBoxMap = Box::getProductToBox(...$boxes);

        /** check if still stock for all product */
        $stillStock = false;
        $boxProductsMap = Box::extractBoxProducts($boxes);
        $prodIDs = $boxProductsMap->getKeys();
        foreach ($prodIDs as $prodID) {
            /**
             * @var BoxProduct[] */
            $products = $boxProductsMap->get($prodID);
            $sizesMap = Product::extractSizes($products);
            $selectedSizes = parent::keysToAscInt($sizesMap->getMap());

            $stillStock = $products[0]->stillStock(...$selectedSizes);
            ((!$stillStock) && (!$stockResponse->existErrorKey(MyError::ERROR_STILL_STOCK)))
                ? $stockResponse->addError($stillStock, MyError::ERROR_STILL_STOCK)
                : null;

            $nbProd += count($products);
            foreach ($products as $product) {
                $size = $product->getSelectedSize();
                if ($size->getType() == Size::SIZE_TYPE_MEASURE) {
                    $measure = $size->getMeasure();
                    $measureID = $measure->getMeasureID();
                    if (!key_exists($measureID, $measures)) {
                        $measures[$measureID] = $measure;
                    }
                }

                $prodUnix = $product->getDateInSec();
                array_push(
                    $values,
                    $prodToBoxMap->get($prodUnix),
                    $product->getProdID(),
                    $size->getSequence(),
                    $product->getType(),
                    $product->getRealSelectedSize()->getSize(),
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
            ($stillStock) ? self::updateStock($response, $products) : null; // don't touch stock if there's not enought stock, but order will be saved
        }

        $bracket = "(?,?,?,?,?,?,?,?,?,?,?,?,?)"; // regex \[value-[0-9]*\]
        $sql = "INSERT INTO `Orders-BoxProducts`(`boxId`, `prodId`, `sequenceID`, `product_type`, `realSize`, `weight`, `size_name`, `brand_name`, `measureId`, `cut_name`, `quantity`, `setDate`, `stillStock`)
                VALUES " . self::buildBracketInsert($nbProd, $bracket);
        (!empty($measures)) ?  Measure::insertOrderMeasures($response, $measures, $orderID) : null;
        // if (!$response->containError()) {
        self::insert($response, $sql, $values);
        // }
        if ($stockResponse->existErrorKey(MyError::ERROR_STILL_STOCK)) {
            $stillStock = $stockResponse->getError(MyError::ERROR_STILL_STOCK)->getMeassage();
            $response->addError($stillStock, MyError::ERROR_STILL_STOCK);
        }
    }

    /**
     * To decrease the stock of a set of products
     * @param Response      $response to push in results or accured errors
     * @param BoxProduct[]  $products set of product to decrease
     *                      + Note: products must share the same id
     */
    // public static function updateStock(Response $response, $products)
    private static function updateStock(Response $response, $products)
    {
        $sql = "";
        $product =  $products[0];
        $prodID = $product->getProdID();
        $sizesStock = $product->getSizeStock();
        $sizesMap = Product::extractSizes($products);
        $selectedSizes = parent::keysToAscInt($sizesMap->getMap());
        $supported = Size::getSupportedSizes(array_keys($sizesStock)[0]);
        $resultMap = self::decreaseStock($supported,  $sizesStock, $selectedSizes);
        $quantity = $resultMap->get(Map::quantity);
        $errors = $resultMap->get(Map::error);
        foreach ($errors as $erMsg) {
            $erMsg .= " in " . __METHOD__;
            $response->addError($erMsg, MyError::ADMIN_ERROR);
        }
        if ($quantity > 0) {
            $erMsg = "Not enough stock (missing stock:'$quantity') for product '$prodID' in " . __METHOD__;
            $response->addError($erMsg, MyError::ADMIN_ERROR);
        }
        $newSizesStock = $resultMap->get(Map::size);
        foreach ($newSizesStock as $realSize => $stock) {
            $holdsStock = $sizesStock[$realSize];
            $sql .= ($stock != $holdsStock)  ? "UPDATE `Products-Sizes` SET `stock`=$stock WHERE `prodId` = '$prodID' AND `size_name` = '$realSize';\n" : null;
        }

        // var_dump("sizesStock: ", $sizesStock);  // ❌
        // var_dump("resultMap: ", $resultMap);    // ❌
        // var_dump("sql: \n$sql");                // ❌

        self::update($response, $sql, []);          // ✅
    }

    /**
     * To place lock on product's selected stock for a duration
     * @param Response $response where to strore results
     * @param string $userID Client's id
     * @param string $userID Client's id
     */
    private static function insertLocks(Response $response, $userID, $prodID, array $stockToLocks)
    {
        $lockLimit = parent::getCookiesMap()->get(Cookie::COOKIE_LCK, Map::period);
        $setDate = parent::getDateTime();
        $nbLine = count($stockToLocks);
        $bracket = "(?,?,?,?,?,?)"; // regex \[value-[0-9]*\]
        $sql = "INSERT INTO `StockLocks`(`userId`, `prodId`, `size_name`, `quantity`, `lockTime`, `setDate`)
            VALUES " . parent::buildBracketInsert($nbLine, $bracket);
        $values = [];
        foreach ($stockToLocks as $size => $toLock) {
            array_push(
                $values,
                $userID,
                $prodID,
                $size,
                $toLock,
                $lockLimit,
                $setDate
            );
        }
        parent::insert($response, $sql, $values);
    }

    // /**
    //  * To increamente the quantity of product locked
    //  * @param Response $response where to strore results
    //  * @param string $userID Client's id
    //  */
    // private function updateLock(Response $response, $userID)
    // {
    //     $prodID = $this->getProdID();
    //     $realSelectedSize = $this->getRealSelectedSize();
    //     $size = $realSelectedSize->getsize();
    //     $sql =
    //         "UPDATE `StockLocks` SET
    //         `quantity`=`quantity`+?,
    //         `setDate`=?
    //         WHERE `userId`='$userID' AND `prodId`='$prodID' AND `size_name`='$size'";
    //     $values = [
    //         $realSelectedSize->getQuantity(),
    //         $this->getDateTime()
    //     ];
    //     $this->update($response, $sql, $values);
    // }
}
