<?php

require_once 'Configuration.php';

/**
 * Abstract class template.
 * Centralizes database access services.
 * Uses PHP's PDO API.
 *
 */
abstract class Model
{
    /** 
     * PDO object for access to the DB Static therefore shared by all 
     * instances of derived classes
     */
    private static $db;

    /**
     * Execute a SQL query
     * 
     * @param string $sql SQL request
     * @param array $params Query parameters
     * @return PDOStatement Résultats de la requête
     */
    protected static function executeRequest($sql, $params = null)
    {
        if ($params == null) {
            $result = self::getDb()->query($sql);
        } else {
            $result = self::getDb()->prepare($sql);
            $result->execute($params);
        }
        return $result;
    }

    /**
     * Returns a database connection object, initializing the connection
     * if necessary
     * 
     * @return PDO PDO object for connection to the database
     */
    private static function getDb()
    {
        if (self::$db === null) {
            $dsn = Configuration::get("dsn");
            $login = Configuration::get("login");
            $pwd = Configuration::get("mdp");
            self::$db = new PDO(
                $dsn,
                $login,
                $pwd,
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
            );
        }
        return self::$db;
    }

}