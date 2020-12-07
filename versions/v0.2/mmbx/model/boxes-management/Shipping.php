<?php

class Shipping extends Price
{
    /**
     * Holds delivery time in day 
     * @var int
     */
    protected $time;

    public function __construct(float $price, Currency $currency, int $time)
    {
        parent::__construct($price, $currency);
        $this->time = $time;
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
}
