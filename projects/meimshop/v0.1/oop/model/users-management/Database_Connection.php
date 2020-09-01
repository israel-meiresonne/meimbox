<?php
class Database_Connection
{
    private static $dbHost = "localhost";
    private static $dbName = "meimbox";
    private static $dbUsername = "root";
    private static $dbUserpassword = "root";

    // private static $dbHost = "iandmeimetwebmas.mysql.db";
    // private static $dbName = "iandmeimetwebmas";
    // private static $dbUsername = "iandmeimetwebmas";
    // private static $dbUserpassword = "Allurehomme0030";
    
    private static $connection = null;
    
    public static function connect()
    {
        if(self::$connection == null)
        {
            try
            {
              self::$connection = new PDO("mysql:host=" . self::$dbHost 
              . ";dbname=" . self::$dbName , self::$dbUsername, self::$dbUserpassword);
            }
            catch(PDOException $e)
            {
                die($e->getMessage());
            }
        }
        return self::$connection;
    }
    
    public static function disconnect()
    {
        self::$connection = null;
    }

}
?>
