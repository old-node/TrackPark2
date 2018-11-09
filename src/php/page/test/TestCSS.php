<!--
/**************************************************************************************
Fichier :       TestCSS.php
Auteur :
Fonctionallité : Fichier des styles de l'application Web TrackPark.
Date :          2018-04-26
=======================================================================================
Vérification :
Date		    Nom                     Approuvé
2018-05-06  Olivier Lemay Dostie    Oui
=======================================================================================
Historique de modification :
Date		    Nom                   Description
**************************************************************************************/
-->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="./css/stylesheet.css">
    <title>TrackPark</title>
</head>
<body>

	<div class="sideMenu col2 colt2 colm12 floatLeft fixed">
		<img class="logo" src="./images/logo.png">
		<a class="sideMenuButton" href="./manageUsers.php">Utilisateurs</a>
		<a class="sideMenuButton" href="UIWCoachManager.php">Coachs</a>
		<a class="sideMenuButton" href="UIWAthleteManager.php">Athletes</a>
		<a class="sideMenuButton" href="./UIWDrillManager.php">Drills</a>
		<a class="sideMenuButton" href="./UIWEvaluationManager.php">Evaluations</a>
		<a class="sideMenuButton" href="./UIWGroupManager.php">Groups</a>
		<a class="sideMenuButton activeMenu" href="./UIWCourseManager.php">Courses</a>
		<a class="sideMenuButton" href="./manageCap.php">Caps</a>
	</div>

	<div class="topMenu col12 colt12 colm12 floatLeft">
		<div class="col2 colt2 colm12 floatLeft"> &nbsp; </div>
		<div class="col10 colt10 colm12 floatLeft">
            <div class="title col6 colt6 colm6 floatLeft">
                <h1 > Gestion des Courses </h1>
            </div>
			<div class="floatLeft col2 colt2 colm12">
                <?php include_once "UIWCourseManager.php"; makeAddCourseButton(); ?>
            </div>
            <div class="floatLeft col4 colt4 colm12">
                <button class="buttonImport">Importer des données</button>
            </div>

		</div>
	</div>
	
	<div class="col2 colt2 colm12 floatLeft">
        &nbsp;
	</div>
	
	<div class="mainContent floatLeft col10 colt10 colm12">
        <?php include_once "UIWCourseManager.php"; writeTable(); ?>


    </div>
</body>
</html>