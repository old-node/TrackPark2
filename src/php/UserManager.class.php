<?php
/**************************************************************************************
Fichier :       UserManager.class.php
Auteur :        Antoine Gagnon
Fonctionnalité : Data Access Object utilisé pour aller chercher
 * les données d'un user dans la base de données.
Date :          2018-04-26
=======================================================================================
Vérification :
Date        Nom	                    Approuvé
2018-05-06  Olivier Lemay Dostie    Doit exclure l'épreuve avec
 * l'identifiant 0 dans le chargement, sinon OK.
=======================================================================================
Historique de modifications :
Date        Nom	                    Description
2018-04-29	Olivier Lemay Dostie    Merge update
=======================================================================================
**************************************************************************************/

include_once 'Exceptions.php';
include_once 'User.class.php';
include_once 'AuthenticationManager.class.php';
include_once 'SQLConnector.class.php';

/**
 * Classe UserManager
 */
class UserManager
{
    public static function removeUser(User $user) {
        self::removeUserByID($user->getId());
    }

    public static function removeUserByID(int $id) {
        $conn = SQLConnector::createConn();
        if ($stm = $conn->prepare("DELETE FROM user WHERE id = ?")) {
            $stm->bind_param("i", $id);
            $stm->execute();
        }
        $conn->close();
    }

    public static function removeUserByUsername(string $username) {
        $conn = SQLConnector::createConn();
        if ($stm = $conn->prepare("DELETE FROM user WHERE id = ?")) {
            $stm->bind_param("s", $username);
            $stm->execute();
        }
        $conn->close();
    }
}