<?php
// require_once 'boxes-management/DiscountCode.php';

class Discount extends ModelFunctionality
{
    /**
     * Rate of the discount between 0 and 1 ([0,1])
     * @var float
     */
    protected $rate;

    /**
     * Date of the begin of the discount into format YYYY-MM-DD HH:MM:SS
     * @var string
     */
    protected $beginDate;

    /**
     * Date of the end of the discount into format YYYY-MM-DD HH:MM:SS
     * @var string
     */
    protected $endDate;

    public function __construct($rate, $beginDate, $endDate)
    {
        $this->rate = $rate;
        $this->beginDate = $beginDate;
        $this->endDate = $endDate;
    }

    /**
     * To get Discount's discount rate
     * @return string Discount's discount rate
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * To get Discount's begin date of availability
     * @return string Discount's begin date of availability
     */
    protected function getBeginDate()
    {
        return $this->beginDate;
    }

    /**
     * To get Discount's end date of availability
     * @return string Discount's end date of availability
     */
    protected function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * To check if the discount code is available for usage
     * + check if current date is between the begin and end date of the DiscountCodedate
     * + check if number of use is over zero
     */
    public function isActive()
    {
        // $nbUse = $this->getNbUse();
        // $stillUsage = (is_null($nbUse) || ($nbUse > 0));
        // return ($stillUsage && $this->isBetween());
        return false;
    }

    /**
     * To get if time if between the begin and the end avalability date of the DiscountCode
     * @param int|null $time the time to compare
     *                  + if not given the current time will be used
     * @return bool true if the time if between else false
     */
    protected function isBetween(int $time = null)
    {
        $isBetween = true;
        $time = (isset($time)) ? $time : time();
        $beginDate = $this->getBeginDate();
        $endDate = $this->getEndDate();
        $beginUnix = strtotime($beginDate);
        $endUnix = strtotime($endDate);
        if (isset($beginDate) && isset($endDate)) {
            $isBetween = (($beginUnix <= $time) && ($time < $endUnix));
        } else if (isset($beginDate)) {
            $isBetween = ($beginUnix <= $time);
        } else if (isset($endDate)) {
            $isBetween = ($time < $endUnix);
        }
        return $isBetween;
    }
}
