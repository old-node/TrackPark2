<?php
/**
 * Classe SQLConnector.
 */
class SQLConnector
{
    private static $serverName = "localhost";   //nom du serveur SQL
    private static $username = "root";          //username pour se connecter
    private static $password ="";               //password pour se connecter
    private static $dbName ="trackpark";        //nom de la base de données

    public static function init($sn, $un, $pw, $dbn)
    {
        self::$serverName = $sn;
        self::$username = $un;
        self::$password = $pw;
        self::$dbName = $dbn;
    }
    /**
     * Création d'une connexion
     * @return mysqli
     */
    public static function createConn(): mysqli
    {
        $conn = new mysqli(self::$serverName, self::$username, self::$password, self::$dbName);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        mysqli_set_charset($conn,"utf8");
        return $conn;
    }
}