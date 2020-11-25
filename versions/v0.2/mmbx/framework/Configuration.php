<?php

/**
 * Classe de gestion des paramètres de configuration.
 * Inspirée du SimpleFramework de Frédéric Guillot
 * (https://github.com/fguillot/simpleFramework)
 *
 */
class Configuration
{

    /** Tableau des paramètres de configuration */
    // rnvs : tableau associatif : clé == clé dans fichier ini, 
    //                             valeur == valeur dans fichier ini 
    private static $parameters;

    /**
     * Holds datas.json
     */
    private static $json;

    /**
     * Holds available environement files
     * @var string
     */
    public const ENV_DEV = "dev.ini";
    public const ENV_PROD = "prod.ini";

    /**
     * Keys to acces datas
     */
    public const DOMAIN = "domain";
    public const URL_DOMAIN = "url_domain";

    /**
     * Keys for Stripe datas
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
     * Keys for SendinBlue datas
     */
    public const SENDINBLUE_APIK = "sendinblue_apik";

    /**
     * Keys for Facebook datas
     * @var string
     */
    public const FB_PIXEL_ID = "facebook_pixel_id";

    /**
     * Keys for json datas
     */
    public const JSON_KEY_COMPANY = "company";
    public const JSON_KEY_MAILING = "mailing";
    public const JSON_KEY_SYSTEM = "system";
    public const JSON_KEY_CONSTANTS = "constants";

    /**
     * Renvoie la valeur d'un paramètre de configuration
     * 
     * @param string $name Nom du paramètre
     * @param string $defaultValue Valeur à renvoyer par défaut
     * @return string Valeur du paramètre
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
     * Renvoie le tableau des paramètres en le chargeant au besoin depuis un fichier de configuration.
     * Les fichiers de configuration recherchés sont config/dev.ini et config/prod.ini (dans cet ordre)
     * 
     * @return array Tableau des paramètres
     * @throws Exception Si aucun fichier de configuration n'est trouvé
     */
    private static function getParameters()
    {
        if (self::$parameters == null) {
            $filePath = "config/dev.ini";
            // rnvs : https://www.php.net/manual/en/function.file-exists.php
            if (!file_exists($filePath)) {
                $filePath = "config/prod.ini";
            }
            if (!file_exists($filePath)) {
                throw new Exception("Aucun fichier de configuration trouvé");
            }
            // rnvs : https://www.php.net/manual/en/function.parse-ini-file
            //        parse_ini_file() retourne un tableau associatif
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
     * To get datas from datas.json
     * @param string $name the name of the key to get datas from
     * @param boolean $inStd set true to convert json into stdClass else its will return an array
     * @return array|stdClass datas from datas.json
     */
    public static function getFromJson($name, $inStd = false)
    {
        (!isset(self::$json)) ? self::$json = file_get_contents('config/datas.json') : null;
        $inJson = !$inStd;
        $parsed = json_decode(self::$json, $inJson);
        if($inJson && (!key_exists($name, $parsed))){
            throw new Exception("This key '$name' don't exist in datas.json");
        }
        if($inStd && (!property_exists($parsed, $name))){
            throw new Exception("This propterty '$name' don't exist in datas.json");
        }
        $datas = ($inStd)  ? $parsed->$name : $parsed[$name];
        return $datas;
    }

    /**
     * To get the name of the config file of the environement
     * @return string the name of the config file of the environement
     */
    public static function getEnvironement()
    {
        $files = scandir('config', 1);
        $index = array_search(self::ENV_DEV, $files);
        if(!is_bool($index)){
            return $files[$index];
        }
        $index = array_search(self::ENV_PROD, $files);
        if(!is_bool($index)){
            return $files[$index];
        }
        throw new Exception("This environement is not supported");
    }
}
