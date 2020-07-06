<?php

require_once 'model/ModelFunctionality.php';
require_once 'model/tools-management/Language.php';
require_once 'model/tools-management/Country.php';
require_once 'model/navigation/Location.php';

class Visitor extends ModelFunctionality
{
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


    // /**
    //  * Constructor
    //  * @param string[string[...]] $dbMap The database tables in mapped format specified in file 
    //  * oop/model/special/dbMap.txt
    //  */
    // function __construct($dbMap)
    // {
    //     self::setConstants($dbMap);

    //     $this->userID = $dbMap["usersMap"]["userDatas"]["userID"];
    //     $this->setDate = GeneralCode::getDateTime();

    //     $this->location = new Location($dbMap);
    //     $this->lang = new Language($dbMap);
    //     $this->currency = $this->location->getCurrency();
    //     $this->device = new Device();
    //     $this->navigation = new Navigation($this->userID, $dbMap);
    //     $this->basket = new Basket($dbMap);
    //     $countryName = $this->location->getcountryName();

    //     $this->country = new Country($countryName, $dbMap);
    //     self::initMeasure($dbMap);
    //     // $this->measures = [];
    // }

    public function __construct()
    {
        $this->setConstants();
        $this->userID = date("YmdHis"); // replacer par une sequance
        $this->setDate = $this->getDateTime();
        $this->location = new Location();
        $this->currency = $this->location->getCurrency();
        $this->lang = new Language();
        $this->country = new Country($this->location->getcountryName());
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
     * Initialize Visitor's measures
     * @param string[string[...]] $dbMap The database tables in mapped format specified in file 
     * oop/model/special/dbMap.txt
     */
    private function initMeasure($dbMap)
    {
        foreach ($dbMap["usersMap"]["usersMeasures"] as $datas) {
            $values["measureID"] = $datas["measureID"];
            $values["measure_name"] = $datas["measure_name"];
            $values["bust"] = $datas["userBust"];
            $values["arm"] = $datas["userArm"];
            $values["waist"] = $datas["userWaist"];
            $values["hip"] = $datas["userHip"];
            $values["inseam"] = $datas["userInseam"];
            $values["unit_name"] = $datas["unit_name"];
            $values["setDate"] = $datas["setDate"];
            $measure = new Measure($values, $dbMap);
            $key = $measure->getDateInSec();
            $this->measures[$key] = $measure;
        }
        // krsort($this->measures);
        self::sortMeasure();
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
     * To get the measure with the id given in param
     * @param string $measureID id of the measure to look for
     * @return Measure|null Measure if it's found else return null
     */
    private function getMeasure($measureID)
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
     * Sort measures in descending order, according to the key (BiGGER to LOWER)
     */
    private function sortMeasure()
    {
        krsort($this->measures);
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
     * Delete from Visitor the measure with the id given in param
     * @param string $measureID id of the measure to delete
     * @return boolean true if its found and deleted else false
     */
    private function deleteVisitorMeasure($measureID)
    {
        $key = self::getMeasureKey($measureID);
        if (!empty($key)) {
            unset($this->measures[$key]);
            return true;
        }
        return false;
    }

    /**
     * Check measure datas posted($_POST)
     * @param Response $response where to strore resulte
     * @param Query $query contain a cleaned access to $_POST
     * @var string[string[...]] $dbMap The database tables in mapped format 
     * specified in file /oop/model/special/dbMap.txt
     * @return Response contain results or Myerrrors
     */
    // private function checkMeasureInput($response, $query, $dbMap)
    // {
    //     $response = $query->checkInput(
    //         Measure::MEASURE_ID_KEY,
    //         [Query::ALPHA_NUMERIC],
    //         $response,
    //         $dbMap["DESCRIPTION"]["UsersMeasures"]["measureID"],
    //         true
    //     );
    //     $response = $query->checkInput(
    //         MeasureUnit::INPUT_MEASURE_UNIT,
    //         [Query::CHECKBOX, Query::STRING_TYPE],
    //         $response,
    //         $dbMap["DESCRIPTION"]["UsersMeasures"]["unit_name"]
    //     );
    //     $response = $query->checkInput(
    //         Measure::INPUT_MEASURE_NAME,
    //         [Query::PSEUDO],
    //         $response,
    //         $dbMap["DESCRIPTION"]["UsersMeasures"]["measureName"]
    //     );
    //     $response = $query->checkInput(
    //         Measure::INPUT_BUST,
    //         [Query::NUMBER_FLOAT],
    //         $response,
    //         $dbMap["DESCRIPTION"]["UsersMeasures"]["userBust"]
    //     );
    //     $response = $query->checkInput(
    //         Measure::INPUT_ARM,
    //         [Query::NUMBER_FLOAT],
    //         $response,
    //         $dbMap["DESCRIPTION"]["UsersMeasures"]["userArm"]
    //     );
    //     $response = $query->checkInput(
    //         Measure::INPUT_WAIST,
    //         [Query::NUMBER_FLOAT],
    //         $response,
    //         $dbMap["DESCRIPTION"]["UsersMeasures"]["userWaist"]
    //     );
    //     $response = $query->checkInput(
    //         Measure::INPUT_HIP,
    //         [Query::NUMBER_FLOAT],
    //         $response,
    //         $dbMap["DESCRIPTION"]["UsersMeasures"]["userHip"]
    //     );
    //     $response = $query->checkInput(
    //         Measure::INPUT_INSEAM,
    //         [Query::NUMBER_FLOAT],
    //         $response,
    //         $dbMap["DESCRIPTION"]["UsersMeasures"]["userInseam"]
    //     );
    //     return $response;
    // }

    //————————————————————————————————————————————— MANAGE CLASS UP ————————————————————————————————————————————————
    //————————————————————————————————————————————— ALTER MODEL DOWN ———————————————————————————————————————————————

    /**
     * Add a new measure to Visitor if input are correct
     * @var string[string[...]] $dbMap The database tables in mapped format 
     * specified in file /oop/model/special/dbMap.txt
     * @return Response contain results or Myerrrors
     */
    // public function addMeasure($dbMap)
    // {
    //     $response = new Response();
    //     $query = new Query();
    //     if (count($this->measures) < self::$MAX_MEASURE) {
    //         $response = self::checkMeasureInput($response, $query, $dbMap);

    //         if (!$response->containError()) {
    //             $measureDatas = Measure::getDatas4MeasurePOST($query);
    //             $measure = new Measure($measureDatas, $dbMap);
    //             $saveResponse = $measure->save($this->userID);
    //             if ($saveResponse->isSuccess()) {
    //                 $key = $measure->getDateInSec();
    //                 $this->measures[$key] = $measure;
    //                 self::sortMeasure();
    //                 $response->addResult(Measure::QR_MEASURE_CONTENT, $this->measures);
    //             } else {
    //                 $errorMsg = View::translateStation(MyError::ERROR_FILE, 1);
    //                 $response->addError($errorMsg, MyError::FATAL_ERROR);
    //                 $insertError = $saveResponse->getError(Database::INSERT_STATUS_KEY);
    //                 $response->addError($insertError, Database::INSERT_STATUS_KEY);
    //             }
    //         }
    //     } else {
    //         $errorMsg = View::translateStation(MyError::ERROR_FILE, 1);
    //         $response->addError($errorMsg, MyError::FATAL_ERROR);
    //     }

    //     return $response;
    // }



    /**
     * Delete from database and Visitor the Visitor's measure with the measure id posted($_POST)
     * @var string[string[...]] $dbMap The database tables in mapped format 
     * specified in file /oop/model/special/dbMap.txt
     * @return Response contain results or Myerrrors
     */
    // public function deleteMeasure($dbMap)
    // {
    //     $response = new Response();
    //     $query = new Query();
    //     if (count($this->measures) > 0) {
    //         $response = $query->checkInput(Measure::MEASURE_ID_KEY, [Query::ALPHA_NUMERIC], $response, $dbMap["DESCRIPTION"]["UsersMeasures"]["measureID"]);

    //         if (!$response->containError()) {
    //             $measureID = $query->POST(Measure::MEASURE_ID_KEY);
    //             $measure = self::getMeasure($measureID);

    //             if (!empty($measure)) {
    //                 $deleteResponse = $measure->delete($this->userID);
    //                 if ($deleteResponse->isSuccess()) {
    //                     self::deleteVisitorMeasure($measureID);
    //                     $successStatus = $deleteResponse->getResult(Database::DELETE_STATUS_KEY);
    //                     $results = [
    //                         Measure::MEASURE_ID_KEY => $measureID,
    //                         View::TITLE_KEY => $this->measures,
    //                         View::BUTTON_KEY => null,
    //                     ];
    //                     $response->addResult(Measure::QR_DELETE_MEASURE, $results);
    //                     $response->addResult(Database::DELETE_STATUS_KEY, $successStatus);
    //                 } else {
    //                     $errorMsg = View::translateStation(MyError::ERROR_FILE, 1);
    //                     $response->addError($errorMsg, MyError::FATAL_ERROR);
    //                     $updateError = $deleteResponse->getError(Database::DELETE_STATUS_KEY);
    //                     $response->addError($updateError, Database::DELETE_STATUS_KEY);
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

    //————————————————————————————————————————————— ALTER MODEL UP —————————————————————————————————————————————————
    //————————————————————————————————————————————— GET MODEL DATAS DOWN ———————————————————————————————————————————
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
     * Getter of the Measures
     * @return Measure[] a protected copy of the Visitor's Measures
     */
    public function getMeasures()
    {
        return GeneralCode::cloneMap($this->measures);
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
     * Getter of the maximum measure a Visitor can holds
     * @return int the maximum measure a Visitor can holds
     */
    public static function getMAX_MEASURE()
    {
        return self::$MAX_MEASURE;
    }

    //————————————————————————————————————————————— GET MODEL DATAS UP —————————————————————————————————————————————
    //————————————————————————————————————————————— BUILD MODEL DATAS DOWN —————————————————————————————————————————

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
    //————————————————————————————————————————————— BUILD MODEL DATAS UP ———————————————————————————————————————————


    public function __toString()
    {
        Helper::printLabelValue("userID", $this->userID);
        Helper::printLabelValue("setDate", $this->setDate);
        $this->location->__toString();
        $this->lang->__toString();
        $this->currency->__toString();
        $this->country->__toString();
        $this->device->__toString();
        $this->navigation->__toString();
        $this->basket->__toString();
    }
}
