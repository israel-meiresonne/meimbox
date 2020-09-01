<?php

class Shipping extends Price{
    /**
     * Holds delivery time in day 
     * @var int
     */
    protected $time;
    
    public function __construct($price, $currency, $time)
    {
        parent::__construct($price, $currency);
        $this->time = $time;
    }
}