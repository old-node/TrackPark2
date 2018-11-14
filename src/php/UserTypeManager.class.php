<?php
/**************************************************************************************
Fichier :       UserTypeManager.class.php
Auteur :        Antoine Gagnon
Fonctionnalité : Gère les types d'utilisateur
Date :          2018-04-26
=======================================================================================
Vérification :
Date        Nom	                    Approuvé
2018-05-06  Olivier Lemay Dostie    Oui
=======================================================================================
Historique de modifications :
Date        Nom	                    Description
2018-04-29	Olivier Lemay Dostie    Merge update
=======================================================================================
 **************************************************************************************/

include_once 'AuthenticationManager.class.php';
include_once 'UserType.class.php';
include_once 'SQLConnector.class.php';

/**
 * Classe UserTypeManager
 */
class UserTypeManager
{
    public static function removeUserType($id) {
        $conn = SQLConnector::createConn();
        if ($stm = $conn->prepare("DELETE FROM user_type WHERE id = ?")) {
            $stm->bind_param("i", $id);
            $stm->execute();
        }
        $conn->close();
        return null;
    }
}