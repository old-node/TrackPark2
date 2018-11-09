<?php
/**************************************************************************************
Fichier :       logout.php
Auteur :        Antoine Gagnon
Fonctionnalité : Permet à l'utilisateur de se déconnecter de la session.
Date :          28 avril 2018
=======================================================================================
Vérification :
Date        Nom	                    Approuvé
2018-05-06  Olivier Lemay Dostie    Oui
=======================================================================================
Historique de modification :
Date        Nom	                    Description
2018-04-28  Antoine Gagnon          Création
2018-04-29  Olivier Lemay Dostie    Versionnement pour merger
**************************************************************************************/

session_start();
session_destroy();
header("Location: http://".$_SERVER['HTTP_HOST']."/trackpark/");
