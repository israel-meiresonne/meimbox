<?php

require_once 'model/ModelFunctionality.php';
require_once 'model/tools-management/MeasureUnit.php';

class Measure extends ModelFunctionality
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
     * Input name for measure's name
     */
    private const ID_LENGTH = 25;

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
    // const MEASURE_ID_KEY =  "measure_id";
    const MEASURE_ID_KEY =  "measureID";

    /**
     * Holds the access key for measure name
     * @var string
     */
    const MEASURRE_STICKER_KEY =  "measure_sticker";

    /**
     * Constructor
     * 
     * @param string[] $datas measure's value
     * + NOTE: measure's unit (unit_name) must be the same for all body part
     * + $datas => [
     *      "measureID" => string,
     *      "bust" => float,
     *      "arm" => float,
     *      "waist" => float,
     *      "hip" => float,
     *      "inseam" => float,
     *      "unit_name" => string,
     *      "setDate" => string
     * ]
     *
     */
    public function __construct($datas)
    {
        $this->measureID = (!empty($datas["measureID"])) ? $datas["measureID"] : $this->generateDateCode(self::ID_LENGTH);
        $this->measureName = (!empty($datas["measure_name"])) ? $datas["measure_name"] : $this->generateDateCode(self::ID_LENGTH);;
        $unitName = $datas["unit_name"];
        $this->bust = (!empty($datas["bust"])) ? new MeasureUnit($datas["bust"], $unitName) : null;
        $this->arm = (!empty($datas["arm"])) ? new MeasureUnit($datas["arm"], $unitName) : null;
        $this->waist = (!empty($datas["waist"])) ? new MeasureUnit($datas["waist"], $unitName) : null;
        $this->hip = (!empty($datas["hip"])) ? new MeasureUnit($datas["hip"], $unitName) : null;
        $this->inseam = (!empty($datas["inseam"])) ? new MeasureUnit($datas["inseam"], $unitName) : null;
        $this->setDate = !empty($datas["setDate"]) ? $datas["setDate"] : $this->getDateTime();
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
        return (isset($this->bust)) ? $this->bust->getCopy() : null;
    }

    /**
     * Getter of measure's arm
     * @return MeasureUnit a protected copy of measure's arm
     */
    public function getarm()
    {
        return (isset($this->arm)) ? $this->arm->getCopy() : null;
    }

    /**
     * Getter of measure's waist
     * @return MeasureUnit a protected copy of measure's waist
     */
    public function getwaist()
    {
        return (isset($this->waist)) ? $this->waist->getCopy() : null;
    }

    /**
     * Getter of measure's hip
     * @return MeasureUnit a protected copy of measure's hip
     */
    public function gethip()
    {
        return (isset($this->hip)) ? $this->hip->getCopy() : null;
    }

    /**
     * Getter of measure's inseam
     * @return MeasureUnit a protected copy of measure's inseam
     */
    public function getInseam()
    {
        return (isset($this->inseam)) ? $this->inseam->getCopy() : null;
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
     * + the map used to build is a line from db
     * @param string[] $tabLine
     * $tabLine = [
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
    public static function getDatas4Measure($tabLine)
    {
        $datas["measureID"] = $tabLine["measureID"];
        $datas["measure_name"] = $tabLine["measureName"];
        $datas["bust"] = $tabLine["userBust"];
        $datas["arm"] = $tabLine["userArm"];
        $datas["waist"] = $tabLine["userWaist"];
        $datas["hip"] = $tabLine["userHip"];
        $datas["inseam"] = $tabLine["userInseam"];
        $datas["unit_name"] = $tabLine["unit_name"];
        $datas["setDate"] = $tabLine["setDate"];
        return $datas;
    }

    /**
     * Build a map that contain all value needed to create a Measure with datas posted($_POST)
     * @return string[] a map that contain all value needed to create a Measure
     */
    public static function getDatas4MeasurePOST()
    {
        $datas[Measure::MEASURE_ID_KEY] = Query::existParam(Measure::MEASURE_ID_KEY)? Query::getParam(Measure::MEASURE_ID_KEY) : null;
        $datas[Measure::INPUT_MEASURE_NAME] = Query::getParam(Measure::INPUT_MEASURE_NAME);
        $datas[Measure::INPUT_BUST] = Query::getParam(Measure::INPUT_BUST);
        $datas[Measure::INPUT_ARM] = Query::getParam(Measure::INPUT_ARM);
        $datas[Measure::INPUT_WAIST] = Query::getParam(Measure::INPUT_WAIST);
        $datas[Measure::INPUT_HIP] = Query::getParam(Measure::INPUT_HIP);
        $datas[Measure::INPUT_INSEAM] = Query::getParam(Measure::INPUT_INSEAM);
        $datas[MeasureUnit::INPUT_MEASURE_UNIT] = Query::getParam(MeasureUnit::INPUT_MEASURE_UNIT);
        return $datas;
    }

    /**
     * To get a protected copy of this Measure
     * @return Measure a protected copy of this Measure
     */
    // public function getCopy()
    // {
    //     $copy = new Measure();
    //     $copy->measureID = $this->measureID;
    //     $copy->measureName = $this->measureName;
    //     $copy->bust = (!empty($this->bust)) ? $this->bust->getCopy() : null;
    //     $copy->arm = (!empty($this->arm)) ? $this->arm->getCopy() : null;
    //     $copy->waist = (!empty($this->waist)) ? $this->waist->getCopy() : null;
    //     $copy->hip = (!empty($this->hip)) ? $this->hip->getCopy() : null;
    //     $copy->inseam = (!empty($this->inseam)) ? $this->inseam->getCopy() : null;
    //     $copy->setDate = $this->setDate;
    //     return $copy;
    // }

    /**
     * Save the measure by INSERT it in database
     * @param string $userID Visitor's id
     * @param Response $response if its success Response.isSuccess = true else Response
     *  contain the error thrown
     */
    public function save($response, $userID)
    {
        $bracket = "(?,?,?,?,?,?,?,?,?,?)";
        $sql = "INSERT INTO `UsersMeasures`(`userId`, `measureID`, `measureName`, `userBust`, `userArm`, `userWaist`, `userHip`, `userInseam`, `unit_name`, `setDate`) 
        VALUES " . $this->buildBracketInsert(1, $bracket);
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
        $response = $this->insert($response, $sql, $values);
    }

    /**
     * Delete the measure from database
     * @param string $userID Visitor's id
     * @param Response $response if its success Response.isSuccess = true else Response
     *  contain the error thrown
     */
    public function deleteMeasure(Response $response, $userID)
    {
        $query = "DELETE FROM `UsersMeasures` WHERE `userId` = '$userID' AND `measureID` = '$this->measureID'";
        $response = $this->delete($response, $query);
    }

    /**
     * Update the measure on database
     * @param Measure $newMeasure contain the new values for this measure
     * @param string $userID Visitor's id
     * @param Response $response if its success Response.isSuccess = true else Response
     *  contain the error thrown
     */
    public function updateMeasure(Response $response, $userID, Measure $newMeasure)
    {
        $sql =
            "UPDATE `UsersMeasures` SET 
        `measureName` = ?,
        `userBust` = ?,
        `userArm` = ?,
        `userWaist` = ?,
        `userHip` = ?,
        `userInseam` = ?,
        `unit_name` = ?
        WHERE `userId`= '$userID' AND `measureID`= '$this->measureID'";

        // $this->measureName = $newMeasure->getMeasureName();
        // $this->bust = $newMeasure->getbust()->getCopy();
        // $this->arm = $newMeasure->getarm()->getCopy();
        // $this->waist = $newMeasure->getwaist()->getCopy();
        // $this->hip = $newMeasure->gethip()->getCopy();
        // $this->inseam = $newMeasure->getinseam()->getCopy();
        $values = [];
        array_push($values, $newMeasure->measureName);
        array_push($values, $newMeasure->bust->getValue());
        array_push($values, $newMeasure->arm->getValue());
        array_push($values, $newMeasure->waist->getValue());
        array_push($values, $newMeasure->hip->getValue());
        array_push($values, $newMeasure->inseam->getValue());
        array_push($values, $newMeasure->inseam->getUnitName());
        $this->update($response, $sql, $values);
    }
}
