<?php
/**************************************************************************************
Fichier :       SessionUtil.php
Auteur :        Antoine Gagnon
Fonctionnalité : Fonctions utilitaires à l'authentification par plage
Date :          2018-04-28
=======================================================================================
Vérification :
Date		Nom					    Approuvé
2018-05-06  Olivier Lemay Dostie    Oui
=======================================================================================
Historique de modification :
Date		Nom						Description
2018-04-23	Francis Forest          Création
2018-04-28	Antoine Gagnon          Mise par défaut des attributs
2018-04-29  Olivier Lemay Dostie    Versionnement du merge
**************************************************************************************/

function session_start_if_not_started() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
}

function showSessionInfo() {
    session_start_if_not_started();
    echo '<div style="position: fixed; bottom: 0;">Connecté en tant que <b>' . $_SESSION["user"] . '</b> a partire de ' .$_SESSION["ip"].'<a href="/trackpark/user/logout.php">  déconnexion</a></div>';
}