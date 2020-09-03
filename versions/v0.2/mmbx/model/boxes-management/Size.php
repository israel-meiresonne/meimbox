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
    public const DEFAULT_CUT =  "fit";

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
    public function __construct($sequence, $setDate, $cut)
    {
        $sizeDatas = $this->explodeSequence($sequence);
        $size = $sizeDatas[0];
        $brand = $sizeDatas[1];
        $measure = $sizeDatas[2];
        if(empty($measure) && empty($size)){
            throw new Exception("Param '\$measure' and '\$size' can't both be empty"." in: ".__FILE__." line: ".__LINE__);
        }
        if(isset($measure) && isset($size)){
            throw new Exception("Param '\$measure' and '\$size' can't both be setted"." in: ".__FILE__." line: ".__LINE__);
        }
        $this->setDate = (!empty($setDate))? $setDate : $this->getDateTime();
        if (!empty($measure)) {
            if (empty($cut)) {
                throw new Exception("Param 'cut' can't be empty for a measure");
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
     * @param string|null $size the size value
     * @param string|null $brand the brand name
     * @param string|null $measureID measure's id
     * @return string like size-brand-measureID
     */
    public static function buildSequence($size, $brand, $measureID)
    {
        if(empty($measureID) && empty($size)){
            throw new Exception("Param '\$measureID' and '\$size' can't both be empty"." in: ".__FILE__);
        }
        if(isset($measureID) && isset($size)){
            throw new Exception("Param '\$measureID' and '\$size' can't both be setted"." in: ".__FILE__);
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
     * + [1] => brand{string}|null
     * + [2] => Measure{obj}|null
     */
    private function explodeSequence($sequence)
    {
        $datas = explode(self::SEQUENCE_SEPARATOR, $sequence);
        if (count($datas) != 3) {
            throw new Exception("Sequence is incorrect '$sequence' ");
        }
        $datas[0] = ($datas[0] == "null") ? null : $datas[0];   // size
        $datas[1] = ($datas[1] == "null") ? null : $datas[1];   // brand
        if($datas[2] != "null") {                               // measure
            $sql = "SELECT * FROM `UsersMeasures` WHERE `measureID` = '$datas[2]'";
            $tab = $this->select($sql);
            if(count($tab) != 1){
                throw new Exception("The measureID '$datas[2]' don't exist");
            }
            $tabLine = $tab[0];
            $measureDatas = Measure::getDatas4Measure($tabLine);
            $datas[2] = new Measure($measureDatas);
        } else {
            $datas[2] = null;
        }
        return $datas;
    }

    /**
     * Getter for Size's size value
     * @return string size's size size value
     */
    public function getsize()
    {
        return $this->size;
    }
    /**
     * Getter for size's brandName
     * @return string size's brandName
     */
    public function getbrandName()
    {
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
     * Getter for size's cut
     * @return string size's cut
     */
    public function getCut()
    {
        return $this->cut;
    }

    /**
     * Getter of the set date
     * @return string the set date
     */
    public function getSetDate()
    {
        return $this->setDate;
    }
}
