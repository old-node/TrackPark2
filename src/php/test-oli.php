<?php
/**************************************************************************************
Fichier :       TestCSS.php
Auteur :        Olivier Lemay Dostie
Fonctionallité : Fichier de tests des fonctionnalités de l'application Web de TrackPark.
Date :          2018-04-26
=======================================================================================
Vérification :
Date		    Nom                     Approuvé
=======================================================================================
Historique de modification :
Date		    Nom                     Description
**************************************************************************************/

include_once "Course.class.php";
include_once "CourseManager.class.php";
include_once "DrillManager.class.php";
include_once "EvaluationManager.class.php";
include_once "Evaluation.class.php";

if ($_SERVER['REQUEST_METHOD'] === "POST")
{
    updateDrill();
}

function makeCell($text)
{
    return "<td>" . $text . "</td>";
}

function makeButtonModify($id)
{
    return "<button type='submit' value={$id} name='id'>Modify</button>";
}

function makeButtonDelete($id)
{
    return "<button type='submit' value={$id} name='idDeleteDrill'>Supprimer</button>";
}

function writeTitle($title)
{
    echo "<h1>{$title}</h1>";
}

function writeTable()
{
    echo "<form action='./infoDrill.php' method='get'>";
    echo "<table>";
    echo "<tr>" . makeCell("Nom") . makeCell("Objectif") . makeCell("Nombre d'essais") . makeCell("Nombre pour réussir") . makeCell("Temps alloué") . makeCell("Nombre pour échouer") .  makeCell("Modifier") . makeCell("Supprimer") . "</tr>";

    foreach (DrillManager::loadDrills() as $d)
    {
        echo "<tr>";
        echo makeCell($d->getName()) . makeCell($d->getGoal()) . makeCell($d->getSuccessThreshold()) . makeCell($d->getAllowedTries()) . makeCell($d->getAllowedTime()) . makeCell($d->getFailureThreshold());
        echo makeCell(makeButtonModify($d->getID()));
        echo makeCell(makeButtonDelete($d->getID()));
        echo "</tr>";
    }

    echo "</table><br>";

    echo "<button type='submit' value='1' name='addDrill'>Ajouter un nouveau drill</button>";
}

function updateDrill()
{
    $drill = new Drill($_POST['id'], $_POST['type'], $_POST['drillName'], $_POST['goal'], $_POST['allowedTries'], $_POST['successThreshold'], $_POST['allowedTime'], $_POST['failureThreshold'], 0);
    DrillManager::updateDrill($drill);
}

?>

<html>
<head>
    <script>
      function openModifyWindow(id)
      {
        document.getElementById('form').style.display='block';
      }
    </script>

    <style>
        * {
            box-sizing: border-box;
        }
        label {
            display: inline-block; width: 200px; margin-left: 50px;
        }
        input, select {
            display: inline-block; width: 200px; margin: 0px;
        }
        td,thead {
            padding-left: 5px; padding-right: 5px}
        .form {
            display: none; position: fixed; z-index: 1; left: 50%; top: 50%; transform: translate(-50%, -50%); padding-top: 60px; background-color: #fefefe; border: 1px solid #888; height: 600px; width: 520px;
        }

    </style>
</head>
<body>
  <a href="index.php">Retour au menu principal</a>

  <?php
  writeTitle("Gestion des Drills");
  writeTable();
  ?>

</body>
</html>
