<?php

/**
 * Provide a access to cleaned value of superglobal $_GET and $_POST
 */
class Query
{
    private static $isset = false;

    /**
     * Holds values of the super global $_GET & $_POST
     * @var string[]
     */
    private static $params;

    /**
     * Holds the input type
     */
    const CHECKBOX = "checckbox";
    const PSEUDO = "pseudo";
    const NAME = "name";  // handle space and `-`
    const EMAIL = "email";
    const PHONE_NUMBER = "phone";
    const PASSWORD = "psw";
    const BOOLEAN_TYPE = "boolean";
    const STRING_TYPE = "string";
    const NUMBER_FLOAT = "float";
    const NUMBER_INT = "int";
    const ALPHA_NUMERIC = "alpha_numeric";

    const FLOAT_REGEX = "#(^0{1}$)|(^0{1}[.,]{1}[0-9]+$)|(^[1-9]+[0-9]*[.,]?[0-9]*$)#";
    const STRING_REGEX = "#^[a-zA-Z]+$#";
    const PSEUDO_REGEX = "#^[a-zA-Z]+[a-zA-Z0-9-_ ]*$#";
    const PALPHA_NUMERIC_REGEX = "#^[a-zA-Z0-9]+$#";

    /**
     * Constructor
     */
    private static function setQuery()
    {
        (!isset(self::$params)) ? self::$params = array_merge($_GET, $_POST) : null;
        self::$isset = true;
    }

    /**
     * Check if the key value exist in $_GET or $_POST and contain a value different 
     * than ""
     * @param string $key key value from $_GET or $_POST
     * @return boolean true if key contain a value different than "" else false
     */
    public static function existParam($key)
    {
        (!self::$isset) ? self::setQuery() : null;
        return (key_exists($key, self::$params)) && (!empty(self::$params[$key]));
    }

    /**
     * To get cleanned value from $_GET or $_POST at specified key
     * @param string $key key value from $_GET or $_POST
     * @return string cleanned value from $_GET or $_POST
     */
    public static function getParam($key)
    {
        (!self::$isset) ? self::setQuery() : null;
        return (self::existParam($key)) ? self::clean(self::$params[$key]) : null;
    }

    /**
     * To get map of cleanned params from $_GET or $_POST where key match a regular expression
     * @param string $key key value from $_GET or $_POST
     * @param string $regex a regular expression
     * @return string[] cleanned value from $_GET or $_POST that match the regular expression
     */
    public static function getRegexParams($regex)
    {
        (!self::$isset) ? self::setQuery() : null;
        $map = [];
        foreach (self::$params as $key => $param) {
            if (preg_match($regex, $key) == 1) {
                $map[$key] = self::clean($param);
            }
        }
        return $map;
    }

    /** 
     * Clean inputs, GET inputs and POST inputs of all indesirable characteres
     * @param string $data the value to clean
     * @return string cleaned value of the value passed in param
     */
    private static function clean($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    /**
     * Convert data in params into the correct format
     * @param string $dataType the type to convert data to
     * @param string $key access key to get data from param list
     */
    public static function convertParam($dataType, $key)
    {
        if (self::existParam($key)) {
            switch ($dataType) {
                case ModelFunctionality::NUMBER_FLOAT:
                    $value = self::getParam($key);
                    self::$params[$key] = (float) str_replace(",", ".", $value);
                    break;
                case ModelFunctionality::PSEUDO|ModelFunctionality::ALPHA_NUMERIC|ModelFunctionality::STRING_TYPE:
                    $value = self::getParam($key);
                    self::$params[$key] = strtolower($value);
                    break;
            }
        }
    }
}
