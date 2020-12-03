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

    /**
     * Holds Measue of supported sizes
     * @var Map
     * + $sizeMeasures[size] => Measure
     */
    private static $sizeMeasures;

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
    public const SEQUENCE_SEPARATOR =  "-";

    /**
     * Holds access key for supported sizes from file datas.json
     * @var string
     */
    public const SUPPORTED_SIZES =  "supported_sizes";

    /**
     * Holds configuration for size formular
     * @var string
     */
    public const CONF_SIZE_ADD_PROD =  "conf_size_add_prod";

    /**
     * Holds configuration for size formular
     * @var string
     */
    public const CONF_SIZE_EDITOR =  "conf_size_editor";

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
    private const INPUT_CUT =  "cut";
    public const INPUT_CUT_ADDER =  self::INPUT_CUT . "_" . self::CONF_SIZE_ADD_PROD;
    public const INPUT_CUT_EDITOR =  self::INPUT_CUT . "_" . self::CONF_SIZE_EDITOR;
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
    public function __construct()
    {
        $args = func_get_args();
        $nb = func_num_args();
        switch ($nb) {
            case 0:
                $this->__construct0();
                break;
            case 1:
                $this->__construct2($args[0]);
                break;
            case 2:
                $this->__construct2($args[0], $args[1]);
                break;

            default:
                throw new Exception("The number of param is incorrect, number:$nb");
                break;
        }
    }

    private function __construct0()
    {
    }

    /**
     * Constructor
     * @param string $sequence size sequence in format size-brand-measureID
     * @param string $setDate date of add of this product to basket or box
     * @param string $cut the cut value
     */
    private function __construct2($sequence, $setDate = null)
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
            self::getSupportedSizes($size); // throw error if size not supported
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
     * To set Measure of a supported size
     * @param string|int $size a supported size
     */
    private static function setSizeMeasure($size)
    {
        $sql = "SELECT * FROM `SizesMeasures` WHERE `size_name`='$size'";
        $tab = parent::select($sql);
        if (empty($tab)) {
            throw new Exception("This size '$size' don't have measure in database");
        }
        $measureDatas  = [];
        foreach ($tab as $tabLine) {
            if (!isset($measureDatas["unitName"])) {
                $measureDatas["unitName"] = $tabLine["unit_name"];
            }
            if ($measureDatas["unitName"] != $tabLine["unit_name"]) {
                throw new Exception("Unit must be the same for all measure, unit:" . $measureDatas['unit_name'] . "!=" . $tabLine["unit_name"]);
            }
            $bodyPart = $tabLine["body_part"];
            $measureDatas[$bodyPart] = (float) $tabLine["value"];
        }
        $measureMap = Measure::getDatas4Measure($measureDatas);
        $measure = new Measure($measureMap);
        self::$sizeMeasures->put($measure, $size);
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
     * To get from db the supported sizes
     * + the type of size is automatically deducted with the type of size holds
     * in the sizeStock attribut
     * @param string|int|float $sizeSample size used to determinate the type of the size to return
     * @return array a list of supported sizes get from db
     */
    public static function getSupportedSizes($sizeSample)
    {
        $supported = null;
        $dbSizes = Configuration::getFromJson(Configuration::JSON_KEY_CONSTANTS)[Size::SUPPORTED_SIZES];
        foreach ($dbSizes as $type => $supportedSizes) {
            if (in_array($sizeSample, $dbSizes[$type])) {
                $supported = $dbSizes[$type];
                break;
            }
        }
        if (empty($supported)) {
            throw new Exception("This type of size is not supported, size:$sizeSample");
        }
        return $supported;
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
     * To order size from lower to hight
     * + Note: use order of supported size
     * @param array $sizes sizes to order
     * + $sizes[index] => size{string|int}
     * @return array ordered array
     */
    public static function orderSizes($sizes)
    {
        if (empty($sizes)) {
            throw new Exception("Sizes can't be empty");
        }
        $supported = self::getSupportedSizes($sizes[0]);
        $ordered =  [];
        foreach ($supported as $size) {
            if (in_array($size, $sizes)) {
                array_push($ordered, $size);
                // $ordered[$size] = $toOrderSizes[$size];
            }
        }
        return $ordered;
    }

    /**
     * Getter for size's brandName
     * @param bool $wantStr true if you want null to be a string when empty else set false or empty
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
     * To get Measure of a supporetd size given
     * @param string|int $size a supported size
     * @return Measure Measure of the size given
     */
    public static function getSizeMeasure($size)
    {
        (!isset(self::$sizeMeasures)) ? (self::$sizeMeasures = new Map()) : null;
        $sizes = self::$sizeMeasures->getKeys();
        (!in_array($size, $sizes)) ? self::setSizeMeasure($size) : null;
        return self::$sizeMeasures->get($size);
    }

    /**
     * Getter for size's measure
     * @param bool $wantStr true if you want null to be a string when empty else set false or empty
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
     * @param bool $wantStr true if you want null to be a string when empty else set false or empty
     * @return string size's cut
     */
    public function getCut($wantStr = false)
    {
        return $this->cut;
        if ($wantStr) {
            return (!empty($this->cut)) ? $this->cut : self::STR_NULL;
        }
        return (!empty($this->cut)) ? $this->cut :  null;
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

    /**
     * To get A copy of the currrent instance
     * @return Size
     */
    public function getCopy()
    {
        $map = get_object_vars($this);
        $attributs = array_keys($map);
        $class = get_class($this);
        $copy = new $class();
        if ($class == Size::class) {
        }
        foreach ($attributs as $attribut) {
            switch (gettype($this->{$attribut})) {
                    // case 'object':
                    //     $copy->{$attribut} = $this->{$attribut}->getCopy();
                    //     break;
                default:
                    $copy->{$attribut} = $this->{$attribut};
                    break;
            }
        }
        return $copy;
    }

    /**
     * To get Suppported cuts from database
     * @return string[] Suppported cuts
     */
    public static function getSupportedCuts()
    {
        $tab = parent::getTableValues("cuts");
        $cuts = array_keys($tab);
        return $cuts;
    }

}
