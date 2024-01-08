<?php

/**
 * Configuration settings management class.
 * Inspired by Frédéric Guillot’s SimpleFramework
 *(https://github.com/fguillot/simpleFramework)
 */
class Configuration
{

    /** 
     * Configuration parameter table
     */
    private static $parameters;

    /**
     * Holds data.json
     */
    private static $json;

    /**
     * Holds available environement files
     * @var string
     */
    public const ENV_DEV = "dev.ini";
    public const ENV_PROD = "prod.ini";

    /**
     * Keys to access data
     */
    public const DOMAIN = "domain";
    public const URL_DOMAIN = "url_domain";

    /**
     * Keys for Stripe data
     */
    public const STRIPE_PK = "stripe_pk";
    public const STRIPE_SK = "stripe_sk";
    public const STRIPE_WEBHOOK = "stripe_webhook";

    public const DIR_STATIC_FILES = "dir_static_files";
    public const PATH_PRODUCT = "path_product";
    public const DIR_EMAIL_FILES = "dir_email_files";

    /**
     * Holds 
     */
    public const PATH_CSS = "path_css";
    public const PATH_JS = "path_js";
    public const PATH_BRAND = "path_brand";

    /**
     * Keys for SendinBlue data
     */
    public const SENDINBLUE_APIK = "sendinblue_apik";

    /**
     * Keys for Facebook data
     * @var string
     */
    public const FB_PIXEL_ID = "facebook_pixel_id";

    /**
     * Keys for Google data
     * @var string
     */
    public const GOOGLE_MEASURE_ID = "measure_id";

    /**
     * Keys for json data
     */
    public const JSON_KEY_COMPANY = "company";
    public const JSON_KEY_MAILING = "mailing";
    public const JSON_KEY_SYSTEM = "system";
    public const JSON_KEY_CONSTANTS = "constants";

    /**
     * Returns the value of a configuration parameter
     * 
     * @param string $name Parameter name
     * @param string $defaultValue Value to return by default
     * @return string Parameter value
     */
    public static function get($name, $defaultValue = null)
    {
        $parameters = self::getParameters();
        if (isset($parameters[$name])) {
            $value = $parameters[$name];
        } else {
            $value = $defaultValue;
        }
        return $value;
    }

    /**
     * Returns the parameters table, loading it if necessary from a configuration file.
     * The configuration files searched for are config/dev.ini and config/prod.ini (in that order)
     * 
     * @return array Parameter table
     * @throws Exception If no configuration file is found
     */
    private static function getParameters()
    {
        if (self::$parameters == null) {
            $filePath = "config/dev.ini";
            if (!file_exists($filePath)) {
                $filePath = "config/prod.ini";
            }
            if (!file_exists($filePath)) {
                throw new Exception("Aucun fichier de configuration trouvé");
            }
            self::$parameters = parse_ini_file($filePath);
        }
        return self::$parameters;
    }

    /**
     * To get webRoot
     * @return string the webRoot
     */
    public static function getWebRoot()
    {
        return self::get("webRoot", "/");
    }

    /**
     * To get data from data.json
     * @param string $name the name of the key to get data from
     * @param boolean $inStd set true to convert json into stdClass else its will return an array
     * @return array|stdClass data from data.json
     */
    public static function getFromJson($name, $inStd = false)
    {
        (!isset(self::$json)) ? self::$json = file_get_contents('config/data.json') : null;
        $inJson = !$inStd;
        $parsed = json_decode(self::$json, $inJson);
        if ($inJson && (!key_exists($name, $parsed))) {
            throw new Exception("This key '$name' don't exist in data.json");
        }
        if ($inStd && (!property_exists($parsed, $name))) {
            throw new Exception("This propterty '$name' don't exist in data.json");
        }
        $data = ($inStd) ? $parsed->$name : $parsed[$name];
        return $data;
    }

    /**
     * To get the name of the config file of the environement
     * @return string the name of the config file of the environement
     */
    public static function getEnvironement()
    {
        $files = scandir('config', 1);
        $index = array_search(self::ENV_DEV, $files);
        if (!is_bool($index)) {
            return $files[$index];
        }
        $index = array_search(self::ENV_PROD, $files);
        if (!is_bool($index)) {
            return $files[$index];
        }
        throw new Exception("This environement is not supported");
    }
}