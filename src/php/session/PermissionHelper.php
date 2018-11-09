<?php
/**************************************************************************************
Fichier :       PermissionHelper
Auteur :        Antoine Gagnon
Fonctionnalité : boite à outils pour facilité la vérification des permissions
Date :          2018-04-26
=======================================================================================
Vérification :
Date		Nom					    Approuvé
2018-05-06  Olivier Lemay Dostie    Oui
=======================================================================================
Historique de modification :
Date		Nom						Description
2018-04-26	Antoine Gagnon          Création
2018-04-29  Olivier Lemay Dostie    Versionnement et merge
**************************************************************************************/

define('ADMIN_LEVEL', 255);

include_once 'User.class.php';
include_once 'UserType.class.php';
include_once 'SessionUtil.php';
include_once 'AuthenticationManager.class.php';

function isAdmin($level): bool {
    return $level === ADMIN_LEVEL;
}

function isUserAdmin(User $user): bool {
    if(is_null($user)) {
        return false;
    }

    return isAdmin($user->getUserType()->getPermissionLevel());
}

function isLoggedInUserAdmin(): bool {
    session_start_if_not_started();
    $user = AuthenticationManager::getLoggedInUser();
    if(is_null($user)) {
        return false;
    }
    return isUserAdmin($user);
}