<?php
/**************************************************************************************
Fichier :       manageUserType.php
Auteur :        Antoine Gagnon
Fonctionnalité : Affiche tout les types d'utilisateurs avec l'option
 * de les modifier ou des les supprimer.
Date :          2018-04-26
=======================================================================================
Vérification :
Date		    Nom					          Approuvé
2018-05-06  Olivier Lemay Dostie  Oui
=======================================================================================
Historique de modification :
Date		    Nom						        Description
2018-04-25  Antoine Gagnon        Création
2018-04-29  Olivier Lemay Dostie  Versionnement pour merger
**************************************************************************************/

session_start();
include_once 'User.class.php';
include_once 'HTMLUtil.php';
include_once 'SQLConnector.class.php';
include_once 'UserType.class.php';

//Vérifie que l'utilisateur est un admin
include_once 'SessionUtil.php';
include_once 'PermissionHelper.php';
include_once 'RequestUtil.php';
session_start_if_not_started();
if(!isLoggedInUserAdmin()) {
    header("Location: login.php?rd=" . getPath());
    return;
}

$types = UserType::getAllTypes();
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TrackPark - Type d'utilisateur</title>
    <link rel="stylesheet" type="text/css" href="./css/stylesheet.css">
    <script
            src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>
    <script src="js/util.js"></script>
</head>
<body>
<?php include('sideMenu.html') ?>

<div class="topMenu floatLeft col10 colt10 colm12">
    <div class="title col6 colt6 colm12 floatLeft">
        <h1 > Gestion des type d'utilisateurs </h1>
    </div>
    <div class="floatLeft col2 colt2 colm6">
        <button class='buttonAdd' value='1' name='addUser' onclick='location.href="addUserType.php";'>Ajouter un type utilisateur</button>
    </div>
</div>

<div class="mainContent floatLeft col10 colt10 colm12">
    <table>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Description</th>
            <th>Niveau de permission</th>
            <th></th>
            <th></th>
        </tr>
        <?php
        foreach ($types as $type) {
            echo '<tr>';
            echo makeTD($type->getID());
            echo makeTD($type->getName());
            echo makeTD($type->getDescription());
            echo makeTD($type->getPermissionLevel());
            echo makeCell(makeButtonModifyCustom("editUserType.php", $type->getID()));
            echo makeCell(makeButtonDeleteCustom("deleteUserType.php", $type->getID()));
            echo '</tr>';
        }
        ?>
    </table>
</div>


</body>
</html>