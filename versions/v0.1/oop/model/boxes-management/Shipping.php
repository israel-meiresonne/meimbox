<?php

class Shipping extends Price{
    /**
     * Holds delivery time in day 
     * @var int
     */
    protected $time;
    
    function __construct($price, $countryName, $isoCurrency, $time, $dbMap)
    {
        parent::__construct($price, $countryName, $isoCurrency, $dbMap);
        $this->time = $time;
    }

    // public function __toString()
    // {
    //     parent::__toString();
    // }
}