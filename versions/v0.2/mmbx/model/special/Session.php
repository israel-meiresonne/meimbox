<?php
require_once 'framework/Configuration.php';

/**
 * This class manage $_SESSION access
 */
class Session
{
    /**
     * Holds if session has been started
     */
    private static $isSet;
    /**
     * Constructor
     */
    public function __construct()
    {
        if(!isset(self::$isSet)){
            session_start();
            self::$isSet = true;
        }
    }

    /**
     * To destroy session
     */
    public function destroy()
    {
        session_unset(); 
        session_destroy();
    }

    /**
     * To set Session attribut
     *
     * @param string $key   access key
     * @param string $value value to set
     */
    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * To unset a Session value
     * @param string $key   access key
     */
    public function unset($key)
    {
        $_SESSION[$key] = null;
        unset($_SESSION[$key]);
    }

    /**
     * To get value in $_SESSION with the given key
     *
     * @param string $key access key
     * @return string|null value with the given key
     */
    public function get($key)
    {
        return (key_exists($key, $_SESSION)) && ($_SESSION[$key] !== "") ? $_SESSION[$key] : null;
    }
}
