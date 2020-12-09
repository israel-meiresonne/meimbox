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
}