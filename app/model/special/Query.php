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
        // return (key_exists($key, self::$params)) && (!empty(self::$params[$key]));
        // return (key_exists($key, self::$params)) && (isset(self::$params[$key])) && (self::$params[$key] != "");
        return (key_exists($key, self::$params)) && (self::$params[$key] !== "");
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
    public static function getParamsRegex($regex)
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
     * Clean data of all indesirable characteres
     * @param string $data data to clean
     * @return string data cleaned
     */
    private static function clean($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        $data = strip_tags($data);
        $data = addslashes($data);
        // $data = html_entity_decode($data); // ❗️Don't Uncomment in production
        return $data;
    }
}
