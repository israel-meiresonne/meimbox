<?php
// require_once 'model/orders-management/payement/stripe/Coupon.php';

class StripeCoupon /* extends ModelFunctionality */
{
    /**
     * Holds contact with Stripe's api
     * @var \Stripe\StripeClient
     */
    private static $stripeAPI;

    /**
     * Holds Stripe's coupon instance
     * @var \Stripe\Coupon
     */
    private $coupon;

    /**
     * Unique string of your choice that will be used to identify this coupon 
     * when applying it to a customer. If you don’t want to specify a particular code.
     * + You can leave the ID blank and we’ll generate a random code for you.
     */
    private $id;    // ✅

    /**
     * Name of the coupon displayed to customers on, for instance invoices, 
     * or receipts.
     * + By default the id is shown if name is not set.
     */
    private $name;  // ✅

    /**
     * Specifies how long the discount will be in effect. 
     * + Can be 'forever', 'once', or 'repeating'
     * @var string
     */
    private $duration;  // ✅ => 'once'

    /**
     * A positive integer representing the amount to subtract from an invoice 
     * total 
     * + (required if percent_off is not passed)
     * @var int
     */
    private $amount_off;    // ✅

    /**
     * A positive float larger than 0, and smaller or equal to 100, that 
     * represents the discount the coupon will apply 
     * + (required if amount_off is not passed).
     */
    private $percent_off;

    /**
     * Holds currency for the amount_off
     * + (required if amount_off is passed).
     * @var Curency
     */
    private $currency;  // ✅

    /**
     * Required only if duration is repeating, in which case it must be a positive
     * integer that specifies the number of months the discount will be in effect.
     * + i.e.: $duration_in_months = 3 => 3 months
     * @var int
     */
    private $duration_in_months;

    /**
     * Set of key-value pairs that you can attach to an object.
     * + All keys can be unset by posting an empty value to metadata.
     * @var Map
     */
    private $metadata;

    public const DURATION_ONCE = "once";

    /**
     * Constructor
     */
    public function __construct(\Stripe\StripeClient $stripeAPI, Price $shipDiscount, Map $couponMap)
    {
        self::$stripeAPI = $stripeAPI;
        $this->id = $couponMap->get(Map::id);
        $this->name = $couponMap->get(Map::name);
        $this->duration = $couponMap->get(Map::duration);
        $this->amount_off = $shipDiscount->getPriceRounded() * 100;
        $this->currency = $shipDiscount->getCurrency();
    }

    /**
     * To get the access to Stripe's API
     * @return \Stripe\StripeClient access to Stripe's API
     */
    private function getStripeAPI()
    {
        return self::$stripeAPI;
    }

    /**
     * To get Coupon's id
     * @return string Coupon's id
     */
    public function getId(){
        return $this->id;
    }

    /**
     * To get Coupon's name
     * @return string Coupon's name
     */
    private function getName(){
        return $this->name;
    }

    /**
     * To get Coupon's duration
     * @return string Coupon's duration
     */
    private function getDuration(){
        return $this->duration;
    }

    /**
     * To get Coupon's amount_off
     * @return int Coupon's amount_off
     */
    private function getAmountOff(){
        return $this->amount_off;
    }

    /**
     * To get Coupon's currency
     * @return Currency Coupon's currency
     */
    private function getCurrency(){
        return $this->currency;
    }


    /**
     * To create a new Stripe coupon
     * @return  a Stripe coupon
     */
    public function create()
    {
        $stripeAPI = $this->getStripeAPI();
        $datas = [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'duration' => $this->getDuration(),
            'amount_off' => $this->getAmountOff(),
            'currency' => $this->getCurrency()->getIsoCurrency(),
        ];
        $this->coupon = $stripeAPI->coupons->create($datas);
    }
}
