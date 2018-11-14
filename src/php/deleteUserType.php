<?php
/**************************************************************************************
Fichier :       deleteUserType.php
Auteur :        Antoine Gagnon
Fonctionnalité : Supprime un type d'utilisateur du système.
Date :          26 avril 2018
=======================================================================================
Vérification :
Date        Nom                     Approuvé
2018-05-06  Olivier Lemay Dostie    Oui
=======================================================================================
Historique de modification :
Date        Nom                     Description
2018-04-26  Antoine Gagnon          Création
2018-04-28  Olivier Lemay Dostie    Versionnement pour merger
 **************************************************************************************/

include_once 'UserTypeManager.class.php';

include_once 'SessionUtil.php';
include_once 'PermissionHelper.php';
include_once 'RequestUtil.php';
session_start_if_not_started();
if(!isLoggedInUserAdmin()) {
    header("Location: login.php?rd=" . getPath());
    return;
}


if (isPost()) {

    if(isPostSetAndNotEmpty('id')) {
        UserTypeManager::removeUserType($_POST['id']);
    }

    header("Location: manageUserType.php");
    return;
}