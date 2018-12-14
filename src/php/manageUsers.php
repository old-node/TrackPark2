<?php
/**************************************************************************************
Fichier :       manageUser.php
Auteur :        Antoine Gagnon
Fonctionnalité : Affiche tout les utilisateurs avec
 * l'option de les modifier ou supprimer.
Date :          26 avril 2018
=======================================================================================
Vérification :
Date		    Nom					          Approuvé
2018-05-06  Olivier Lemay Dostie  Oui
=======================================================================================
Historique de modification :
Date		    Nom						        Description
2018-04-26  Antoine Gagnon        Création
2018-04-29  Olivier Lemay Dostie  Versionnement pour merger
**************************************************************************************/

session_start();
include_once 'User.class.php';
include_once 'HTMLUtil.php';
include_once 'SQLConnector.class.php';

//Vérifie que l'utilisateur est un admin
include_once 'SessionUtil.php';
include_once 'PermissionHelper.php';
include_once 'RequestUtil.php';
if(!isLoggedInUserAdmin()) {
    header("Location: login.php?rd=" . getPath());
    return;
}

$users = User::getAllUsers();
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TrackPark - Utilisateurs</title>

    <link rel="stylesheet" type="text/css" href="./css/stylesheet.css">
    <script
            src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>
    <script src="js/util.js"></script>
    <script src="js/user.js"></script>
</head>
<body>

<div>
<?php include('sideMenu.php') ?>

    <div class="topMenu floatLeft col10 colt10 colm12">
        <div class="title col6 colt6 colm12 floatLeft">
            <h1 > Gestion des utilisateurs </h1>
        </div>
        <div class="floatLeft col2 colt2 colm6">
            <button class='buttonAdd' value='1' name='addUser' onclick='location.href="register.php";'>Ajouter un utilisateur</button>
        </div>
        <div class="floatLeft col4 colt4 colm6">
            <button class="buttonAdd" onclick='location.href="manageUserType.php";'>Type d'utilisateurs</button>
        </div>
    </div>

    <div class="mainContent floatLeft col10 colt10 colm12">
        <table>
            <tr>
                <th>Nom d'utilisateur</th>
                <th>Évaluateur associé</th>
                <th>Type de compte</th>
                <th></th>
                <th></th>
            </tr>
            <?php
            foreach ($users as $user) {
                echo '<tr>';
                echo makeCell($user->getUsername());
                echo makeCell($user->getEvaluator());
                echo makeCell($user->getUserType()->getName());

                echo makeCell(makeButtonModifyCustom("editUser.php", $user->getID()));
                echo makeCell(makeButtonDeleteCustom("deleteUser.php", $user->getID()));
                echo '</tr>';
            }
            ?>
        </table>
    </div>
</div>
</body>
</html>
