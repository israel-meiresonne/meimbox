<?php

class Address {
    /**
     * @var string
     */
    private $address;
    
    /**
     * @var string
     */
    private $appartement;
    
    /**
     * @var string
     */
    private $province;
    
    /**
     * @var string
     */
    private $zipcode;
    
    /**
     * @var string
     */
    private $city;

    /**
     * @var Country
     */
    private $country;

    /**
     * @var string
     */
    private $phone;

    /**
     * Show if this address is the current one
     * @var boolean Set true if this the current address else false
     */
    private $isActive;
    
    /**
     * Holds de date of the registration of this addresse
     * @var string DATETIME into format "YYYY-MM-DD HH:MM:SS"
     */
    private $setDate;

    function __construct()
    {

    }

    public function __toString()
    {
        
        Helper::printLabelValue("address", $this->address);
        Helper::printLabelValue("appartement", $this->appartement);
        Helper::printLabelValue("province", $this->province);
        Helper::printLabelValue("zipcode", $this->zipcode);
        Helper::printLabelValue("city", $this->city);
        Helper::printLabelValue("country", $this->country);
        Helper::printLabelValue("phone", $this->phone);
        Helper::printLabelValue("isActive", $this->isActive);
        Helper::printLabelValue("setDate", $this->setDate);
    }
}