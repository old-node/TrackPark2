<?php
/**************************************************************************************
Fichier :       UIWEvaluationManager.php
Auteur :        Francis Forest
Fonctionallité : Fichier qui construit la maquete UIWEvaluationManager.
 * Affiche le gestionnaire des épreuves.
Date :          25 avril 2018
=======================================================================================
Vérification :
Date        Nom                     Approuvé
2018-05-06  Olivier Lemay Dostie    Oui
=======================================================================================
Historique de modification :
Date        Nom                   Description
2018-04-25  Francis Forest        Création
2018-04-28  Olivier Lemay Dostie  Versionnement pour merger
**************************************************************************************/

include_once 'AuthenticationManager.class.php';
include_once 'PermissionHelper.php';
include_once 'RequestUtil.php';
session_start_if_not_started();
if(!isLoggedInUserAdmin()) {
    header("Location: login.php?rd=" . getPath());
    return;
}


include_once "HTMLUtil.php";
include_once "CtrlGeneral.php";
include_once "Course.class.php";
include_once "CourseManager.class.php";
include_once "DrillManager.class.php";
include_once "Evaluation.class.php";
include_once "EvaluationManager.class.php";

if ($_SERVER['REQUEST_METHOD'] === "POST")
{
    updateEvaluation();
}

function makeButtonModify($id)
{
    return "<button class='buttonGreen marginAuto' value={$id} name='id' onclick='modifyEvaluation(this.value); showModalWindow();'>Modifier</button>";
}

function makeButtonDelete($id)
{
    return "<button class='buttonWhite marginAuto' value={$id} name='idDeleteEvaluation' onclick='deleteEvaluation({$id})'>Supprimer</button>";
}

function writeTable()
{
    echo "<table>";
    echo "<tr>" . makeCell("Coach ID") . makeCell("Drill ID") . makeCell("Athlete ID") . makeCell("Period ID") . makeCell("Date") . makeCell("Numerical Value") . makeCell("ResultMessage") . makeCell("Result State") . makeCell("Commentary") . makeCell("Modifier") . makeCell("Suprimer") . "</tr>";

    foreach (EvaluationManager::loadEvaluations() as $e)
    {
        echo "<tr>";
        echo makeCell($e->getCoachID()) . makeCell($e->getDrillID()). makeCell($e->getAthleteID()) . makeCell($e->getPeriodID() . makeCell($e->getDate()) . makeCell($e->getNumericalValue()) . makeCell($e->getResultMessage()) . makeCell($e->getResultState()) . makeCell($e->getCommentary()));
        echo makeCell(makeButtonModify($e->getID()));
        echo makeCell(makeButtonDelete($e->getID()));
        echo "</tr>";
    }

    echo "</table><br>";
}

function updateEvaluation()
{
    $evaluation = new Evaluation($_POST['id'], 1, $_POST['coach'], $_POST['drill'], 1, $_POST['period'], $_POST['date'], $_POST['numValue'], $_POST['message'], $_POST['status'], $_POST['commentary']);
    EvaluationManager::updateEvaluation($evaluation);
}

function makeAddEvaluationButton()
{
    echo "<button class='buttonAdd' value='1' name='addEvaluation' onclick='addNewEvaluation(); showModalWindow();'>Ajouter une évaluation</button>";
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>

    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="./css/stylesheet.css">
    <title>TrackPark - Évaluations</title>

    <script src="js/util.js"></script>
    <script>

        function saveEvaluation(idEvaluation)
        {

            let drill = document.getElementById("drill").value;
            let athlete = document.getElementById("athlete").value;
            let coach = document.getElementById("coach").value;
            let period = document.getElementById("period").value;
            let date = document.getElementById("date").value;
            let numValue = document.getElementById("numValue").value;
            let message = document.getElementById("message").value;
            let status = document.getElementById("status").value;
            let commentary = document.getElementById("commentary").value;

            xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function()
            {
                if (this.readyState === 4 && this.status === 200)
                {
                    document.getElementById("infoEvaluation").innerHTML = this.responseText;
                    window.location = window.location.pathname;
                }
            };

            xmlhttp.open("GET", "infoEvaluation.php?saveEvaluation="+idEvaluation+"&drill="+drill+"&athlete="+athlete+"&coach="+coach+"&period="+period+"&date="+date+"&numValue="+numValue+"&message="+message+"&status="+status+"&commentary="+commentary,true);
            xmlhttp.send();
        }

        function addNewEvaluation()
        {
            xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function()
            {
                if (this.readyState === 4 && this.status === 200)
                {
                    document.getElementById("infoEvaluation").innerHTML = this.responseText;
                }
            };

            xmlhttp.open("GET", "infoEvaluation.php?addEvaluation=1",true);
            xmlhttp.send();
        }

        function deleteEvaluation(idEvaluation)
        {

            if (!confirmWindow("Êtes-vous sûr de vouloir supprimer cette Évaluation?"))
            {
                return;
            }
            xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function()
            {
                if (this.readyState === 4 && this.status === 200)
                {
                    document.getElementById("infoEvaluation").innerHTML = this.responseText;
                }
            };

            xmlhttp.open("GET", "infoEvaluation.php?idDeleteEvaluation="+idEvaluation,true);
            xmlhttp.send();

            location.reload();

        }

        function modifyEvaluation(id)
        {
            xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function()
            {
                if (this.readyState === 4 && this.status === 200)
                {
                    document.getElementById("infoEvaluation").innerHTML = this.responseText;
                }
            };

            xmlhttp.open("GET", "infoEvaluation.php?id="+id,true);
            xmlhttp.send();
        }

        function showModalWindow()
        {
            console.log("show");
            document.getElementById("modalWindow").style.display='block';
        }


        makeWindowModal();

        //confirmAndDo("afdf");

    </script>

</head>

<body>
<div>
<?php include('sideMenu.html') ?>

    <div class="topMenu floatLeft col10 colt10 colm12">
        <div class="title col6 colt6 colm12 floatLeft">
            <h1 > Gestion des Évaluations </h1>
        </div>
        <div class="floatLeft col2 colt2 colm6">
            <?php makeAddEvaluationButton(); ?>
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
    <div class="modal-content animate padding30" id="infoEvaluation">

    </div>
</div>
</body>
</html>
