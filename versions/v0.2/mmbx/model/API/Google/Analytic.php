<?php
require_once 'model/ModelFunctionality.php';

/**
 * This class is used to manage features of Google Analytic's API
 */
class Analytic extends ModelFunctionality
{
    /**
     * Holds Google's measure ID
     * @var string
     */
    private const TAG_ID = "G-9NZD679DX8";

    /**
     * To get Google Analytic's base code
     * @return string Google Analytic's base code
     */
    public static function getBaseCode()
    {
        $env = Configuration::getEnvironement();
        $tagID = ($env == Configuration::ENV_PROD) ? self::TAG_ID : Configuration::get(Configuration::GOOGLE_MEASURE_ID);
        return self::generateFile('model/API/Google/files/analyticBaseCode.php', ["tagID" => $tagID]);
    }
}
