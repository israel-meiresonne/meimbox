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

    public function __construct()
    {
        $this->setConstants();
        $this->userID = date("YmdHis"); // replacer par une sequance
        $this->setDate = $this->getDateTime();
        $this->location = new Location();
        $this->currency = $this->location->getCurrency();
        $this->lang = new Language();
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
    }

    /**
     * Setter for Visitor's basket
     */
    private function setBasket()
    {
        $this->basket = new Basket($this->userID, $this->getCountry(), $this->getCurrency());
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
        return $this->lang->getCopy();
    }

    /**
     * Getter of the Currency
     * @return Currency a protected copy of the Visitor's current Currency
     */
    public function getCurrency()
    {
        return $this->currency->getCopy();
    }

    /**
     * Getter of the Country
     * @return Country a protected copy of the Visitor's current Country
     */
    public function getCountry()
    {
        return $this->country->getCopy();
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
        foreach ($this->measures as $key => $measure) {
            $found = $this->measures[$key]->getMeasureID() == $measureID;
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
     * @param Response $response where to strore resulte
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
     * @param Response $response where to strore resulte
     * @param string $prodID Product's id
     * @return boolean true if it's are still stock else false
     */
    public function stillStock(Response $response, $prodID)
    {
        $isCorrect = $this->checkData($prodID, ModelFunctionality::ALPHA_NUMERIC, $this->getDataLength(Product::TABLE_PRODUCTS, Product::INPUT_PROD_ID));
        if ($isCorrect && $this->existProductInDb($prodID)) {
            $tabLine = $this->getProductLine($prodID);
            switch ($tabLine["product_type"]) {
                case BasketProduct::BASKET_TYPE:
                    $this->checkSizeInput($response, BasketProduct::BASKET_TYPE);
                    if (!$response->containError()) {
                        $size = Query::getParam(Size::SIZE_TYPE_CHAR);
                        $product = new BasketProduct($prodID, $this->country, $this->currency);
                        return $product->stillStock($size);
                    }
                    break;
                case BoxProduct::BOX_TYPE:
                    $this->checkSizeInput($response, BoxProduct::BOX_TYPE);
                    if (!$response->containError()) {
                        $sizeType = Query::getParam(Size::INPUT_SIZE_TYPE);
                        switch ($sizeType) {
                            case Size::SIZE_TYPE_CHAR:
                                $size = Query::getParam(Size::SIZE_TYPE_CHAR);
                                $product = new BoxProduct($prodID);
                                $brand = null;
                                if(Query::existParam(Size::INPUT_BRAND)) {
                                    $brand = Query::getParam(Size::INPUT_BRAND);
                                }
                                return $product->stillStock($size, $brand);
                                break;
                            case Size::SIZE_TYPE_MEASURE:
                                // $measureID = Query::getParam(Measure::MEASURE_ID_KEY);
                                // $measure = $this->getMeasure($measureID);
                                // $product = new BoxProduct($prodID);
                                // $product->stillStock($measure);
                            default:
                                throw new Exception("Any size type match system's size types");
                                break;
                        }
                    }
                    break;
                default:
                    throw new Exception("Unknow product type");
            }
        } else {
            $errorMsg = "ER1";
            $response->addErrorStation($errorMsg, MyError::FATAL_ERROR);
        }
    }

    /**
     * Check size datas posted
     * @param Response $response where to strore resulte
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
                                if ($this->existMeasure($measureID)) {
                                    return true;
                                } else {
                                    $errorMsg = "ER1";
                                    $response->addErrorStation($errorMsg, MyError::FATAL_ERROR);
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
     * @param Response $response where to strore resulte
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
     * @param Response $response where to strore resulte
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
     * @param Response $response where to strore resulte
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

    /*———————————————————————————— ALTER MODEL UP ———————————————————————————*/
    //———————————————————————————— BUILD MODEL DATAS DOWN ———————————————————*/

    /**
     * To get the measure with its id posted($_POST)
     * @var string[string[...]] $dbMap The database tables in mapped format 
     * specified in file /oop/model/special/dbMap.txt
     * @return Response contain the Measure matching the id or Myerrrors
     */
    public function getMeasurePOST($dbMap)
    {
        $response = new Response();
        $query = new Query();

        $response = $query->checkInput(Measure::MEASURE_ID_KEY, [Query::ALPHA_NUMERIC], $response, $dbMap["DESCRIPTION"]["UsersMeasures"]["measureID"]);

        if (!$response->containError()) {
            $measureID = $query->POST(Measure::MEASURE_ID_KEY);
            $measure = self::getMeasure($measureID);

            if (!empty($measure)) {
                $response->addResult(Query::POST_MOTHOD, $measure);
            } else {
                $errorMsg = View::translateStation(MyError::ERROR_FILE, 1);
                $response->addError($errorMsg, MyError::FATAL_ERROR);
            }
        } else {
            $errorMsg = View::translateStation(MyError::ERROR_FILE, 1);
            $response->addError($errorMsg, MyError::FATAL_ERROR);
        }
        return $response;
    }
    //———————————————————————————— BUILD MODEL DATAS UP —————————————————————*/
}
