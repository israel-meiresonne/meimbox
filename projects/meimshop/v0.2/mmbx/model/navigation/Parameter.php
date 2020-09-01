<?php

class Parameter {
    
    /**
     * @var strring
     */
    private $param_key;
    
    /**
     * @var strring
     */
    private $param_data;

    function __construct($param_key, $param_data)
    {
        $this->param_key = $param_key;
        $this->param_data = $param_data;
    }

    public function __toString()
    {
        
        Helper::printLabelValue("param_key", $this->param_key);
        Helper::printLabelValue("param_data", $this->param_data);
    }
}