<?php

class MeasureUnit
{
    /**
     * Holds the Length's complete name (ex: uk, us, centimeter, meter, foot|feet, etc...)
     * @var string
     */
    private $unitName;

    /**
     * Holds the Length's value
     * @var double
     */
    private $value;

    /**
     * Holds the Length's short reprentation (ex: cm, m, ft, etc...)
     * @var string
     */
    private $unit;

    /**
     * Holds the Length's conversion coefficient to the system's default measure 
     * (cm). NOTE: the coefficient have to allow to convert the measure by using a multiplication between 
     * @var double
     */
    private $toSystUnit;

    const INPUT_MEASURE_UNIT = "unit_name";

    /**
     * Holds a list of measure unit available for Visitor's input
     * @var string[] 
     * $SUPPORTED_UNIT = [
     *      index => unitName{string}
     * ]
     */
    private static $SUPPORTED_UNIT;

    /**
     * Constructor
     * @param float $value the measure's value
     * @param string $measureName the measure's unit name
     * @param string[string[...]] $dbMap The database tables in mapped format specified in file 
     * oop/model/special/dbMap.txt
     */
    function __construct()
    {
        $argv = func_get_args();
        switch (func_num_args()) {
            case 0:
                self::__construct0();
                break;

            case 3:
                self::__construct3($argv[0], $argv[1], $argv[2]);
                break;
        }
    }

    private function __construct0()
    {
    }

    private function __construct3($value, $measureName, $dbMap)
    {
        self::setConstants($dbMap);
        if (array_key_exists(self::$SUPPORTED_UNIT, $dbMap["constantMap"])) {
        }

        $this->unitName = $measureName;
        $this->value = (float) $value;
        $this->unit = $dbMap["measureUnits"][$measureName]["measureUnit"];
        $coeff = $dbMap["measureUnits"][$measureName]["toSystUnit"];
        $this->toSystUnit = !empty($coeff) ? (float) $coeff : null;
    }

    /**
     * Initialize MeasureUnit's constants
     * @var string[string[...]] $dbMap The database tables in mapped format 
     * specified in file /oop/model/special/dbMap.txt
     */
    private function setConstants($dbMap)
    {
        if (!isset(self::$SUPPORTED_UNIT)) {
            self::$SUPPORTED_UNIT = "SUPPORTED_UNIT";
            $SUPPORTED_UNIT_json = $dbMap["constantMap"][self::$SUPPORTED_UNIT]["jsonValue"];
            self::$SUPPORTED_UNIT = json_decode($SUPPORTED_UNIT_json);
        }
    }

    /**
     * Getter for measure unit's name
     * @return string measure unit's name
     */
    public function getUnitName()
    {
        return $this->unitName;
    }

    /**
     * Getter for measure unit's value
     * @return float measure unit's value
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Getter for measure unit's symbol
     * @return string measure unit's symbol
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Gettert of measure unit's supported unit list
     * @return string[] measure unit's supported unit list
     */
    public function getSUPPORTED_UNIT()
    {
        return self::$SUPPORTED_UNIT;
    }

    /**
     * Format the measure unit to make it into a displayable format for Visitor
     * @return string the measure unit into a displayable format
     */
    public function getFormated()
    {
        $value = number_format($this->value, 2, ",", " ");
        return $value . " " . $this->unit;
    }

    /**
     * To get a protected copy of this MeasureUnit
     * @return MeasureUnit a protected copy of this MeasureUnit
     */
    public function getCopy()
    {
        $copy = new MeasureUnit();
        $copy->unitName = $this->unitName;
        $copy->value = $this->value;
        $copy->unit = $this->unit;
        $copy->toSystUnit = $this->toSystUnit;
        return $copy;
    }
}
