<?php
require_once 'model/boxes-management/Discount.php';

class DiscountCode extends Discount
{
    /**
     * Holds the  discount code
     * @var string
     */
    private $code;

    /**
     * Holds indication of how the discount have to be treated
     * @var string
     */
    private $type;

    /**
     * Holds the minimal amount that the total amount have to  be tto be able 
     * to use the DiscountCode
     * @var float
     */
    private $minAmount;

    /**
     * Holds the maximum amount that can be deducted from a total amount
     * + Note: combine this attribut with a rate of 1 to make a discount of a certain amount
     * @var float
     */
    private $maxAmount;

    /**
     * Holds the limise of use of the code in an order before the code become inactive.
     * If the $nbUse = null there is any limite of use.
     * @var int
     */
    private $nbUse;

    /**
     * Indicate if an code can be used with other code
     * @var bool
     */
    private $isCumulable;

    /**
     * Holds the date of when the code have been added in Basket
     * @var string
     */
    private $setDate;

    public const TYPE_SUM_PRODS = "on_sum_prods";
    public const TYPE_SHIPPING = "on_shipping";

    /**
     * Constructor
     * @param string    $userID     Visitor's id
     * @param string    $disCode    the discount code to retrieve from database
     * @param string    $setDate    add date of the discount countt in Visitor's Basket
     */
    public function __construct(string $code, Country $country, $setDate = null)
    {
        $countryName = $country->getCountryName();
        $sql = "SELECT *
                FROM `DiscountCodes` d
                JOIN `DiscountCodes-Countries` dc ON d.`discountCode`=dc.`discount_code`
                WHERE d.`discountCode`='$code' AND dc.`country_`='$countryName'";
        $tab = parent::select($sql);
        if (empty($tab)) {
            throw new Exception("This discount code '$code' don't exist for this country '$countryName'");
        }
        $tabLine = $tab[0];
        $this->code = $tabLine["discountCode"];
        $this->type = $tabLine["discount_type"];
        $this->rate = (float) $tabLine["rate"];
        $maxAmount = $tabLine["maxAmount"];
        $this->maxAmount =  (isset($maxAmount)) ? (float) $maxAmount : null;
        $this->minAmount = (float) $tabLine["minAmount"];
        $nbUse = $tabLine["nbUse"];
        $this->nbUse = (isset($nbUse)) ? (int) $nbUse : null;
        $this->isCumulable = (bool) $tabLine["isCumulable"];
        $this->beginDate = $tabLine["beginDate"];
        $this->endDate = $tabLine["endDate"];
        $this->setDate = (!empty($setDate)) ? $setDate : $this->getDateTime();
    }

    /**
     * To get DiscountCode's type
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * To get DiscountCode's max amount of availability
     * @return float DiscountCode's max amount of availability
     */
    public function getMaxAmount()
    {
        return $this->maxAmount;
    }

    /**
     * To get DiscountCode's min amount of availability
     * @return float DiscountCode's min amount of availability
     */
    public function getMinAmount()
    {
        return $this->minAmount;
    }

    /**
     * To get DiscountCode's number of use available
     * @return int DiscountCode's number of use available
     */
    private function getNbUse()
    {
        return $this->nbUse;
    }

    /**
     * To get if the discount code is cummulable with other discount
     * + other discount include Discount on Product and DiscountCode on Basket
     * @return bool true if the discount code is cumulable else false
     */
    public function isCumulable()
    {
        return $this->isCumulable;
    }

    /**
     * To check if the discount code is available for usage
     * + check if current date is between the begin and end date of the DiscountCodedate
     * + check if number of use is over zero
     */
    public function isActive()
    {
        $nbUse = $this->getNbUse();
        $stillUsage = (is_null($nbUse) || ($nbUse > 0));
        return ($stillUsage && $this->isBetween());
    }
}
