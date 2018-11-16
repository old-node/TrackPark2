<?php
/**************************************************************************************
Fichier :       manageCap.php
Auteur :        Antoine Gagnon
Fonctionnalité : Affiche tout les casquettes avec
 * l'option de les modifiers ou supprimer
Date :          28 avril 2018
=======================================================================================
Vérification :
Date		    Nom					          Approuvé
2018-05-06  Olivier Lemay Dostie  Oui
=======================================================================================
Historique de modification :
Date		    Nom						        Description
2018-04-28  Antoine Gagnon        Création
2018-04-29  Olivier Lemay Dostie  Versionnement pour merger
 **************************************************************************************/

session_start();
include_once 'AuthenticationManager.class.php';
include_once 'PermissionHelper.php';
include_once 'RequestUtil.php';
include_once 'SessionUtil.php';
include_once 'HTMLUtil.php';
include_once 'Cap.class.php';

if(!isLoggedInUserAdmin()) {
    header("Location: login.php?rd=" . getPath());
    return;
}

$caps = Cap::getAllCaps();

function makeButtonModifyCode($link, $id)
{
    return "<button class='buttonGreen marginAuto' value={$id} name='id' onclick=\"location.href='{$link}';\">Modifier</button>";
}

function makeButtonDeleteCode($link, $id)
{
    return "<button class='buttonWhite marginAuto' value={$id} name='idDeleteCourse' onclick='$.post( \"{$link}\", {code:\"{$id}\"});location.reload();'>Supprimer</button>";
}

function writeTable()
{
    echo "<table>";
    echo "<tr>" . makeCellTH("Nom") . makeCellTH("Description") . makeCellTH("Couleur") . "</tr>";

    foreach (Cap::getAllCaps() as $c)
    {
        echo "<tr>";
        echo makeCell($c->getName()) . makeCell($c->getDescription()) . makeCell($c->getColor());
        echo makeCell(makeButtonModifyCode("editCap.php?code=" . $c->getCode(), $c->getCode()));
        echo makeCell(makeButtonDeleteCode("deleteCap.php",$c->getCode()));
        echo "</tr>";
    }

    echo "</table><br>";
}
?>

<!doctype html>
<html lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=iso-8859-1"/>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TrackPark - Casquettes</title>
    <link rel="stylesheet" type="text/css" href="./css/stylesheet.css">
    <script
            src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>
    <script src="js/util.js"></script>
</head>
<body>

<div>
<?php include('sideMenu.html') ?>

    <div class="topMenu floatLeft col10 colt10 colm12">
        <div class="title col6 colt6 colm12 floatLeft">
            <h1 > Gestion des casquettes </h1>
        </div>
        <div class="floatLeft col2 colt2 colm6">
            <button class='buttonAdd' value='1' name='addUser' onclick='location.href="addCap.php";'>Ajouter une casquette</button>
        </div>
        <div class="floatLeft col4 colt4 colm6">
            <button class="buttonImport">Importer des données</button>
        </div>
    </div>

    <div class="mainContent floatLeft col10 colt10 colm12">
        <?php writeTable(); ?>
    </div>
</div>




<div class="modal" id="modalWindow">
    <div class="modal-content animate" id="infoCourse">

    </div>
</div>
</body>
</html>