<?php
require_once 'Configuration.php';

/**
 * This class manage $_SESSION access
 */
class Session
{
    /**
     * Constructor
     */
    public function __construct()
    {
        session_start();
    }

    /**
     * To destroy session
     */
    public function destroy()
    {
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
     * To get value in $_SESSION with the given key
     *
     * @param string $key access key
     * @return string|null value with the given key
     */
    public function get($key)
    {
        return (isset($_SESSION[$key])) && ($_SESSION[$key] != "") ? $_SESSION[$key] : null;
    }
}
