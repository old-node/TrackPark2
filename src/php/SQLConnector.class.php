<?php
/**************************************************************************************
Fichier :       SQLConnector.class.php
Auteur :		Francis Forest
Fonctionallité : Classe qui permet la connexion à une base de donnée.
Date :          23 avril 2018
=======================================================================================
Vérification :
Date		Nom					    Approuvé
2018-05-06  Olivier Lemay Dostie    Oui
=======================================================================================
Historique de modification :
Date		Nom						Description
2018-04-23	Francis Forest          Création
2018-04-28	Antoine Gagnon          Mise par défaut des attributs
2018-04-29  Olivier Lemay Dostie    Ajout des commentaires et merge
**************************************************************************************/

/**
 * Classe SQLConnector.
 */
class SQLConnector
{
    private static $serverName = "localhost";                //nom du serveur SQL
    private static $username = "root";                  //username pour se connecter
    private static $password ="";                  //password pour se connecter
    private static $dbName ="trackpark";                    //nom de la base de données

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