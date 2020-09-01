<?php

class Measure
{
    /**
     * Holds the measure's id
     * @var string
     */
    private $measureID;

    /**
     * Holds the measure's measureName
     * @var string
     */
    private $measureName;

    /**
     * Holds the lengtgh of the Visitor's bust.
     * @var MeasureUnit
     */
    private $bust;

    /**
     * Holds the lengtgh of the Visitor's arm.
     * @var MeasureUnit
     */
    private $arm;

    /**
     * Holds the lengtgh of the Visitor's waist.
     * @var MeasureUnit
     */
    private $waist;

    /**
     * Holds the lengtgh of the Visitor's hip.
     * @var MeasureUnit
     */
    private $hip;

    /**
     * Holds the lengtgh of the Visitor's waist to floor.
     * @var MeasureUnit
     */
    private $inseam;

    /**
     * Holds the Measure's creation date
     * @var string
     */
    private $setDate;


    /**
     * Holds the query(qr) value for Ajax request
     * @var string
     */
    const QR_ADD_MEASURE = "add_measure";

    /**
     * Holds the query(qr) value for Ajax request
     * @var string
     */
    const QR_DELETE_MEASURE = "delete_measure";

    /**
     * Holds the query(qr) value for Ajax request
     * @var string
     */
    const QR_UPDATE_MEASURE = "edit_measure";

    /**
     * Holds the query(qr) value for Ajax request
     * @var string
     */
    const QR_GET_MEASURE_ADDER = "get_measure_adder";
   
    /**
     * Holds the query(qr) value for Ajax request
     * @var string
     */
    const QR_GET_EMPTY_MEASURE_ADDER = "get_empty_measure_adder";

    /**
     * Holds the query(qr) value for Ajax request
     * @var string
     */
    const QR_SELECT_MEASURE = "select_measure";

    /**
     * Holds the query(qr) value for Ajax request
     * @var string
     */
    const QR_MEASURE_CONTENT = "measure_content";

    /**
     * Input name for measure's name
     */
    const INPUT_MEASURE_NAME = "measure_name";

    /**
     * Input name for bust
     */
    const INPUT_BUST = "bust";

    /**
     * Input name for arm
     */
    const INPUT_ARM = "arm";

    /**
     * Input name for waist
     */
    const INPUT_WAIST = "waist";

    /**
     * Input name for hip
     */
    const INPUT_HIP = "hip";

    /**
     * Input name for inseam
     */
    const INPUT_INSEAM = "inseam";

    /**
     * Holds the access key for measure name in Query
     * @var string
     */
    const MEASURE_ID_KEY =  "measure_id";

    /**
     * Holds the access key for measure name
     * @var string
     */
    const MEASURRE_STICKER_KEY =  "measure_sticker";


    /**
     * Constructor
     */
    function __construct()
    {
        $argv = func_get_args();
        switch (func_num_args()) {
            case 0:
                self::__construct0();
                break;

            case 2:
                self::__construct2($argv[0], $argv[1]);
                break;
        }
    }

    private function __construct0()
    {
    }

    /**
     * @param string[] $measureDatas measure's value 
     * $measureDatas => [
     *      "measureID" => string,
     *      "bust" => float,
     *      "arm" => float,
     *      "waist" => float,
     *      "hip" => float,
     *      "inseam" => float,
     *      "unit_name" => string,
     *      "setDate" => string
     * ]
     * @param string[string[...]] $dbMap The database tables in mapped format specified in file 
     * oop/model/special/dbMap.txt
     *
     */
    private function __construct2($measureDatas, $dbMap)
    {
        $this->measureID = (!empty($measureDatas["measureID"])) ? $measureDatas["measureID"] : GeneralCode::generateDateCode(100);
        $this->measureName = $measureDatas["measure_name"];
        $unitName = $measureDatas["unit_name"];
        $this->bust = new MeasureUnit($measureDatas["bust"], $unitName, $dbMap);
        $this->arm = new MeasureUnit($measureDatas["arm"], $unitName, $dbMap);
        $this->waist = new MeasureUnit($measureDatas["waist"], $unitName, $dbMap);
        $this->hip = new MeasureUnit($measureDatas["hip"], $unitName, $dbMap);
        $this->inseam = new MeasureUnit($measureDatas["inseam"], $unitName, $dbMap);
        $this->setDate = !empty($measureDatas["setDate"]) ? $measureDatas["setDate"] : GeneralCode::getDateTime();
    }

    /**
     * Getter of measure's id
     * @return int measure's id
     */
    public function getMeasureID()
    {
        return $this->measureID;
    }

    /**
     * Getter of bust measure's name
     * @return string measure's name
     */
    public function getMeasureName()
    {
        return $this->measureName;
    }

    /**
     * Getter of measure's bust
     * @return MeasureUnit a protected copy of measure's bust
     */
    public function getbust()
    {
        return $this->bust->getCopy();
    }
    /**
     * Getter of measure's arm
     * @return MeasureUnit a protected copy of measure's arm
     */
    public function getarm()
    {
        return $this->arm->getCopy();
    }
    /**
     * Getter of measure's waist
     * @return MeasureUnit a protected copy of measure's waist
     */
    public function getwaist()
    {
        return $this->waist->getCopy();
    }
    /**
     * Getter of measure's hip
     * @return MeasureUnit a protected copy of measure's hip
     */
    public function gethip()
    {
        return $this->hip->getCopy();
    }
    /**
     * Getter of measure's inseam
     * @return MeasureUnit a protected copy of measure's inseam
     */
    public function getInseam()
    {
        return $this->inseam->getCopy();
    }

    /**
     * Convert setDate to seconde from UNIX.
     * @return int seconde from UNIX
     */
    public function getDateInSec()
    {
        return strtotime($this->setDate);
    }

    /**
     * Build a map that contain all value needed to create a Measure
     * @param string[] $usersMeasures
     * $usersMeasures = [
     *      "measureID" => string,
     *      "measure_name" => string,
     *      "userBust" => float,
     *      "userArm" => float,
     *      "userWaist" => float,
     *      "userHip" => float,
     *      "userInseam" => float,
     *      "unit_name" => string,
     *      "setDate" => string
     * ]
     * @return string[] a map that contain all value needed to create a Measure
     */
    public static function getDatas4Measure($usersMeasures)
    {
        $measureDatas["measureID"] = $usersMeasures["measureID"];
        $measureDatas["measure_name"] = $usersMeasures["measure_name"];
        $measureDatas["bust"] = $usersMeasures["userBust"];
        $measureDatas["arm"] = $usersMeasures["userArm"];
        $measureDatas["waist"] = $usersMeasures["userWaist"];
        $measureDatas["hip"] = $usersMeasures["userHip"];
        $measureDatas["inseam"] = $usersMeasures["userInseam"];
        $measureDatas["unit_name"] = $usersMeasures["unit_name"];
        $measureDatas["setDate"] = $usersMeasures["setDate"];
        return $measureDatas;
    }

    /**
     * Build a map that contain all value needed to create a Measure with datas posted($_POST)
     * @param Query $query contain a cleaned access to $_POST
     * @return string[] a map that contain all value needed to create a Measure
     */
    public static function getDatas4MeasurePOST($query)
    {
        $measureDatas[Measure::INPUT_MEASURE_NAME] = $query->POST(Measure::INPUT_MEASURE_NAME);
        $measureDatas[Measure::INPUT_BUST] = $query->POST(Measure::INPUT_BUST);
        $measureDatas[Measure::INPUT_ARM] = $query->POST(Measure::INPUT_ARM);
        $measureDatas[Measure::INPUT_WAIST] = $query->POST(Measure::INPUT_WAIST);
        $measureDatas[Measure::INPUT_HIP] = $query->POST(Measure::INPUT_HIP);
        $measureDatas[Measure::INPUT_INSEAM] = $query->POST(Measure::INPUT_INSEAM);
        $measureDatas[MeasureUnit::INPUT_MEASURE_UNIT] = $query->POST(MeasureUnit::INPUT_MEASURE_UNIT);
        return $measureDatas;
    }

    /**
     * To get a protected copy of this Measure
     * @return Measure a protected copy of this Measure
     */
    public function getCopy()
    {
        $copy = new Measure();
        $copy->measureID = $this->measureID;
        $copy->measureName = $this->measureName;
        $copy->bust = (!empty($this->bust)) ? $this->bust->getCopy() : null;
        $copy->arm = (!empty($this->arm)) ? $this->arm->getCopy() : null;
        $copy->waist = (!empty($this->waist)) ? $this->waist->getCopy() : null;
        $copy->hip = (!empty($this->hip)) ? $this->hip->getCopy() : null;
        $copy->inseam = (!empty($this->inseam)) ? $this->inseam->getCopy() : null;
        $copy->setDate = $this->setDate;
        return $copy;
    }

    /**
     * Save the measure by INSERT it in database
     * @param string $userID Visitor's id
     * @return Response if its success Response.isSuccess = true else Response
     *  contain the error thrown
     */
    public function save($userID)
    {
        $bracket = "(?,?,?,?,?,?,?,?,?,?)";
        $query = "INSERT INTO `UsersMeasures`(`userId`, `measureID`, `measureName`, `userBust`, `userArm`, `userWaist`, `userHip`, `userInseam`, `unit_name`, `setDate`) 
        VALUES " . Database::buildBracketInsert(1, $bracket);
        $values = [];
        array_push($values, $userID);
        array_push($values, $this->measureID);
        array_push($values, $this->measureName);
        array_push($values, $this->bust->getValue());
        array_push($values, $this->arm->getValue());
        array_push($values, $this->waist->getValue());
        array_push($values, $this->hip->getValue());
        array_push($values, $this->inseam->getValue());
        array_push($values, $this->inseam->getUnitName());
        array_push($values, $this->setDate);
        $response = Facade::insert($query, $values);
        return $response;
    }

    /**
     * Delete the measure from database
     * @param string $userID Visitor's id
     * @return Response if its success Response.isSuccess = true else Response
     *  contain the error thrown
     */
    public function delete($userID)
    {
        $query = "DELETE FROM `UsersMeasures` WHERE `userId` = '$userID' AND `measureID` = '$this->measureID'";
        $response = Facade::delete($query);
        return $response;
    }

    /**
     * Update the measure on database
     * @param Measure $measureUpdated contain the new values for this measure
     */
    public function update($userID, $measureUpdated)
    {
        $query = 
        "UPDATE `UsersMeasures` SET 
        `measureName` = ?,
        `userBust` = ?,
        `userArm` = ?,
        `userWaist` = ?,
        `userHip` = ?,
        `userInseam` = ?,
        `unit_name` = ?
        WHERE `userId`= '$userID' AND `measureID`= '$this->measureID'";

        $this->measureName = $measureUpdated->getMeasureName();
        $this->bust = $measureUpdated->getbust()->getCopy();
        $this->arm = $measureUpdated->getarm()->getCopy();
        $this->waist = $measureUpdated->getwaist()->getCopy();
        $this->hip = $measureUpdated->gethip()->getCopy();
        $this->inseam = $measureUpdated->getinseam()->getCopy();
        $values = [];
        array_push($values, $this->measureName);
        array_push($values, $this->bust->getValue());
        array_push($values, $this->arm->getValue());
        array_push($values, $this->waist->getValue());
        array_push($values, $this->hip->getValue());
        array_push($values, $this->inseam->getValue());
        array_push($values, $this->inseam->getUnitName());
        $response = Facade::update($query, $values);
        return $response;
    }
}
