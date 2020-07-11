<?php

/**
 *  This class has 3 states: 
 *      1-size => only the Measure's size atrribut is set
 *      2-brand+size => only the Measure's size and brand atrribut is set
 *      3-measure => $selectedMeasure holds the Visitor's Measures
 */
class Size
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
     * Holds the selected cut name
     * @var string
     */
    private $cut;

    /**
     * Holds the selected measure
     * @var Measure
     */
    private $measure;

    /**
     * Holds the number of this product owned by container (basket or box)
     * @var int
     */
    private $quantity;

    /**
     * Holds the added date of this product to basket or box
     * @var string
     */
    private $setDate;

    /**
     * Holds the input name
     * @var string
     */
    const SIZE =  "size";

    /**
     * Holds the input name
     * @var string
     */
    const CUT =  "cut";

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

            case 6:
                self::__construct6($argv[0], $argv[1], $argv[2], $argv[3], $argv[4], $argv[5]);
                break;
        }
    }

    private function __construct0()
    {
    }

    /**
     * Constructor
     * @param string $size the size value
     * @param string $brand the brand name
     * @param string $cut the cut value
     * @param int $brand total number of product
     * @param string $setDate date of add of this product to basket or box
     * @param Measure $measure Visitor's measure
     */
    private function __construct6($size, $brand, $cut, $quantity, $setDate, $measure)
    {
        $this->size = $size;
        $this->brandName = $brand;
        $this->measure = $measure;
        $this->quantity = $quantity;
        $this->setDate = $setDate;
        $this->cut = $cut;
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
     * To get a protected copy of this Size
     * @return Size a protected copy of this Size
     */
    public function getCopy()
    {
        $copy = new Size();
        $copy->size = $this->size;
        $copy->brandName = $this->brandName;
        $copy->cut = $this->cut;
        $copy->measure = (!empty($this->measure)) ? $this->measure->getCopy() : null;
        $copy->quantity = $this->quantity;
        $copy->setDate = $this->setDate;
        return $copy;
    }
}
