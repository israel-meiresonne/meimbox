<?php

require_once 'controller/ControllerItem.php';
require_once 'model/ModelFunctionality.php';
require_once 'model/tools-management/Language.php';
require_once 'model/tools-management/Country.php';
require_once 'model/navigation/Location.php';
require_once 'model/tools-management/Measure.php';
require_once 'model/boxes-management/Basket.php';

class Visitor extends ModelFunctionality
{
    /**
     * Holds the class's name
     */
    public const CLASS_NAME = "Visitor";

    /**
     * Holds Visitor's id
     * @var string
     */
    protected $userID;

    /**
     * Holds the Visitor's set date
     * @var string
     */
    protected $setDate;

    /**
     * The current language of the Visitor
     * @var Language 
     */
    protected $lang;

    /**
     * The current Currency of the Visitor
     * @var Currency
     */
    protected $currency;

    /**
     * The country of the Visitor. 
     * + If the real country of the Visitor is supported by the database it 
     * become his $country else the Visitor's country will be set with a 
     * default country value
     * @var Country
     */
    protected $country;

    /**
     * Hold location datas provided by the Visitor's IP address
     * @var Location
     */
    protected $location;

    /**
     * Hold data about the Visitor's device
     * @var Device
     */
    protected $device;

    /**
     * Hold Visitor's navigation data
     * @var Navigation
     */
    protected $navigation;

    /**
     * @var Basket
     */
    protected $basket;

    /**
     * Holds the visitor's measures
     * @var Measure[]
     */
    protected $measures;

    /**
     * Holds how much measures can be holded
     * @var int
     */
    protected static $MAX_MEASURE;

    /**
     * @parram string $callerClass class of the caller (usualy User.php)
     */
    public function __construct($callerClass = null)
    {
        $this->setConstants();
        $this->userID = ($callerClass == User::class) ? null : date("YmdHis"); // replacer par une sequance
        $this->setDate = ($callerClass == User::class) ? null : $this->getDateTime();
        $this->location = new Location();
        $this->currency = $this->location->getCurrency();
        $this->lang = ($callerClass == User::class) ? null : new Language();
        $this->country = new Country($this->location->getcountryName());
        $this->measures = [];
    }

    /**
     * Initialize Visitor's constants
     */
    private function setConstants()
    {
        if (!isset(self::$MAX_MEASURE)) {
            self::$MAX_MEASURE = "MAX_MEASURE";
            self::$MAX_MEASURE = (int) $this->getConstantLine(self::$MAX_MEASURE)["stringValue"];
        }
    }

    /**
     * Setter for Visitor's measures
     */
    protected function setMeasure()
    {
        $this->measures = [];
        $sql = "SELECT * FROM `UsersMeasures` WHERE `userId` = '$this->userID'";
        $tab = $this->select($sql);
        foreach ($tab as $tabLine) {
            $values = [];
            $values["measureID"] = $tabLine["measureID"];
            $values["measure_name"] = $tabLine["measureName"];
            $values["bust"] = !empty($tabLine["userBust"]) ? (float) $tabLine["userBust"] : null;
            $values["arm"] = !empty($tabLine["userArm"]) ? (float) $tabLine["userArm"] : null;
            $values["waist"] = !empty($tabLine["userWaist"]) ? (float) $tabLine["userWaist"] : null;
            $values["hip"] = !empty($tabLine["userHip"]) ? (float) $tabLine["userHip"] : null;
            $values["inseam"] = !empty($tabLine["userInseam"]) ? (float) $tabLine["userInseam"] : null;
            $values["unit_name"] = $tabLine["unit_name"];
            $values["setDate"] = $tabLine["setDate"];
            $measure = new Measure($values);
            $key = $measure->getDateInSec();
            $this->measures[$key] = $measure;
        }
        krsort($this->measures);
        $this->sortMeasure();
        // $this->measures = [];
    }

    /**
     * Setter for Visitor's basket
     */
    private function setBasket()
    {
        $this->basket = new Basket($this->userID, $this->getLanguage(), $this->getCountry(), $this->getCurrency());
    }

    /**
     * Getter for Visitor's id
     * @return string Visitor's id
     */
    public function getUserID()
    {
        return $this->userID;
    }

    /**
     * Getter of the Language
     * @return Language a protected copy of the Visitor's current language
     */
    public function getLanguage()
    {
        return $this->lang;
    }

    /**
     * Getter of the Currency
     * @return Currency a protected copy of the Visitor's current Currency
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Getter of the Country
     * @return Country a protected copy of the Visitor's current Country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Getter for Visitor's basket
     * @return Basket Visitor's basket
     */
    public function getBasket()
    {
        (!isset($this->basket)) ? $this->setBasket() : null;
        return $this->basket;
    }

    /**
     * To get the measure with the id given in param
     * @param string $measureID id of the measure to look for
     * @return Measure|null Measure if it's found else return null
     */
    public function getMeasure($measureID)
    {
        $found = false;
        $measures = $this->getMeasures();
        foreach ($this->measures as $key => $measure) {
            // $found = $this->measures[$key]->getMeasureID() == $measureID;
            $found = $measures[$key]->getMeasureID() == $measureID;
            if ($found) {
                return $this->measures[$key];
            }
        }
        return null;
    }

    /**
     * Getter of the Measures
     * @return Measure[] a protected copy of the Visitor's Measures
     */
    public function getMeasures()
    {
        (!isset($this->measures) ? $this->setMeasure() : null);
        return $this->measures;
        // return [];
    }

    /**
     * Getter of the maximum measure a Visitor can holds
     * @return int the maximum measure a Visitor can holds
     */
    public static function getMAX_MEASURE()
    {
        return self::$MAX_MEASURE;
    }

    /**
     * To get the access key of the measure with the id given in param
     * @param string $measureID id of the measure to look for
     * @return int|null access key of the measure if it's found else return null
     */
    private function getMeasureKey($measureID)
    {
        $found = false;
        foreach ($this->measures as $key => $measure) {
            $found = $this->measures[$key]->getMeasureID() == $measureID;
            if ($found) {
                return $key;
            }
        }
        return null;
    }

    /**
     * To check if there is a measure with the id given in param
     * @param string $measureID measure id to look for
     * @return boolean true if measure exist else false
     */
    public function existMeasure($measureID)
    {
        return !($this->getMeasure($measureID) === null);
    }

    /**
     * Sort measures in descending order, according to the key (BiGGER to LOWER)
     */
    private function sortMeasure()
    {
        krsort($this->measures);
    }

    /**
     * Delete from Visitor the measure with the id given in param
     * @param string $measureID id of the measure to delete
     * @param Response $response to push in result or accured error
     */
    private function destroyMeasure($response, $measureID)
    {
        $measure = $this->getMeasure($measureID);
        if (empty($measure)) {
            throw new Exception("Impossible to unset measure cause it don't exist:");
        }
        $sql = "SELECT * 
        FROM `UsersMeasures` um
        JOIN `Box-Products` bp ON um.measureID = bp.measureId
        WHERE um.userId = '$this->userID' AND bp.measureId = '$measureID'";
        $tab = $this->select($sql);

        if (count($tab) > 0) {
            $errStation = "ER8";
            $response->addErrorStation($errStation, MyError::FATAL_ERROR);
        } else {
            $measure->deleteMeasure($response, $this->userID);
            if ($response->isSuccess()) {
                $this->unsetMeasure($measureID);
            }
        }
    }

    /**
     * To remove a measure in Visitor's measure list following the measure's id
     * @param string $measureID measure's id
     */
    private function unsetMeasure($measureID)
    {
        $found = false;
        foreach ($this->measures as $key => $measure) {
            $found = $this->measures[$key]->getMeasureID() == $measureID;
            if ($found) {
                $this->measures[$key] = null;
                unset($this->measures[$key]);
            }
        }
        return null;
    }


    /*———————————————————————————— MANAGE CLASS UP ——————————————————————————*/
    /*———————————————————————————— GET DB TABLEDOWN —————————————————————————*/

    /**
     * Getter for db's BrandsMeasures table
     * @return string[] db's BrandsMeasures table
     */
    public function getBrandMeasures()
    {
        return $this->getBrandMeasuresTable();
    }

    /**
     * Getter for db's MeasureUnits table
     * @return string[] db's MeasureUnits table
     */
    public function getUnits()
    {
        return $this->getUnitsTable();
    }

    /*———————————————————————————— GET DB TABLE UP ——————————————————————————*/
    /*———————————————————————————— ALTER MODEL DOWN —————————————————————————*/

    /**
     * Add a new measure to Visitor
     * @param Response $response to push in result or accured error
     */
    public function addMeasure(Response $response)
    {
        if (count($this->measures) < self::$MAX_MEASURE) {
            $this->checkMeasureInput($response);
            if (!$response->containError()) {
                $measureDatas = Measure::getDatas4MeasurePOST();
                $measure = new Measure($measureDatas);
                // $saveResponse = $measure->save($this->userID);
                $measure->save($response, $this->userID);
                if ($response->isSuccess()) {
                    $key = $measure->getDateInSec();
                    $this->measures[$key] = $measure;
                    $this->sortMeasure();
                    $response->addResult(ControllerItem::QR_MEASURE_CONTENT, $this->measures);
                } else {
                    if (!$response->existErrorKey(MyError::FATAL_ERROR)) {
                        $errorMsg = "ER1";
                        $response->addErrorStation($errorMsg, MyError::FATAL_ERROR);
                    }
                }
            }
        } else {
            $errorMsg = "ER1";
            $response->addErrorStation($errorMsg, MyError::FATAL_ERROR);
        }
    }

    /**
     * Update a Visitor's measure
     * @param Response $response to push in result or accured error
     * @param string $measureID measure's id
     */
    public function updateMeasure(Response $response, $measureID)
    {
        $this->checkMeasureInput($response);
        if (!$response->containError()) {
            $measureDatas = Measure::getDatas4MeasurePOST();
            $newMeasure = new Measure($measureDatas);

            $oldMeasure = $this->getMeasure($measureID);
            $oldMeasure->updateMeasure($response, $this->userID, $newMeasure);
            if ($response->isSuccess()) {
                $key = $this->getMeasureKey($measureID);
                $this->unsetMeasure($measureID);
                $this->measures[$key] = $newMeasure;
                $this->sortMeasure();
            } else {
                if (!$response->existErrorKey(MyError::FATAL_ERROR)) {
                    $errorMsg = "ER1";
                    $response->addErrorStation($errorMsg, MyError::FATAL_ERROR);
                }
            }
        }
    }

    /**
     * Delete from database and Visitor the measure with the id given in param
     * @param Response $response to push in result or accured error
     * @param string $measureID measure id to delete
     */
    public function deleteMeasure(Response $response, $measureID)
    {
        if (count($this->measures) > 0) {
            $measure = $this->getMeasure($measureID);
            if (!empty($measure)) {
                $this->destroyMeasure($response, $measureID);
                if ((!$response->isSuccess()) && (!$response->existErrorKey(MyError::FATAL_ERROR))) {
                    $errorMsg = "ER1";
                    $response->addErrorStation($errorMsg, MyError::FATAL_ERROR);
                }
            }
        } else {
            $errStation = "ER1";
            $response->addErrorStation($errStation, MyError::FATAL_ERROR);
        }
    }

    /**
     * Check measure datas posted
     * @param Response $response where to strore results
     */
    private function checkMeasureInput(Response $response)
    {
        $table = "UsersMeasures";
        $this->checkInput(
            Measure::MEASURE_ID_KEY,
            [Query::ALPHA_NUMERIC],
            $response,
            $this->getDataLength($table, "measureID"),
            false
        );
        $this->checkInput(
            MeasureUnit::INPUT_MEASURE_UNIT,
            [Query::CHECKBOX, Query::STRING_TYPE],
            $response,
            $this->getDataLength($table, "unit_name")
        );
        $this->checkInput(
            Measure::INPUT_MEASURE_NAME,
            [Query::PSEUDO],
            $response,
            $this->getDataLength($table, "measureName")
        );
        $this->checkInput(
            Measure::INPUT_BUST,
            [Query::NUMBER_FLOAT],
            $response,
            $this->getDataLength($table, "userBust")
        );
        $this->checkInput(
            Measure::INPUT_ARM,
            [Query::NUMBER_FLOAT],
            $response,
            $this->getDataLength($table, "userArm")
        );
        $this->checkInput(
            Measure::INPUT_WAIST,
            [Query::NUMBER_FLOAT],
            $response,
            $this->getDataLength($table, "userWaist")
        );
        $this->checkInput(
            Measure::INPUT_HIP,
            [Query::NUMBER_FLOAT],
            $response,
            $this->getDataLength($table, "userHip")
        );
        $this->checkInput(
            Measure::INPUT_INSEAM,
            [Query::NUMBER_FLOAT],
            $response,
            $this->getDataLength($table, "userInseam")
        );
    }

    /**
     * Check if it's still stock for the product submited by Visitor
     * + it's still stock mean that there size that fit the Visitor's submited size
     * @param Response $response where to strore results
     * @param string $prodID Product's id
     * @return boolean true if it's are still stock else false
     */
    public function stillStock(Response $response, $prodID)
    {
        $stillStock = false;
        // $sizeObj = null;
        $isCorrect = $this->checkData($prodID, ModelFunctionality::ALPHA_NUMERIC, $this->getDataLength(Product::TABLE_PRODUCTS, Product::INPUT_PROD_ID));
        if ($isCorrect && $this->existProductInDb($prodID)) {
            $tabLine = $this->getProductLine($prodID);
            switch ($tabLine["product_type"]) {
                case BasketProduct::BASKET_TYPE:
                    $stillStock = $this->stillBasketProductStock($response, $prodID);
                    break;
                case BoxProduct::BOX_TYPE:
                    $stillStock = $this->stillBoxProductStock($response, $prodID);
                    break;
                default:
                    throw new Exception("Unknow product type");
            }
        } else {
            $errorMsg = "ER1";
            $response->addErrorStation($errorMsg, MyError::FATAL_ERROR);
        }
        return $stillStock;
    }

    //     /**
    //  * To check if still stock for basket poduct
    //  * @param Response $response where to strore results
    //  * @param string $prodID Product's id
    //  * @return boolean true if it's are still stock else false
    //  */
    // private function stillBasketProductStock(Response $response, $prodID)
    // {
    //     $stillStock = false;
    //     $this->checkSizeInput($response, BasketProduct::BASKET_TYPE);
    //     if (!$response->containError()) {
    //         $size = Query::getParam(Size::SIZE_TYPE_CHAR);
    //         $product = new BasketProduct($prodID, $this->lang, $this->country, $this->currency);
    //         $sequence = Size::buildSequence($size, null, null);
    //         $sizeObj = new Size($sequence);
    //         // $stillStock = $product->stillStock($size);
    //         $stillStock = $product->stillStock($sizeObj);
    //     }
    //     return $stillStock;
    // }

    /**
     * To check if still stock for basket poduct
     * @param Response $response where to strore results
     * @param string $prodID Product's id
     * @return boolean true if it's are still stock else false
     */
    private function stillBasketProductStock(Response $response, $prodID)
    {
        $stillStock = false;
        $sizeObj = $this->extractSizeBasketProduct($response, $prodID);
        if (!$response->containError()) {
            $product = new BasketProduct($prodID, $this->lang, $this->country, $this->currency);
            $stillStock = $product->stillStock($sizeObj);
        }
        return $stillStock;
    }

    /**
     * Exctract the Size of the basket product from the input submited
     * @param Response $response where to strore results
     * @return Size|null Exctracted Size of the basket product
     */
    private function extractSizeBasketProduct(Response $response)
    {
        $sizeObj = null;
        $this->checkSizeInput($response, BasketProduct::BASKET_TYPE);
        if (!$response->containError()) {
            $size = Query::getParam(Size::SIZE_TYPE_CHAR);
            $sequence = Size::buildSequence($size, null, null, null);
            $sizeObj = new Size($sequence);
        }
        return $sizeObj;
    }

    // /**
    //  * To check if still stock for basket poduct
    //  * @param Response $response where to strore results
    //  * @param string $prodID Product's id
    //  * @return boolean true if it's are still stock else false
    //  */
    // private function stillBoxProductStock(Response $response, $prodID)
    // {
    //     $this->checkSizeInput($response, BoxProduct::BOX_TYPE);
    //     if (!$response->containError()) {
    //         $sizeType = Query::getParam(Size::INPUT_SIZE_TYPE);
    //         switch ($sizeType) {
    //             case Size::SIZE_TYPE_CHAR:
    //                 $size = Query::getParam(Size::SIZE_TYPE_CHAR);
    //                 // $product = new BoxProduct($prodID, $this->lang, $this->country, $this->currency);
    //                 $product = new BoxProduct($prodID, $this->getLanguage(), $this->getCountry(), $this->getCurrency());
    //                 $brand = null;
    //                 if (Query::existParam(Size::INPUT_BRAND)) {
    //                     $brand = Query::getParam(Size::INPUT_BRAND);
    //                 }
    //                 $sequence = Size::buildSequence($size, $brand, null);
    //                 $sizeObj = new Size($sequence, null, null);
    //                 // return $product->stillStock($size, $brand);
    //                 return $product->stillStock($sizeObj);
    //                 break;
    //             case Size::SIZE_TYPE_MEASURE:
    //                 $measureID = Query::getParam(Measure::MEASURE_ID_KEY);
    //                 $cut = Query::getParam(Size::INPUT_CUT);
    //                 // $measure = $this->getMeasure($measureID);
    //                 $product = new BoxProduct($prodID, $this->getLanguage(), $this->getCountry(), $this->getCurrency());
    //                 $sequence = Size::buildSequence(null, null, $measureID);
    //                 $sizeObj = new Size($sequence, null, $cut);
    //                 return $product->stillStock($sizeObj);
    //                 // return true;
    //                 break;
    //             default:
    //                 throw new Exception("Any size type match system's size types");
    //                 break;
    //         }
    //     }
    // }

    /**
     * To check if still stock for basket poduct
     * @param Response $response where to strore results
     * @param string $prodID Product's id
     * @return boolean true if it's are still stock else false
     */
    private function stillBoxProductStock(Response $response, $prodID)
    {
        $stillStock = false;
        $sizeObj = $this->extractSizeBoxProduct($response, $prodID);
        if (!$response->containError()) {
            $product = new BoxProduct($prodID, $this->getLanguage(), $this->getCountry(), $this->getCurrency());
            $stillStock = $product->stillStock($sizeObj);
        }
        return $stillStock;
    }

    /**
     * Exctract the Size of the box product from the input submited
     * @param Response $response where to strore results
     * @return Size|null Exctracted Size of the box product
     */
    private function extractSizeBoxProduct(Response $response)
    {
        $sizeObj = null;
        $this->checkSizeInput($response, BoxProduct::BOX_TYPE);
        if (!$response->containError()) {
            $sizeType = Query::getParam(Size::INPUT_SIZE_TYPE);
            switch ($sizeType) {
                case Size::SIZE_TYPE_CHAR:
                    $size = Query::getParam(Size::SIZE_TYPE_CHAR);
                    $brand = null;
                    if (Query::existParam(Size::INPUT_BRAND)) {
                        $brand = Query::getParam(Size::INPUT_BRAND);
                    }
                    $sequence = Size::buildSequence($size, $brand, null, null);
                    $sizeObj = new Size($sequence);
                    break;
                case Size::SIZE_TYPE_MEASURE:
                    $measureID = Query::getParam(Measure::MEASURE_ID_KEY);
                    $cut = Query::getParam(Size::INPUT_CUT);
                    $sequence = Size::buildSequence(null, null, $measureID, $cut);
                    $sizeObj = new Size($sequence);
                    break;
                default:
                    throw new Exception("Any size type match system's size types");
                    break;
            }
        }
        return $sizeObj;
    }


    /**
     * Check size datas posted
     * @param Response $response where to strore results
     * @param string $prodType product's type
     * @return boolean true if the data is correct else false
     */
    private function checkSizeInput(Response $response, string $prodType)
    {
        switch ($prodType) {
            case BasketProduct::BASKET_TYPE:
                $this->checkSizeChar($response);
                if (!$response->containError()) {
                    return true;
                }
                break;
            case BoxProduct::BOX_TYPE:
                $this->checkSizeType($response);
                if (!$response->containError()) {
                    $sizeType = Query::getParam(Size::INPUT_SIZE_TYPE);
                    switch ($sizeType) {
                        case Size::SIZE_TYPE_CHAR:
                            $this->checkSizeChar($response);
                            if (!$response->containError()) {
                                $this->checkBrand($response);
                                if (!$response->containError()) {
                                    return true;
                                }
                            }
                            break;
                        case Size::SIZE_TYPE_MEASURE:
                            if (Query::existParam(Measure::MEASURE_ID_KEY)) {
                                $measureID = Query::getParam(Measure::MEASURE_ID_KEY);
                                if (!$this->existMeasure($measureID)) {
                                    $errorMsg = "ER1";
                                    $response->addErrorStation($errorMsg, MyError::FATAL_ERROR);
                                } else {
                                    $this->checkCut($response);
                                    return true;
                                }
                            } else {
                                $station = "ER12";
                                $response->addErrorStation($station, Measure::MEASURE_ID_KEY);
                            }
                            break;
                        default:
                            throw new Exception("Any size type match system's size types");
                            break;
                    }
                }
                break;
            default:
                throw new Exception("Any product type match system's product types");
                break;
        }
        return false;
    }

    /**
     * Check if the size type is correct
     * @param Response $response where to strore results
     * @return boolean true if the size type is correct else false
     */
    private function checkSizeType(Response $response)
    {
        if (Query::existParam(Size::INPUT_SIZE_TYPE)) {
            if ((Query::getParam(Size::INPUT_SIZE_TYPE) == Size::SIZE_TYPE_CHAR)
                || (Query::getParam(Size::INPUT_SIZE_TYPE) == Size::SIZE_TYPE_MEASURE)
            ) {
                return true;
            } else {
                $station = "ER1";
                $response->addErrorStation($station, MyError::FATAL_ERROR);
            }
        } else {
            $station = "ER9";
            $response->addErrorStation($station, Size::INPUT_SIZE_TYPE);
        }
        return false;
    }

    /**
     * Check if the char size is correct
     * @param Response $response where to strore results
     * @return boolean true if the char size is correct else false
     */
    private function checkSizeChar(Response $response)
    {
        if (Query::existParam(Size::INPUT_CHAR_SIZE)) {
            $size = Query::getParam(Size::INPUT_CHAR_SIZE);
            $sizeList = $this->getTableValues("supoortedSizes");
            if (in_array($size, $sizeList)) {
                return true;
            } else {
                $station = "ER1";
                $response->addErrorStation($station, MyError::FATAL_ERROR);
            }
        } else {
            $station = "ER11";
            $response->addErrorStation($station, Size::INPUT_CHAR_SIZE);
        }
        return false;
    }

    /**
     * Check if the brand is correct
     * @param Response $response where to strore results
     * @return boolean true if the brand is correct else false
     */
    private function checkBrand(Response $response)
    {
        if (Query::existParam(Size::INPUT_BRAND)) {
            $brand = Query::getParam(Size::INPUT_BRAND);
            $brandMap = $this->getBrandMeasuresTable();
            if (key_exists($brand, $brandMap)) {
                return true;
            } else {
                $errorMsg = "ER1";
                $response->addErrorStation($errorMsg, MyError::FATAL_ERROR);
            }
        } else {
            return true;
        }
        return false;
    }

    /**
     * Check if cut is correct
     * @param Response $response where to strore results
     * @return boolean true if cut is correct else false
     */
    private function checkCut(Response $response)
    {
        $cut = Query::getParam(Size::INPUT_CUT);
        $cutMap = $this->getTableValues("cuts");
        $isCorret = (!empty($cut)) ? key_exists($cut, $cutMap) : false;
        if (!$isCorret) {
            $errorMsg = "ER1";
            $response->addErrorStation($errorMsg, MyError::FATAL_ERROR);
        }
        return $isCorret;
    }

    /**
     * To add new box in Visitor's basket
     * @param Response $response where to strore results
     * @param int $colorCode the encrypted value of box color
     */
    public function addBox(Response $response, $colorCode)
    {
        $country = $this->getCountry();
        $currency = $this->getCurrency();
        $boxMap = $this->getBoxMap($country, $currency);
        $boxColor = $this->decryptString($colorCode);
        if (key_exists($boxColor, $boxMap)) {
            $userID = $this->getUserID();
            $basket = $this->getBasket();
            $basket->addBox($response, $userID, $boxColor);
        } else {
            $errorMsg = "ER1";
            $response->addErrorStation($errorMsg, MyError::FATAL_ERROR);
        }
    }

    /**
     * To delete box from Visitor's basket
     * @param Response $response where to strore results
     * @param string $boxID id of box in Visitor's basket
     */
    public function deleteBox(Response $response, $boxID)
    {
        $basket = $this->getBasket();
        $box = $basket->getBoxe($boxID);
        if (empty($box)) {
            $response->addErrorStation("ER1", MyError::FATAL_ERROR);
        } else {
            $basket->deleteBox($response, $boxID);
        }
    }

    /**
     * To add new product in box of Visitor's basket
     * @param Response $response where to strore results
     * @param string $boxID id of box in Visitor's basket
     * @param string $prodID id of the product to add in box
     */
    public function addBoxProduct(Response $response, $boxID, $prodID)
    {
        $basket = $this->getBasket();
        $box = $basket->getBoxe($boxID);
        $existProd = $this->existProductInDb($prodID);
        $isBoxProd = $this->getProductLine($prodID)["product_type"] == BoxProduct::BOX_TYPE;
        if ((empty($box)) || (!$existProd) || (!$isBoxProd)) {
            $response->addErrorStation("ER1", MyError::FATAL_ERROR);
        } else {
            if (!$basket->stillSpace($boxID)) {
                // $box = $basket->getBoxe($boxID);
                $fullRate = "(" . $box->getNbProduct() . "/" . $box->getSizeMax() . ")";
                $errStation = "ER14" . $fullRate;
                $response->addErrorStation($errStation, ControllerItem::A_ADD_BXPROD);
            } else {
                $stillStock = $this->stillStock($response, $prodID);
                if ((!$response->containError()) && $stillStock) {
                    $sizeObj = $this->extractSizeBoxProduct($response);
                    if (!$response->containError()) {
                        $basket->addBoxProduct($response, $boxID, $prodID, $sizeObj);
                    }
                }
            }
        }
    }

    /**
     * To move a boxproduct to a other box
     * @param Response $response where to strore results
     * @param string $boxID id of box where is the product
     * @param string $newBoxID id of box where move the product
     * @param string $prodID id of the product to move
     * @param string $sequence product's size sequence
     */
    public function moveBoxProduct(Response $response, $boxID, $newBoxID, $prodID, $sequence)
    {
        $basket = $this->getBasket();
        $box = $basket->getBoxe($boxID);
        $newBox = $basket->getBoxe($newBoxID);
        $sizeObj = new Size($sequence);
        $product = $box->getProduct($prodID, $sizeObj);
        $isBoxProd = ((!empty($product)) && ($product->getType() == BoxProduct::BOX_TYPE));
        if ((empty($box)) || (empty($newBox)) || (!$isBoxProd)) {
            $response->addErrorStation("ER1", MyError::FATAL_ERROR);
        } else {
            
        }
    }

    /*———————————————————————————— ALTER MODEL UP ———————————————————————————*/
}
