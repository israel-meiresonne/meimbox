<?php

class Page
{
    
    /**
     * @var string
     */
    private $page;
    
    /**
     * @var string
     */
    private $setDate;
    
    /**
     * Time (second) passed on a web page
     * @var int
     */
    private $timeOn;
    
    /**
     * @var Parameters
     */
    private $parameters;

    /**
     * @param string $page
     * @param string $setDate
     * @param int $page
     */
    function __construct($page, $setDate, $timeOn)
    {
        $this->page = $page;
        $this->setDate = $setDate;
        $this->timeOn = $timeOn;
        $this->parameters = [];
    }

    private function getSetDate(){
        return $this->setDate;
    }

    /**
     * Convert setDate to seconde from UNIX.
     * @return int seconde from UNIX
     */
    public function getDateInSec(){
        return strtotime($this->setDate);
    }

    /**
     * Add new parameter in $this->parameters in format $key => $value.
     * @param string $key
     * @param string $data
     */
    public function addParam($key, $data){
        // $this->parameters[$key] = $data;
        $parameter = new Parameter($key, $data);
        array_push($this->parameters, $parameter);
    }

    public function __toString()
    {
        
        Helper::printLabelValue("page", $this->page);
        Helper::printLabelValue("setDate", $this->setDate);
        Helper::printLabelValue("timeOn", $this->timeOn);
        Helper::printLabelValue("parameters", $this->parameters);
    }





}
