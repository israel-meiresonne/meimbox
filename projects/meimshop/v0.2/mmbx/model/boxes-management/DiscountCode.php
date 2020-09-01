<?php

class DiscountCode
{
    /**
     * Code of the discount
     * @var string
     */
    private $discountCode;

    /**
     * Date and hour of the creation of the discount code into format YYYY-MM-DD HH:MM:SS
     * @var string
     */
    private $setDate;

    /**
     * Indicate how the discount have to be treated
     * @var string
     */
    private $discountType;

    /**
     * Holds the value of the discount.
     * The value is between 0 and 1 ([0,1])
     * @var double
     */
    private $value;

    /**
     * Holds the minimal subtotal of the basket for the code work
     * @var double
     */
    private $minAmount;

    /**
     * Holds the limise of use of the code in an order before the code become inactive.
     * If the $nbUse = null there is any limite of use.
     * @var int
     */
    private $nbUse;

    /**
     * Indicate if an code can be used with other code
     * @var boolean
     */
    private $isCombinable;

    /**
     * List of available date for each country.
     * Use country as access key like $dates = [iso_country => ["beginDate"=>string, "endiDate"=>string]]
     * @var string[]
     */
    private $dates;

    /**
     * Liste of country where the code is available.
     * This code can work in a country witch is not inside. 
     * @var Country[] $countries like $countries = [iso_country => Country]
     */
    private $countries;


    function __construct()
    {
        $argv = func_get_args();
        switch (func_num_args()) {
            case 0:
                self::__construct0();
                break;
            case 2:
                self::__construct2($argv[0], $argv[1]);
                break;
        }
    }

    private function __construct0()
    {
    }

    private function __construct2($code, $dbMap)
    {
        $discount = $dbMap["discountCodeMap"][$code];
        $this->discountCode = $code;
        $this->setDate = $discount["setDate"];
        $this->discountType = $discount["discount_type"];
        $this->value = $discount["value"];
        $this->minAmount = $discount["minAmount"];
        $this->nbUse = $discount["nbUse"];
        $this->isCombinable = $discount["isCombinable"];
        self::initCountriesDates($discount["availableCountries"], $dbMap);
    }

    private function initCountriesDates($availableCountries, $dbMap)
    {
        foreach ($availableCountries as $countryName => $beginEndDate) {
            $country = new Country($countryName, $dbMap);
            $iso_country = $country->getIsoCountry();
            $this->countries[$iso_country] = $country;
            $this->dates[$iso_country] = $beginEndDate;  // ["beginDate"=>string, "endiDate"=>string]]
        }
    }

    /**
     * Change the value of the attribute $discountCode with the value passed in param
     * @param string $discountCode
     */
    private function setDiscountCode($discountCode)
    {
        $this->discountCode = $discountCode;
    }

    /**
     * Change the value of the attribute $setDate with the value passed in param
     * @param string $setDate
     */
    private function setSetDate($setDate)
    {
        $this->setDate = $setDate;
    }

    /**
     * Change the value of the attribute $discountType with the value passed in param
     * @param string $discountType
     */
    private function setDiscountType($discountType)
    {
        $this->discountType = $discountType;
    }

    /**
     * Change the value of the attribute $value with the value passed in param
     * @param double $value
     */
    private function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Change the value of the attribute $minAmount with the value passed in param
     * @param double $minAmount
     */
    private function setMinAmount($minAmount)
    {
        $this->minAmount = $minAmount;
    }

    /**
     * Change the value of the attribute $nbUse with the value passed in param
     * @param int $nbUse
     */
    private function setNbUse($nbUse)
    {
        $this->nbUse = $nbUse;
    }

    /**
     * Change the value of the attribute $isCombinable with the value passed in param
     * @param boolean $isCombinable
     */
    private function setIsCombinable($isCombinable)
    {
        $this->isCombinable = $isCombinable;
    }

    /**
     * Change the value of the attribute $dates with the value passed in param
     * @param string[] $dates like $dates = [iso_country => ["beginDate"=>string, "endiDate"=>string]]
     */
    private function setDates($dates)
    {
        $this->dates = $dates;
    }

    /**
     * Change the value of the attribute $countries with the value passed in param
     * @param  Country[] $countries like $countries = [iso_country => Country]
     */
    private function setCountries($countries)
    {
        $this->countries = $countries;
    }

    /**
     * @return BasketProduct[] a protected copy of the $basketProduct attribute
     */
    public function getCopyCountries()
    {
        $copy = [];
        foreach ($this->countries as $iso_country => $country) {
            $copy[$iso_country] = $country->getCopy();
        }
        return $copy;
    }


    /**
     * To get a protected copy of a DiscountCode instance
     * @return DiscountCode a protected copy of the DiscountCode instance
     */
    public function getCopy()
    {
        $copy = new DiscountCode();
        $copy->discountCode = $this->discountCode;
        $copy->setDate = $this->setDate;
        $copy->discountType = $this->discountType;
        $copy->value = $this->value;
        $copy->minAmount = $this->minAmount;
        $copy->nbUse = $this->nbUse;
        $copy->isCombinable = $this->isCombinable;
        $copy->dates = $this->dates;
        $copy->countries = $this->getCopyCountries();
        return $copy;
    }


    public function __toString()
    {
        Helper::printLabelValue("discountCode", $this->discountCode);
        Helper::printLabelValue("setDate", $this->setDate);
        Helper::printLabelValue("discountType", $this->discountType);
        Helper::printLabelValue("value", $this->value);
        Helper::printLabelValue("minAmount", $this->minAmount);
        Helper::printLabelValue("nbUse", $this->nbUse);
        Helper::printLabelValue("isCombinable", $this->isCombinable);
        Helper::printLabelValue("dates", $this->dates);
    }
}
