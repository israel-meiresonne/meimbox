<?php

require_once 'model/ModelFunctionality.php';
require_once 'model/tools-management/Measure.php';

/**
 *  This class has 3 states: 
 *  + 1-size => only the Measure's size atrribut is set
 *  + 2-brand+size => only the Measure's size and brand atrribut is set
 *  + 3-measure => $selectedMeasure holds the Visitor's Measures
 */
class Size  extends ModelFunctionality
{

    /**
     * Holds the alphanumeric value of size
     * @var string
     */
    private $size;

    /**
     * Holds the selected brand name
     * @var string
     */
    private $brandName;

    /**
     * Holds the selected measure
     * @var Measure
     */
    private $measure;

    /**
     * Holds the selected cut name
     * @var string
     */
    private $cut;

    /**
     * Holds the quantity of this product in a container like basket or box
     * + in container, a product is defined by its id and Size
     * @var int
     */
    private $quantity;

    /**
     * Holds the added date of this product to basket or box
     * @var string
     */
    private $setDate;

    // /**
    //  * Holds the number of this product owned by container (basket or box)
    //  * @var int
    //  */
    // private $quantity;

    /**
     * Holds the access key for brand name in Query
     * @var string
     */
    public const KEY_BRAND_NAME =  "brand_name";

    /**
     * Acces key for size's sequence in ajax
     */
    public const KEY_SEQUENCE = "sequence";

    /**
     * Holds string value for a null atrribut
     * @var string
     */
    private const STR_NULL =  "null";

    /**
     * Holds access key for supported sizes from db's Constante tale
     * @var string
     */
    public const DEFAULT_CUT =  "fit";

    /**
     * Holds sequence separator
     * @var string
     */
    private const SEQUENCE_SEPARATOR =  "-";

    /**
     * Holds access key for supported sizes from db's Constante tale
     * @var string
     */
    public const SUPPORTED_SIZES =  "SUPPORTED_SIZES";

    /**
     * Holds configuration for size formular
     * @var string
     */
    public const CONF_SIZE_ADD_PROD =  "CONF_SIZE_ADD_PROD";

    /**
     * Holds configuration for size formular
     * @var string
     */
    public const CONF_SIZE_EDITOR =  "CONF_SIZE_EDITOR";

    /**
     * Holds the db's Sizes table name
     * @var string
     */
    public const TABLE_SIZES =  "Sizes";

    /**
     * Holds the column name from db's Sizes table
     * @var string
     */
    public const COLUMN_SIZE =  "sizeName";

    /**
     * Holds the input name for SIZE_TYPE_[ALPHANUM|MEASURE]
     * + its value is SIZE_TYPE_ALPHANUM or SIZE_TYPE_MEASURE
     * @var string
     */
    public const INPUT_SIZE_TYPE =  "size_type";
    /**
     * Holds value for size type input (INPUT_SIZE_TYPE)
     */
    public const SIZE_TYPE_ALPHANUM = "alphanum_size";
    public const SIZE_TYPE_MEASURE = "measurement_size";
    /**
     * Holds the input name
     * @var string
     */
    public const INPUT_ALPHANUM_SIZE =  "alphanum_size";
    /**
     * Holds the input name
     * @var string
     */
    public const INPUT_BRAND =  "brand_name";
    /**
     * Holds the input name
     * @var string
     */
    public const INPUT_CUT =  "cut";
    /**
     * Holds the input name
     * @var string
     */
    public const INPUT_QUANTITY =  "input_quantity";


    /**
     * Constructor
     * @param string $sequence size sequence in format size-brand-measureID
     * @param string $setDate date of add of this product to basket or box
     * @param string $cut the cut value
     */
    // public function __construct($sequence, $setDate, $cut)
    public function __construct($sequence, $setDate = null)
    {
        $sizeDatas = $this->explodeSequence($sequence);
        $size = $sizeDatas[0];
        $brand = $sizeDatas[1];
        $measure = $sizeDatas[2];
        $cut = $sizeDatas[3];
        if (empty($measure) && empty($size)) {
            throw new Exception("Param '\$measure' and '\$size' can't both be empty" . " in: " . __FILE__ . " line: " . __LINE__);
        }
        if (isset($measure) && isset($size)) {
            throw new Exception("Param '\$measure' and '\$size' can't both be setted" . " in: " . __FILE__ . " line: " . __LINE__);
        }
        $this->setDate = (!empty($setDate)) ? $setDate : $this->getDateTime();
        if (!empty($measure)) {
            if (empty($cut)) {
                throw new Exception("Param 'cut' can't be empty for a measure");
            }
            $this->measure = $measure;
            $this->cut = $cut;
        }
        if (!empty($size)) {
            $this->size = $size;
            $this->brandName = $brand;
        }
        $this->quantity = 1;
    }

    /**
     * To build a size sequence like size-brand-measureID
     * @param string|null $size the size value
     * @param string|null $brand the brand name
     * @param string|null $measureID measure's id
     * @return string like size-brand-measureID
     */
    public static function buildSequence($size, $brand, $measureID, $cut)
    {
        if (empty($measureID) && empty($size)) {
            throw new Exception("Param '\$measureID' and '\$size' can't both be empty" . " in: " . __FILE__);
        }
        if (isset($measureID) && isset($size)) {
            throw new Exception("Param '\$measureID' and '\$size' can't both be setted" . " in: " . __FILE__);
        }
        if (isset($measureID) && (!isset($cut))) {
            throw new Exception("Param '\$cut' have to be setted when '\$measureID' is setted" . " in: " . __FILE__);
        }
        if ((isset($size) || isset($brand)) && (isset($cut))) {
            throw new Exception("Param '\$cut' can't be setted when '\$size' or '\$brand' is setted" . " in: " . __FILE__);
        }
        $sequence = "";
        $sequence .= (!empty($size)) ? $size : self::STR_NULL;
        $sequence .= self::SEQUENCE_SEPARATOR;
        $sequence .= (!empty($brand)) ? $brand : self::STR_NULL;
        $sequence .= self::SEQUENCE_SEPARATOR;
        $sequence .= (!empty($measureID)) ? $measureID : self::STR_NULL;
        $sequence .= self::SEQUENCE_SEPARATOR;
        $sequence .= (!empty($cut)) ? $cut : self::STR_NULL;
        return $sequence;
    }

    /**
     * To unbuild a size sequence following the separator
     * @param string $sequence size sequence in format size-brand-measureID
     * @return array contain datas about the size
     * + [0] => size{string}|null
     * + [1] => brand{string}|null
     * + [2] => Measure{obj}|null
     * + [3] => cut{string}|null
     */
    private function explodeSequence($sequence)
    {
        $datas = explode(self::SEQUENCE_SEPARATOR, $sequence);
        if (count($datas) != 4) {
            throw new Exception("Sequence is incorrect '$sequence' ");
        }
        $datas[0] = ($datas[0] == self::STR_NULL) ? null : $datas[0];   // size
        $datas[1] = ($datas[1] == self::STR_NULL) ? null : $datas[1];   // brand
        if ($datas[2] != self::STR_NULL) {                               // measure
            $sql = "SELECT * FROM `UsersMeasures` WHERE `measureID` = '$datas[2]'";
            $tab = $this->select($sql);
            if (count($tab) != 1) {
                throw new Exception("The measureID '$datas[2]' don't exist");
            }
            $tabLine = $tab[0];
            $measureMap = Measure::getDatas4Measure($tabLine);
            $datas[2] = new Measure($measureMap);
            if ($datas[3] == self::STR_NULL) {
                throw new Exception("Param '\$cut' have to be setted when '\$measureID' is setted" . " in: " . __FILE__);
            }
        } else {
            $datas[2] = null;
            $datas[3] = null;
        }
        return $datas;
    }

    /**
     * Setter for product's quantity
     * @param int $quantity product's quantity
     */
    public function setQuantity(int $quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * To increase or decrease the quantity of product holds by container
     * + if $delta is empty, its increment quantity of 1
     * + if $delta > 0, its increment quantity of $delta
     * + if $delta < 0, its subtract quantity of $delta
     * + if $delta = 0, its do nothing
     * @param int $delta amount to add/subtract on quantity
     */
    public function addQuantity(int $delta)
    {
        $quantity = $this->getQuantity();
        if (($quantity + $delta) <= 0) {
            throw new Exception("Quantity can't be bellow or equals at zero: holdQuantity: $quantity, delta: $delta");
        }
        // (!empty($delta)) ? $this->quantity += $delta : ++$this->quantity;
        $this->quantity += $delta;
        $this->setDate = $this->getDateTime();
    }

    /**
     * Getter for Size's size value
     * @param boolean $wantStr set true if you want null to be a string else set false or don't set
     * @return string size's size size value
     */
    public function getsize($wantStr = false)
    {
        if ($wantStr) {
            return (!empty($this->size)) ? $this->size : self::STR_NULL;
        }
        return $this->size;
    }
    /**
     * Getter for size's brandName
     * @param boolean true if you want null to be a string if empty else false
     *  of nothing
     * @return string size's brandName
     */
    public function getbrandName($wantStr = false)
    {
        if ($wantStr) {
            return (!empty($this->brandName)) ? $this->brandName : self::STR_NULL;
        }
        return $this->brandName;
    }

    /**
     * Getter for size's measure
     * @return Measure size's measure
     */
    public function getmeasure()
    {
        return $this->measure;
    }

    /**
     * Getter for size's measure
     * @param boolean true if you want null to be a string if empty else false
     *  of nothing
     * @return string size's measure
     */
    public function getmeasureID($wantStr = false)
    {
        if ($wantStr) {
            return (!empty($this->measure)) ? $this->measure->getMeasureID() : self::STR_NULL;
        }
        return (!empty($this->measure)) ? $this->measure->getMeasureID() :  null;
    }

    /**
     * Getter for size's cut
     * @return string size's cut
     */
    public function getCut()
    {
        return $this->cut;
    }

    /**
     * Getter for product's quantity holds in container
     * @return int product's quantity holds in container
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Getter of the set date
     * @return string the set date
     */
    public function getSetDate()
    {
        return $this->setDate;
    }

    /**
     * Evaluate the type of the Size
     * + SIZE_TYPE_ALPHANUM
     * + SIZE_TYPE_MEASURE
     * @return string size's type
     */
    public function getType()
    {
        $size = $this->getsize();
        if (!empty($size)) {
            return self::SIZE_TYPE_ALPHANUM;
        }
        $measure = $this->getmeasure();
        if (!empty($measure)) {
            return self::SIZE_TYPE_MEASURE;
        }
        throw new Exception("Size's type is undefined");
    }

    /**
     * To generate size's sequence
     * @return string size's sequence
     */
    public function getSequence()
    {
        $size = $this->getsize();
        $brand = $this->getbrandName();
        $measureID = $this->getmeasureID();
        $cut = $this->getCut();
        return self::buildSequence($size, $brand, $measureID, $cut);
    }

    /**
     * To check if two Size is equal
     * + two size is equal is they have the sam size sequance
     * @param Size $size1 size to compare with the second one
     * @param Size $size1 size to compare with the first one
     * @return boolean true if the two Size arre equals else false
     */
    public static function equals(Size $size1, Size $size2)
    {
        $sequence1 = $size1->getSequence();
        $sequence2 = $size2->getSequence();
        return ($sequence1 == $sequence2);
    }
}
