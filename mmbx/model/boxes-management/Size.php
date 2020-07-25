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
     * Holds the selected size
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
     * Holds access key for supported sizes from db's Constante tale
     * @var string
     */
    public const SUPPORTED_SIZES =  "SUPPORTED_SIZES";

    /**
     * Holds sequence separator
     * @var string
     */
    private const SEQUENCE_SEPARATOR =  "-";

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
     * Holds the input choice available [SIZE or MEASUREMENT]
     * @var string
     */
    public const INPUT_SIZE_TYPE =  "size_type";
    /**
     * Holds value for size type input (INPUT_SIZE_TYPE)
     */
    public const SIZE_TYPE_CHAR = "char_size";
    public const SIZE_TYPE_MEASURE = "measurement_size";

    /**
     * Holds the input name
     * @var string
     */
    public const INPUT_CHAR_SIZE =  "char_size";

    /**
     * Holds the input name
     * @var string
     */
    public const INPUT_BRAND =  "brand_name";
    // /**
    //  * Holds the input name
    //  * @var string
    //  */
    // public const INPUT_MEASUREMENT =  "measurement";
    /**
     * Holds the input name
     * @var string
     */
    public const INPUT_CUT =  "cut";

    /**
     * Constructor
     * @param string $sequence size sequence in format size-brand-measureID
     * @param string $setDate date of add of this product to basket or box
     * @param string $cut the cut value
     */
    public function __construct($sequence, $setDate = null, $cut = null)
    {
        $sizeDatas = $this->explodeSequence($sequence);
        $size = $sizeDatas[0];
        $brand = $sizeDatas[1];
        $measure = $sizeDatas[2];
        if(empty($measure) && empty($size)){
            throw new Exception("Param '\$measure' and '\$size' can't both be empty");
        }
        if(isset($measure) && isset($size)){
            throw new Exception("Param '\$measure' and '\$size' can't both be setted");
        }
        $this->setDate = (!empty($setDate))? $setDate : $this->getDateTime();
        if (!empty($measure)) {
            if (empty($cut)) {
                throw new Exception("Param 'cut' can't be empty for a measurement");
            }
            $this->measure = $measure;
            $this->cut = $cut;
        }
        if(!empty($size)){
            $this->size = $size;
            $this->brandName = $brand;
        }
    }

    /**
     * To build a size sequence like size-brand-measureID
     * @param string $size the size value
     * @param string $brand the brand name
     * @param string $measureID measure's id
     * @return string like size-brand-measureID
     */
    public static function buildSequence($size = null, $brand = null, $measureID = null)
    {
        if(empty($measureID) && empty($size)){
            throw new Exception("Param '\$measureID' and '\$size' can't both be empty");
        }
        if(isset($measureID) && isset($size)){
            throw new Exception("Param '\$measureID' and '\$size' can't both be setted");
        }
        $sequence = "";
        $sequence .= (!empty($size)) ? $size : "null";
        $sequence .= self::SEQUENCE_SEPARATOR;
        $sequence .= (!empty($brand)) ? $brand : "null";
        $sequence .= self::SEQUENCE_SEPARATOR;
        $sequence .= (!empty($measureID)) ? $measureID : "null";
        return $sequence;
    }

    /**
     * To unbuild a size sequence following the separator
     * @param string $sequence size sequence in format size-brand-measureID
     * @return array contain datas about the size
     * + [0] => size{string}|null
     * + [0] => brand{string}|null
     * + [0] => Measure{obj}|null
     */
    private function explodeSequence($sequence)
    {
        $datas = explode(self::SEQUENCE_SEPARATOR, $sequence);
        if (count($datas) != 3) {
            throw new Exception("Sequence is incorrect '$sequence' ");
        }
        $datas[0] = ($datas[0] == "null") ? null : $datas[0];
        $datas[1] = ($datas[1] == "null") ? null : $datas[1];
        if($datas[2] != "null") {
            $sql = "SELECT * FROM `UsersMeasures` WHERE `measureID` = '$datas[2]'";
            $tab = $this->select($sql);
            if(count($tab) != 1){
                throw new Exception("The measureID '$datas[2]' don't exist");
            }
            $tabLine = $tab[0];
            $measureDatas = Measure::getDatas4Measure($tabLine);
            $datas[2] = new Measure($measureDatas);
        }
        return $datas;
    }

    // /**
    //  * Constructor
    //  * @param string $size the size value
    //  * @param string $brand the brand name
    //  * @param string $cut the cut value
    //  * @param int $brand total number of product
    //  * @param string $setDate date of add of this product to basket or box
    //  * @param Measure $measure Visitor's measure
    //  */
    // private function __construct6($size, $brand, $measure, $cut, $setDate)
    // {
    //     $this->size = $size;
    //     $this->brandName = $brand;
    //     $this->measure = $measure;
    //     $this->setDate = $setDate;
    //     $this->cut = $cut;
    // }

    /**
     * Getter of the set date
     * @return string the set date
     */
    public function getSetDate()
    {
        return $this->setDate;
    }

    /**
     * To get a protected copy of this Size
     * @return Size a protected copy of this Size
     */
    // public function getCopy()
    // {
    //     $copy = new Size();
    //     $copy->size = $this->size;
    //     $copy->brandName = $this->brandName;
    //     $copy->cut = $this->cut;
    //     $copy->measure = (!empty($this->measure)) ? $this->measure->getCopy() : null;
    //     $copy->quantity = $this->quantity;
    //     $copy->setDate = $this->setDate;
    //     return $copy;
    // }
}
