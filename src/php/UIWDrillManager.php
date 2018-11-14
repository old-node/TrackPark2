<?php
/**************************************************************************************
Fichier :       UIWDrillManager.php
Auteur :		    Francis Forest
Fonctionallité : Fichier qui construit la maquete UIWDrillManager.
 * Affiche le gestionnaire des épreuves.
Date :          25 avril 2018
=======================================================================================
Vérification :
Date        Nom	                  Approuvé
2018-05-06  Olivier Lemay Dostie  Oui
=======================================================================================
Historique de modification :
Date        Nom                   Description
2018-04-25  Francis Forest        Création
2018-04-28  Olivier Lemay Dostie  Versionnement pour merger
2018-05-06  Olivier Lemay Dostie
**************************************************************************************/

include_once 'AuthenticationManager.class.php';
include_once 'PermissionHelper.php';
include_once 'RequestUtil.php';
session_start_if_not_started();
if(!isLoggedInUserAdmin()) {
    header("Location: login.php?rd=" . getPath());
    return;
}

include_once "Course.class.php";
include_once "CourseManager.class.php";
include_once "DrillManager.class.php";
include_once "EvaluationManager.class.php";
include_once "Evaluation.class.php";

if ($_SERVER['REQUEST_METHOD'] === "POST")
{
    //updateDrill();
}

function makeCell($text)
{
    return "<td>" . $text . "</td>";
}

function makeCellTH($text)
{
    return "<th>" . $text . "</th>";
}

function makeButtonModify($id)
{
    return "<button class='buttonGreen marginAuto' value={$id} name='id' onclick='modifyDrill(this.value); showModalWindow();'>Modifier</button>";
}

function makeButtonDelete($id)
{
    return "<button class='buttonWhite marginAuto' value={$id} name='idDeleteDrill' onclick='deleteDrill({$id})'>Supprimer</button>";
}

function writeTitle($title)
{
    echo "<h1>{$title}</h1>";
}

function writeTable()
{
    echo "<table>";
    echo "<tr>" . makeCell("Nom") . makeCell("Objectif") . makeCell("Nombre d'essais") . makeCell("Temps alloué") . makeCell("Nombre pour réussir") . makeCell("Nombre pour échouer") .  makeCell(" ") . makeCell(" ") . "</tr>";

    foreach (DrillManager::loadDrills() as $d)
    {
        echo "<tr>";
        echo makeCell($d->getName()) . makeCell($d->getGoal()) . makeCell($d->getAllowedTries()) . makeCell($d->getAllowedTime()) . makeCell($d->getSuccessThreshold()) . makeCell($d->getFailureThreshold());
        echo makeCell(makeButtonModify($d->getID()));
        echo makeCell(makeButtonDelete($d->getID()));
        echo "</tr>";
    }

    echo "</table><br>";
}

function makeAddDrillButton()
{
    echo "<button class='buttonAdd' value='1' name='addDrill' onclick='addNewDrill(); showModalWindow();'>Ajouter un Drill</button>";
}
function updateDrill()
{
    $drill = new Drill($_POST['id'], null, $_POST['type'], $_POST['drillName'], $_POST['goal'], $_POST['allowedTries'], $_POST['successThreshold'], $_POST['allowedTime'], $_POST['failureThreshold'], 0);
    DrillManager::updateDrill($drill);
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>

    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="./css/stylesheet.css">
    <title>TrackPark - Épreuves</title>

    <script src="js/util.js"></script>
    <script>

        function saveDrill(idDrill)
        {
            console.log("hello");
            let name = document.getElementById("name").value;
            let type = document.getElementById("type").value;
            //let cap = document.getElementById("cap").value;
            let goal = document.getElementById("goal").value;
            let allowedTries = document.getElementById("allowedTries").value;
            let allowedTime = document.getElementById("allowedTime").value;
            let successThreshold = document.getElementById("successThreshold").value;
            let failureThreshold = document.getElementById("failureThreshold").value;

            let xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function()
            {
                if (this.readyState === 4 && this.status === 200)
                {
                    document.getElementById("infoDrill").innerHTML = this.responseText;
                    window.location = window.location.pathname;
                }
            };

            xmlhttp.open("GET", "infoDrill.php?saveDrill="+idDrill+"&type="+type+"&name="+name+"&goal="+goal+"&allowedTries="+allowedTries+"&allowedTime="+allowedTime+"&successThreshold="+successThreshold+"&failureThreshold="+failureThreshold,true);
            xmlhttp.send();


        }

        function addNewDrill()
        {

            let xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function()
            {
                if (this.readyState === 4 && this.status === 200)
                {
                    document.getElementById("infoDrill").innerHTML = this.responseText;
                }
            };

            xmlhttp.open("GET", "infoDrill.php?addDrill=1",true);
            xmlhttp.send();


        }

        function deleteDrill(idDrill)
        {

            if (!confirmWindow("Êtes-vous sûr de vouloir supprimer ce Course?"))
            {
                return;
            }
            let xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function()
            {
                if (this.readyState === 4 && this.status === 200)
                {
                    document.getElementById("infoDrill").innerHTML = this.responseText;
                }
            };

            xmlhttp.open("GET", "infoDrill.php?idDeleteDrill="+idDrill,true);
            xmlhttp.send();

            location.reload();

        }

        function  modifyDrill(id)
        {

            let xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function()
            {
                if (this.readyState === 4 && this.status === 200)
                {
                    console.log(id);
                    document.getElementById("infoDrill").innerHTML = this.responseText;
                }
            };

            xmlhttp.open("GET", "infoDrill.php?id="+id,true);
            xmlhttp.send();

        }

        function showModalWindow()
        {
            console.log("show");
            document.getElementById("modalWindow").style.display='block';
        }


        window.onclick = function(event)
        {
            let modal = document.getElementById("modalWindow");

            if (event.target === modal)
            {
                modal.style.display = "none";
            }
        };

        function confirmWindow(message)
        {
            return confirm(message);
        }

    </script>

</head>

<body>
<div>
    <div class="sideMenu col2 colt2 colm12 floatLeft">
        <img class="logo" src="./images/logo.png">
        <a class="sideMenuButton" href="./manageUsers.php">Utilisateurs</a>
        <a class="sideMenuButton" href="./UIWCoachManager.php">Évaluateurs</a>
        <a class="sideMenuButton" href="./UIWAthleteManager.php">Athlètes</a>
        <a class="sideMenuButton  activeMenu" href="./UIWDrillManager.php">Exercices</a>
        <a class="sideMenuButton" href="./UIWEvaluationManager.php">Évaluations</a>
        <a class="sideMenuButton" href="./UIWGroupManager.php">Groupes</a>
        <a class="sideMenuButton" href="./UIWCourseManager.php">Parcours</a>
        <a class="sideMenuButton" href="./manageCap.php">Casquettes</a>
        <a class="sideMenuButton" href="./map.php">Carte des parcs</a>
        <a class="sideMenuButton" href="./logout.php">Déconnexion</a>
    </div>

    <div class="topMenu floatLeft col10 colt10 colm12">
        <div class="title col6 colt6 colm12 floatLeft">
            <h1 > Gestion des Drills </h1>
        </div>
        <div class="floatLeft col2 colt2 colm6">
            <?php makeAddDrillButton(); ?>
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
    <div class="modal-content animate padding30" id="infoDrill">

    </div>
</div>
</body>
</html>
