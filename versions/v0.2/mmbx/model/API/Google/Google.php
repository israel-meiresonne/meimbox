<?php
require_once 'model/ModelFunctionality.php';
require_once 'model/API/Google/Analytic.php';

/**
 * This class represent a Facade to wrap Google API's features
 */
class Google extends ModelFunctionality
{
    /**
     * To get Google Analytic's base code
     * @return string Google Analytic's base code
     */
    public static function getBaseCode()
    {
        return Analytic::getBaseCode();
    }

    /**
     * To get Analytic's event code corresponding to the given event
     * @param string    $event      an event's name
     * @param Map    $datasMap   event's datas
     * @return string event code of the given event
     */
    public static function getEvent(string $event, Map $datasMap = null)
    {
        return Analytic::getEvent($event, $datasMap);
    }
}
