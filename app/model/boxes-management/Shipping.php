<?php

class Shipping extends Price
{
    /**
     * Holds delivery's min time in day 
     * @var int
     */
    protected $minTime;

    /**
     * Holds delivery's max time in day 
     * @var int
     */
    protected $maxTime;

    /**
     * Holds the max time for Client to return order
     * @var int
     */
    private static $MAX_RETURN_DAYS;

    public function __construct(float $price, Currency $currency, int $minTime, int $maxTime)
    {
        parent::__construct($price, $currency);
        $this->minTime = $minTime;
        $this->maxTime = $maxTime;
    }

    /**
     * Initialize Shipping's constants
     */
    private static function setConstants()
    {
        if (!isset(self::$MAX_RETURN_DAYS)) {
            self::$MAX_RETURN_DAYS = "MAX_RETURN_DAYS";
            self::$MAX_RETURN_DAYS = (int) parent::getConstantLine(self::$MAX_RETURN_DAYS)["stringValue"];
        }
    }

    /**
     * To get Shipping's min time in day
     * @return int Shipping's min time in day
     */
    public function getMinTime()
    {
        return $this->minTime;
    }

    /**
     * To get Shipping's max time in day
     * @return int Shipping's max time in day
     */
    public function getMaxTime()
    {
        return $this->maxTime;
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
        $copy = new $class($this->price, $this->currency, $this->time);
        foreach ($attributs as $attribut) {
            $copy->{$attribut} = $this->{$attribut};
        }
        return $copy;
    }

    /**
     * To get max days that the Client is allowed return his order
     * @return int max days that the Client is allowed return his order
     */
    public static function getMaxReturnDays()
    {
        (!isset(self::$MAX_RETURN_DAYS))? self::setConstants() : null;
        return self::$MAX_RETURN_DAYS;
    }
}
