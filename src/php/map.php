<?php include_once 'AuthenticationManager.class.php';
include_once 'PermissionHelper.php';
include_once 'RequestUtil.php';
session_start_if_not_started();
if(!isLoggedInUserAdmin()) {
    header("Location: login.php?rd=" . getPath());
    return;
}?>

<!--/**********************************************************************************
Fichier :       map.php
Auteur :        Antoine Gagnon
Fonctionnalité : Permet d'afficher une map à l'aide de l'API de google.
Date :          2 mai 2018
=======================================================================================
Vérification :
Date		    Nom                   Approuvé
2018-05-06  Olivier Lemay Dostie  Oui
=======================================================================================
Historique de modification :
Date		    Nom						        Description
2018-05-02	Antoine Gagnon        Création
***********************************************************************************/-->


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>TrackPark - Carte des terrains</title>
    <link rel="stylesheet" href="css/stylesheet.css">
    <style>

        #map {
            height: 100%;
        }
    </style>
    <script src="js/map.js"></script>
</head>
<body>

<div style="height:100%">
    <div class="sideMenu col2 colt2 colm12 floatLeft">
        <img class="logo" src="./images/logo.png">
        <a class="sideMenuButton" href="./manageUsers.php">Utilisateurs</a>
        <a class="sideMenuButton" href="./UIWCoachManager.php">Évaluateurs</a>
        <a class="sideMenuButton" href="./UIWAthleteManager.php">Athlètes</a>
        <a class="sideMenuButton" href="./UIWDrillManager.php">Exercices</a>
        <a class="sideMenuButton" href="./UIWEvaluationManager.php">Évaluations</a>
        <a class="sideMenuButton" href="./UIWGroupManager.php">Groupes</a>
        <a class="sideMenuButton" href="./UIWCourseManager.php">Parcours</a>
        <a class="sideMenuButton" href="./manageCap.php">Casquettes</a>
        <a class="sideMenuButton activeMenu" href="#">Carte des parcs</a>
    </div>

    <div id="map" class="mainContent floatLeft col10 colt10 colm12">
    </div>
</div>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCDeBzBlOQRFR_qAQhzEOckcU-mkDTs1W4&libraries=places&callback=initMap" async defer></script>
</body>
</html>