<?php

class Action {
    private $page;
    private $setDate;
    private $action;
    private $on;
    private $onName;
    private $response;

    function __construct($page, $setDate, $action, $on, $onName, $response)
    {
        $this->page = $page;
        $this->setDate = $setDate;
        $this->action = $action;
        $this->on = $on;
        $this->onName = $onName;
        $this->response = $response;
    }

     /**
     * Convert setDate to seconde from UNIX.
     * @return int seconde from UNIX
     */
    public function getDateInSec(){
        return strtotime($this->setDate);
    }

    public function __toString()
    {
        
        Helper::printLabelValue("page", $this->page);
        Helper::printLabelValue("setDate", $this->setDate);
        Helper::printLabelValue("action", $this->action);
        Helper::printLabelValue("on", $this->on);
        Helper::printLabelValue("onName", $this->onName);
        Helper::printLabelValue("response", $this->response);
    }
}