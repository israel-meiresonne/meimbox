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
     * Input name for arm
     */
    const INPUT_ARM = "arm";

    /**
     * Input name for bust
     */
    const INPUT_BUST = "bust";

    /**
     * Input name for hip
     */
    const INPUT_HIP = "hip";

    /**
     * Input name for inseam
     */
    const INPUT_INSEAM = "inseam";

    /**
     * Input name for waist
     */
    const INPUT_WAIST = "waist";

    /**
     * Holds the access key for measure name in Query
     * @var string
     */
    // const KEY_MEASURE_ID =  "measure_id";
    const KEY_MEASURE_ID =  "measureID";

    /**
     * Holds the access key for measure name
     * @var string
     */
    const MEASURRE_STICKER_KEY =  "measure_sticker";

    /**
     * Constructor
     * @param Map $measureMap contain measure's submited datas
     * + $measureMap[Map::measureID] holds measure's measureID
     * + $measureMap[Map::unitName] holds measure's unit name
     * + $measureMap[Map::measureName] holds measure's name
     * + $measureMap[Map::bust] holds measure's Bust value
     * + $measureMap[Map::arm] holds measure's Arm value
     * + $measureMap[Map::waist] holds measure's Waist value
     * + $measureMap[Map::hip] holds measure's Hip value
     * + $measureMap[Map::inseam] holds measure's Inseam value
     * + $measureMap[Map::setDate] holds measure's creation date
     *
     */
    public function __construct(Map $measureMap)
    {
        $unitName = $measureMap->get(Map::unitName);
        $this->measureID = (!empty($measureMap->get(Map::measureID))) ? $measureMap->get(Map::measureID) : $this->generateDateCode(self::ID_LENGTH);
        $this->measureName = (!empty($measureMap->get(Map::measureName))) ? $measureMap->get(Map::measureName) : $this->generateDateCode(self::ID_LENGTH);;
        $this->bust = (!empty($measureMap->get(Map::bust))) ? new MeasureUnit($measureMap->get(Map::bust), $unitName) : null;
        $this->arm = (!empty($measureMap->get(Map::arm))) ? new MeasureUnit($measureMap->get(Map::arm), $unitName) : null;
        $this->waist = (!empty($measureMap->get(Map::waist))) ? new MeasureUnit($measureMap->get(Map::waist), $unitName) : null;
        $this->hip = (!empty($measureMap->get(Map::hip))) ? new MeasureUnit($measureMap->get(Map::hip), $unitName) : null;
        $this->inseam = (!empty($measureMap->get(Map::inseam))) ? new MeasureUnit($measureMap->get(Map::inseam), $unitName) : null;
        $this->setDate = !empty($measureMap->get(Map::setDate)) ? $measureMap->get(Map::setDate) : $this->getDateTime();
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
     * Getter of measure's arm
     * @return MeasureUnit a protected copy of measure's arm
     */
    public function getarm()
    {
        return (isset($this->arm)) ? $this->arm : null;
    }

    /**
     * Getter of measure's bust
     * @return MeasureUnit a protected copy of measure's bust
     */
    public function getbust()
    {
        return (isset($this->bust)) ? $this->bust : null;
    }

    /**
     * Getter of measure's hip
     * @return MeasureUnit a protected copy of measure's hip
     */
    public function gethip()
    {
        return (isset($this->hip)) ? $this->hip : null;
    }

    /**
     * Getter of measure's inseam
     * @return MeasureUnit a protected copy of measure's inseam
     */
    public function getInseam()
    {
        return (isset($this->inseam)) ? $this->inseam : null;
    }

    /**
     * Getter of measure's waist
     * @return MeasureUnit a protected copy of measure's waist
     */
    public function getwaist()
    {
        return (isset($this->waist)) ? $this->waist : null;
    }

    /**
     * Getter for Measure's creation date
     * @return string Measure's creation date
     */
    public function getSetDate()
    {
        return $this->setDate;
    }

    /**
     * Convert setDate to limitee from UNIX.
     * @return int limitee from UNIX
     */
    public function getDateInSec()
    {
        return strtotime($this->setDate);
    }


    /**
     * Check if a given Measure is under or equal a limite Measure
     * + all measure not null from limite is isUnderLimited to measure
     * + formula: (measure + cut) <= limite
     * @param Measure $measureM
     * @param Measure $limite 
     * @param string $cut used to get error margin
     * @return bool true if Measure is under or equal all Measure of limite else false
     */
    public static function isUnderLimite(Measure $measure, Measure $limite, $cut)
    {
        $isBellow = false;
        $cutMap = parent::getTableValues("cuts");
        $value = $cutMap[$cut]["cutMeasure"];
        $unitName = $cutMap[$cut]["unit_name"];
        $cutObj = new MeasureUnit($value, $unitName);
        $isBellow = (!empty($limite->bust)) ? MeasureUnit::isUnderLimite($measure->bust, $limite->bust, $cutObj) : $isBellow;
        if (!$isBellow) {
            return $isBellow;
        }
        $isBellow = (!empty($limite->arm)) ? MeasureUnit::isUnderLimite($measure->arm, $limite->arm, $cutObj) : $isBellow;
        if (!$isBellow) {
            return $isBellow;
        }
        $isBellow = (!empty($limite->waist)) ? MeasureUnit::isUnderLimite($measure->waist, $limite->waist, $cutObj) : $isBellow;
        if (!$isBellow) {
            return $isBellow;
        }
        $isBellow = (!empty($limite->hip)) ? MeasureUnit::isUnderLimite($measure->hip, $limite->hip, $cutObj) : $isBellow;
        if (!$isBellow) {
            return $isBellow;
        }
        $isBellow = (!empty($limite->inseam)) ? MeasureUnit::isUnderLimite($measure->inseam, $limite->inseam, $cutObj) : $isBellow;
        return $isBellow;
    }

    /**
     * Build a map that contain all value needed to create a Measure
     * + the map used to build is a line from db
     * @param string[] $tabLine
     * + $tabLine["measureID"] => string,
     * + $tabLine["measure_name"] => string,
     * + $tabLine["userBust"] => float,
     * + $tabLine["userArm"] => float,
     * + $tabLine["userWaist"] => float,
     * + $tabLine["userHip"] => float,
     * + $tabLine["userInseam"] => float,
     * + $tabLine["unit_name"] => string,
     * + $tabLine["setDate"] => string
     * @return Map a map that contain all value needed to create a Measure
     */
    public static function getDatas4Measure($tabLine)
    {
        foreach ($tabLine as $key => $data) {
            if (preg_match("#user#", $key) == 1) {
                $newKey = strtolower(str_replace("user", "", $key));
                $tabLine[$newKey] = $data;
            }
            if (preg_match("#unit_name#", $key) == 1) {
                $newKey = str_replace("unit_name", "unitName", $key);
                $tabLine[$newKey] = $data;
            }
        }
        $measureMap = new Map();
        (!empty($tabLine["measureID"])) ? $measureMap->put($tabLine["measureID"], Map::measureID) : null;
        (!empty($tabLine["unitName"])) ? $measureMap->put($tabLine["unitName"], Map::unitName) : null;
        (!empty($tabLine["measureName"])) ? $measureMap->put($tabLine["measureName"], Map::measureName) : null;
        (!empty($tabLine["bust"])) ? $measureMap->put($tabLine["bust"], Map::bust) : null;
        (!empty($tabLine["arm"])) ? $measureMap->put($tabLine["arm"], Map::arm) : null;
        (!empty($tabLine["waist"])) ? $measureMap->put($tabLine["waist"], Map::waist) : null;
        (!empty($tabLine["hip"])) ? $measureMap->put($tabLine["hip"], Map::hip) : null;
        (!empty($tabLine["inseam"])) ? $measureMap->put($tabLine["inseam"], Map::inseam) : null;
        (!empty($tabLine["setDate"])) ? $measureMap->put($tabLine["setDate"], Map::setDate) : null;
        return $measureMap;
    }

    /*—————————————————— SCRUD DOWN —————————————————————————————————————————*/

    /**
     * Save the measure by INSERT it in database
     * @param string $userID Visitor's id
     * @param Response $response to push in results or accured errors
     *  contain the error thrown
     */
    public function insertMeasure($response, $userID)
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
        $this->insert($response, $sql, $values);
    }

    /**
     * Update the measure on database
     * @param Measure $newMeasure contain the new values for this measure
     * @param string $userID Visitor's id
     * @param Response $response to push in results or accured errors
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

    /**
     * Delete the measure from database
     * @param string $userID Visitor's id
     * @param Response $response to push in results or accured errors
     *  contain the error thrown
     */
    public function deleteMeasure(Response $response, $userID)
    {
        $query = "DELETE FROM `UsersMeasures` WHERE `userId` = '$userID' AND `measureID` = '$this->measureID'";
        $response = $this->delete($response, $query);
    }

    /**
     * To insert measures used in boxProduct ordered
     * @param Response $response to push in results or accured errors
     * @param Measure[] $measures measures used in boxProduct
     * + use measureID as access key
     * @param string $orderID id of an order
     */
    public static function insertOrderMeasures(Response $response, $measures, $orderID) // \[value-[0-9]*\]
    {
        $bracket = "(?,?,?,?,?,?,?,?,?,?)";
        $nb = count($measures);
        $sql = "INSERT INTO `Orders-UsersMeasures`(`orderId`, `measureID`, `measureName`, `bust`, `arm`, `waist`, `hip`, `inseam`, `unit_name`, `setDate`)
                VALUES " . self::buildBracketInsert($nb, $bracket);
        $values = [];
        foreach ($measures as $measure) {
            array_push(
                $values,
                $orderID,
                $measure->getMeasureID(),
                $measure->getMeasureName(),
                $measure->getbust()->getValue(),
                $measure->getarm()->getValue(),
                $measure->getwaist()->getValue(),
                $measure->gethip()->getValue(),
                $measure->getInseam()->getValue(),
                $measure->getbust()->getUnitName(),
                $measure->getSetDate()
            );
        }
        self::insert($response, $sql, $values);
    }
}
