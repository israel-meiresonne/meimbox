<?php
require_once 'model/ModelFunctionality.php';
require_once 'model/marketing/facebook/Pixel.php';
require_once 'model/special/Map.php';

class Facebook extends ModelFunctionality
{
    /**
     * Key to get catalog's file name from $_GET
     */
    public const FILE_CATALOG = "file_catalog";

    /**
     * To get pixel's base code
     * @return string pixel's base code
     */
    public static function getBaseCode()
    {
        return Pixel::getBaseCode();
    }

    /**
     * To get the Facebook pixel for the event given
     * @param string    $type       type of the Pixel ['tracker' | 'trackerCustom']
     * @param string    $event      the event accured
     * @param string    $datasMap   pixel's datas
     * @return string the Facebook pixel for the event given
     */
    public static function getPixel(string $type, string $event, Map $datasMap = null)
    {
        return Pixel::getPixel($type, $event, $datasMap);
    }

    /**
     * To generate and get a Facebook catalog of the given file
     * @param string $file file of the catalog to get
     * @return string Facebook catalog of the given file
     */
    public static function getCatalog(string $file)
    {
        ob_start();
        require "model/marketing/facebook/files/catalog/$file";
        echo ob_get_clean();
    }
}
