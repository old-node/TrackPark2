<?php
/**************************************************************************************
Fichier :       deleteUser.php
Auteur :        Antoine Gagnon
Fonctionnalité : Supprime un utilisateur du système.
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

include_once 'SessionUtil.php';
include_once 'PermissionHelper.php';
include_once 'RequestUtil.php';
session_start_if_not_started();
if(!isLoggedInUserAdmin()) {
    header("Location: login.php?rd=" . getPath());
    return;
}

include_once 'UserManager.class.php';
include_once 'RequestUtil.php';

if (isPost()) {

    if(isPostSetAndNotEmpty('id')) {
        UserManager::removeUserByID($_POST['id']);
    }

    header("Location: manageUsers.php");
    return;
}