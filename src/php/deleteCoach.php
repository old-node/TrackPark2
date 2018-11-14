<?php
/**************************************************************************************
Fichier :       deleteCoach.php
Auteur :        Olivier Lemay Dostie
Fonctionnalité : Supprime un évaluteur du système.
Date :          26 avril 2018
=======================================================================================
Vérification :
Date        Nom                     Approuvé
=======================================================================================
Historique de modification :
Date        Nom                     Description
2018-05-06  Olivier Lemay Dostie    Création
**************************************************************************************/

include_once 'AuthenticationManager.class.php';
include_once 'PermissionHelper.php';
include_once 'RequestUtil.php';
session_start_if_not_started();
if(!isLoggedInUserAdmin()) {
    header("Location: login.php?rd=" . getPath());
    return;
}

include_once 'RequestUtil.php';
include_once 'CoachManager.class.php';

if (isPost()) {
    if(isPostSetAndNotEmpty('id')) {
        CoachManager::removePerson($_POST['id']);
    }
    header("Location: UIWCoachManager.php");
    return;
}