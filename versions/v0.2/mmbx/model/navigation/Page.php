<?php
require_once 'model/ModelFunctionality.php';

/**
 * This class represente a web page visited by the Visitor
 */
class Page extends ModelFunctionality
{
    /**
     * Holds Page's url
     * i.e.: https://my.domain.com/my/webroot/my/path?my=param
     * @var string
     */
    private $url;

    /**
     * Holds Page's web root
     * i.e.: /my/webroot/
     * Note: begin and end with slash
     * @var string
     */
    private static $webroot;

    /**
     * Holds Page's path
     * i.e.: my/path?my=param
     * Note: don't begin with slash
     * @var string
     */
    private $path;
    
    /**
     * Holds url's $_GET parameters
     * @var string[]
     */
    private $params;
    
    /**
     * Holds the time that the Visitor spent on the Page in second
     * @var int
     */
    private $timeOn;
        
    /**
     * Holds the date Visitor visited this Page
     * @var string
     */
    private $setDate;

    /**
     * Holds Visitor's behavior on the Page
     * + Note: Action are ordered from new to hold
     * @var Action[]
     */
    private $actions;

    /**
     * Constructor
     * @param $minTime   min time in second from today to get history in database
     * @param $maxTime   max time in second from today to get history in database
     */
    function __construct()
    {
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
}
