<?php

/**
 * Provide a access to cleaned value of superglobal $_GET and $_POST
 */
class Query
{
    private static $isset = false;

    /**
     * Holds values of the super global $_GET & $_POST
     * @var string
     */
    private static $params;

    // /**
    //  * Holds the super global $_GET
    //  * @var string
    //  */
    // private static $GET;

    // /**
    //  * Holds the super global $_POST
    //  * @var string
    //  */
    // private static $POST;

    // /**
    //  * Holds the method of the query
    //  * @var string
    //  */
    // const GET_MOTHOD = "GET";

    // /**
    //  * Holds the method of the query
    //  * @var string
    //  */
    // const POST_MOTHOD = "POST";

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

    // /**
    //  * To get cleanned value from $_POST at specified key
    //  * @param string $key key value from $_POST
    //  * @return string cleanned value from $_POST
    //  */
    // public static function POST($key)
    // {
    //     (!self::$isset) ? self::setQuery() : null;
    //     return self::clean(self::$POST[$key]);
    // }

    // /**
    //  * Check if the key value exist in $_POST and contain a value different 
    //  * than ""
    //  * @param string $key key value from $_POST
    //  * @return boolean true if key contain a value different than "" else false
    //  */
    // public static function paramExistPOST($key)
    // {
    //     (!self::$isset) ? self::setQuery() : null;
    //     return (isset(self::$POST[$key])) && (!empty(self::$POST[$key]));
    // }

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
}
