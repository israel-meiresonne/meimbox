<?php
require_once 'model/ModelFunctionality.php';

/**
 * This class is used as facade to manage and track Visitor's navigation
 */
class Navigation extends ModelFunctionality
{
    /**
     * Holds pages visited by the Visitor
     * + Note: Pages are ordered from new to hold
     * @var Page[]
     */
    private $pages;

    /**
     * Holds devices used by the Visitor
     * + Note: Device are ordered from new to hold
     * @var Device[]
     */
    private $devices;

    /**
     * Holds Visitor's locations
     * + Note: Location are ordered from new to hold
     * @var Location[]
     */
    private $locations;

    /**
     * Holds min time in second from today to get history in database
     * @var int
     */
    private $minTime;
    
    /**
     * Holds max time in second from today to get history in database
     * @var int
     */
    private $maxTime;

    /**
     * Constructor
     * @param $minTime   min time in second from today to get history in database
     * @param $maxTime   max time in second from today to get history in database
     */
    public function __construct(int $minTime = null, int $maxTime = null)
    {
        
    }

}
