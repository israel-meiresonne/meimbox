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

    /**
     * The country where the discount is available
     * @var Country
     */
    private $country;

    function __construct()
    {
        $argv = func_get_args();
        switch (func_num_args()) {
            case 0:
                self::__construct0();
                break;
            case 5:
                self::__construct5($argv[0], $argv[1], $argv[2], $argv[3], $argv[4]);
                break;
        }
    }

    private function __construct0()
    {
    }

    private function __construct5($value, $beginDate, $endDate, $countryName, $dbMap)
    {
        $this->value = $value;
        $this->beginDate = $beginDate;
        $this->endDate = $endDate;
        $this->country = new Country($countryName, $dbMap);
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
    public function getCopy()
    {
        $copy = new Discount();
        $copy->value = $this->value;
        $copy->beginDate = $this->beginDate;
        $copy->endDate = $this->endDate;
        $copy->country = (!empty($this->country)) ? $this->country->getCopy() : null;
        return $copy;
    }

    public function __toString()
    {
        Helper::printLabelValue("value", $this->value);
        Helper::printLabelValue("beginDate", $this->beginDate);
        Helper::printLabelValue("endDate", $this->endDate);
        $this->country->__toString();
    }
}
