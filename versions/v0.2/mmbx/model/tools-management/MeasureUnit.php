<?php

require_once 'model/ModelFunctionality.php';

class MeasureUnit extends ModelFunctionality
{
    /**
     * Holds the MeasureUnit's complete name (ex: uk, us, centimeter, meter, foot|feet, etc...)
     * @var string
     */
    private $unitName;

    /**
     * Holds the MeasureUnit's value
     * @var double
     */
    private $value;

    /**
     * Holds the MeasureUnit's short reprentation (ex: cm, m, ft, etc...)
     * @var string
     */
    private $unit;

    /**
     * Holds the MeasureUnit's conversion coefficient to the system's default measure 
     * (cm). NOTE: the coefficient have to allow to convert the measure by using a multiplication between 
     * @var double
     */
    private $toSystUnit;

    public const INPUT_MEASURE_UNIT = "unit_name";

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
     * @param string $unitName the measure's unit name
     * @param string[string[...]] $dbMap The database tables in mapped format specified in file 
     * oop/model/special/dbMap.txt
     */
    public function __construct($value, $unitName)
    {
        self::setConstants();
        if (!in_array($unitName, self::$SUPPORTED_UNIT)) {
            throw new Exception("This unit measure is not supported: unitName=$unitName");
        }
        if ($this->existUnit($unitName)) {
            $tabLine = $this->getUnitLine($unitName);
            $this->unitName = $unitName;
            $this->value = (float) $value;
            $this->unit = $tabLine["measureUnit"];
            $this->toSystUnit = $tabLine["toSystUnit"];
        }
    }

    /**
     * Initialize MeasureUnit's constants
     */
    private static function setConstants()
    {
        if (!isset(self::$SUPPORTED_UNIT)) {
            self::$SUPPORTED_UNIT = "SUPPORTED_UNIT";
            $SUPPORTED_UNIT_json = parent::getConstantLine(self::$SUPPORTED_UNIT)["jsonValue"];
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
    public static function getSUPPORTED_UNIT()
    {
        (!isset(self::$SUPPORTED_UNIT)) ? self::setConstants() : null;
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
     * Check if first measure is bellow seconde measure
     * + all measure not null from second is compared to first
     * + formula: (first + cut) <= second
     * @param Measure $firstM
     * @param Measure $secondM 
     * @param string $cut used to get error margin
     * @return boolean true if first measure is bellow all measure of second else false
     */
    public static function compare(MeasureUnit $first, MeasureUnit $second, MeasureUnit $cut)
    {
        $leftVal = (($first->value * $first->toSystUnit) + ($cut->value * $cut->toSystUnit));
        $rightVal = $second->value * $second->toSystUnit;
        // var_dump("user", $leftVal);
        // var_dump("product", $rightVal);
        // echo "\n—————————";
        return ($leftVal <= $rightVal);
    }
}
