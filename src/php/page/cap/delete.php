<?php
/**************************************************************************************
Fichier :       deleteCap.php
Auteur :        Antoine Gagnon
Fonctionnalité : Permet de supprimer un casquette.
Date :          28 avril 2018
=======================================================================================
Vérification :
Date        Nom                     Approuvé
2018-05-06  Olivier Lemay Dostie    Oui
=======================================================================================
Historique de modification :
Date        Nom                     Description
2018-04-28  Antoine Gagnon          Création
2018-04-28  Olivier Lemay Dostie    Versionnement pour merger
**************************************************************************************/

include_once './AuthenticationManager.class.php';
include_once './PermissionHelper.php';
include_once './RequestUtil.php';
session_start_if_not_started();
if(!isLoggedInUserAdmin()) {
    header("Location: login.php?rd=" . getPath());
    return;
}

include_once './RequestUtil.php';
include_once './Cap.class.php';

if (isPost()) {
    if(isPostSetAndNotEmpty('code')) {
        Cap::remove($_POST['code']);
    }

    header("Location: manageCap.php");
    return;
}