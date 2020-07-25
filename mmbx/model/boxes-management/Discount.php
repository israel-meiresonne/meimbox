<?php

class Discount
{
    /**
     * Value of the discount between 0 and 1 ([0,1])
     * @var double
     */
    private $value;

    /**
     * Date of the begin of the discount into format YYYY-MM-DD HH:MM:SS
     * @var string
     */
    private $beginDate;

    /**
     * Date of the end of the discount into format YYYY-MM-DD HH:MM:SS
     * @var string
     */
    private $endDate;

    public function __construct($value, $beginDate, $endDate)
    {
        $this->value = $value;
        $this->beginDate = $beginDate;
        $this->endDate = $endDate;
    }

    /**
     * @return string the iso code 2 of the country of the price
     */
    public function getIsoCountry()
    {
        return $this->country->getIsoCountry();
    }

    /**
     * To get a protected copy of a Discount instance
     * @return Discount a protected copy of the Discount instance
     */
    // public function getCopy()
    // {
    //     $copy = new Discount();
    //     $copy->value = $this->value;
    //     $copy->beginDate = $this->beginDate;
    //     $copy->endDate = $this->endDate;
    //     $copy->country = (!empty($this->country)) ? $this->country->getCopy() : null;
    //     return $copy;
    // }

    public function __toString()
    {
        Helper::printLabelValue("value", $this->value);
        Helper::printLabelValue("beginDate", $this->beginDate);
        Helper::printLabelValue("endDate", $this->endDate);
        $this->country->__toString();
    }
}
