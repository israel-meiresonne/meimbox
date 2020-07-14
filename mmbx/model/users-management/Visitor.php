<?php

require_once 'controller/ControllerItem.php';
require_once 'model/ModelFunctionality.php';
require_once 'model/tools-management/Language.php';
require_once 'model/tools-management/Country.php';
require_once 'model/navigation/Location.php';
require_once 'model/tools-management/Measure.php';

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
    private $setDate;

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
     * @param Response $response contain results or Myerrors
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
            $errStation = "US52";
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
     * @param Response $response contain results or Myerrors
     */
    public function addMeasure($response)
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
     * @param Response $response contain results or Myerrors
     * @param string $measureID measure's id
     */
    public function updateMeasure($response, $measureID)
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
     * @param Response $response contain results or Myerrors
     * @param string $measureID measure id to delete
     */
    public function deleteMeasure($response, $measureID)
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
     * Update on database and Visitor the Visitor's measure with the measure id posted($_POST)
     * @var string[string[...]] $dbMap The database tables in mapped format 
     * specified in file /oop/model/special/dbMap.txt
     * @return Response contain results or Myerrrors
     */
    // public function updateMeasure($dbMap)
    // {
    //     $response = new Response();
    //     $query = new Query();
    //     if (count($this->measures) > 0) {
    //         $response = self::checkMeasureInput($response, $query, $dbMap);

    //         if (!$response->containError()) {
    //             $measureID = $query->POST(Measure::MEASURE_ID_KEY);
    //             $measure = self::getMeasure($measureID);

    //             if (!empty($measure)) {
    //                 $measureDatas = Measure::getDatas4MeasurePOST($query);
    //                 $measurePosted = new Measure($measureDatas, $dbMap);
    //                 $updateResponse = $measure->update($this->userID, $measurePosted);

    //                 if ($updateResponse->isSuccess()) {
    //                     $response->addResult(Measure::QR_MEASURE_CONTENT, $this->measures);

    //                     $successStatus = $updateResponse->getResult(Database::UPDATE_STATUS_KEY);
    //                     $response->addResult(Database::UPDATE_STATUS_KEY, $successStatus);
    //                 } else {
    //                     $errorMsg = View::translateStation(MyError::ERROR_FILE, 1);
    //                     $response->addError($errorMsg, MyError::FATAL_ERROR);

    //                     $updateError = $updateResponse->getError(Database::UPDATE_STATUS_KEY);
    //                     $response->addError($updateError, Database::UPDATE_STATUS_KEY);
    //                 }
    //             } else {
    //                 $errorMsg = View::translateStation(MyError::ERROR_FILE, 1);
    //                 $response->addError($errorMsg, MyError::FATAL_ERROR);
    //             }
    //         }
    //     } else {
    //         $errorMsg = View::translateStation(MyError::ERROR_FILE, 1);
    //         $response->addError($errorMsg, MyError::FATAL_ERROR);
    //     }
    //     return $response;
    // }

    /**
     * Check measure datas posted($_POST)
     * @param Response $response where to strore resulte
     */
    private function checkMeasureInput($response)
    {
        $table = "UsersMeasures";
        $this->checkData(
            Measure::MEASURE_ID_KEY,
            [Query::ALPHA_NUMERIC],
            $response,
            $this->getDataLength($table, "measureID"),
            false
        );
        $this->checkData(
            MeasureUnit::INPUT_MEASURE_UNIT,
            [Query::CHECKBOX, Query::STRING_TYPE],
            $response,
            $this->getDataLength($table, "unit_name")
        );
        $this->checkData(
            Measure::INPUT_MEASURE_NAME,
            [Query::PSEUDO],
            $response,
            $this->getDataLength($table, "measureName")
        );
        $this->checkData(
            Measure::INPUT_BUST,
            [Query::NUMBER_FLOAT],
            $response,
            $this->getDataLength($table, "userBust")
        );
        $this->checkData(
            Measure::INPUT_ARM,
            [Query::NUMBER_FLOAT],
            $response,
            $this->getDataLength($table, "userArm")
        );
        $this->checkData(
            Measure::INPUT_WAIST,
            [Query::NUMBER_FLOAT],
            $response,
            $this->getDataLength($table, "userWaist")
        );
        $this->checkData(
            Measure::INPUT_HIP,
            [Query::NUMBER_FLOAT],
            $response,
            $this->getDataLength($table, "userHip")
        );
        $this->checkData(
            Measure::INPUT_INSEAM,
            [Query::NUMBER_FLOAT],
            $response,
            $this->getDataLength($table, "userInseam")
        );
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
