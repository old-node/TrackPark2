<?php
/**************************************************************************************
Fichier :       UIWCourseManager.php
Auteur :		    Francis Forest
Fonctionallité : Fichier qui construit la maquete UIWCourseManager.
 * Affiche le gestionnaire des parcours.
Date :          25 avril 2018
=======================================================================================
Vérification :
Date		    Nom					          Approuvé
2018-05-06  Olivier Lemay Dostie  Oui
=======================================================================================
Historique de modification :
Date		    Nom						        Description
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

include_once 'HTMLUtil.php';
include_once 'CtrlGeneral.php';

include_once "Course.class.php";
include_once "CourseManager.class.php";
include_once "DrillManager.class.php";
include_once "Evaluation.class.php";
include_once "EvaluationManager.class.php";
include_once "AthleteManager.class.php";

if ($_SERVER['REQUEST_METHOD'] === "POST")
{
    updateCourse();
}

function makeButtonModify($id)
{
    return "<button class='buttonGreen marginAuto' value={$id} name='id' onclick='modifyCourse(this.value); showModalWindow()'>Modifier</button>";
}

function makeButtonDelete($id)
{
    return "<button class='buttonWhite marginAuto' value={$id} name='idDeleteCourse' onclick='deleteCourse({$id})'>Supprimer</button>";
}

function writeTable()
{
    echo "<table>";
    echo "<tr>" . makeCellTH("Nom") . makeCellTH("Type") . makeCellTH("") . makeCellTH("") . "</tr>";
    foreach (CourseManager::loadCourses() as $c)
    {
        echo "<tr>";
        echo makeTD($c->getName()) . makeTD($c->getType());
        echo makeTD(makeButtonModify($c->getID()));
        echo makeTD(makeButtonDelete($c->getID()));
        echo "</tr>";
    }

    echo "</table><br>";

}

function makeAddCourseButton()
{
    echo "<button class='buttonAdd' value='1' name='addCourse' onclick='addNewCourse(); showModalWindow();'>Ajouter un course</button>";
}

function updateCourse()
{
    $course = new Course($_POST['id'], $_POST['type'], /*$_POST['cap'], */$_POST['name']);
    CourseManager::updateCourse($course);
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>

    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="./css/stylesheet.css">
    <title>TrackPark - Parcours</title>

    <script src="js/util.js"></script>
    <script>

        function saveCourse(idCourse)
        {
            let name = document.getElementById("name").value;
            let type = document.getElementById("type").value;

            xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function()
            {
                if (this.readyState === 4 && this.status === 200)
                {
                    document.getElementById("infoCourse").innerHTML = this.responseText;
                    window.location = window.location.pathname;
                }
            };

            xmlhttp.open("GET", "infoCourse.php?saveCourse="+idCourse+"&type="+type+"&name="+name,true);
            xmlhttp.send();


        }

        function addNewCourse()
        {
            xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function()
            {
                if (this.readyState === 4 && this.status === 200)
                {
                    document.getElementById("infoCourse").innerHTML = this.responseText;
                }
            };

            xmlhttp.open("GET", "infoCourse.php?addCourse=1",true);
            xmlhttp.send();


        }

        function deleteCourse($idCourse)
        {
            if (!confirmWindow("Êtes-vous sûr de vouloir supprimer ce Course?"))
            {
                return;
            }
            xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function()
            {
                if (this.readyState === 4 && this.status === 200)
                {
                    document.getElementById("infoCourse").innerHTML = this.responseText;
                }
            };

            xmlhttp.open("GET", "infoCourse.php?idDeleteCourse="+$idCourse,true);
            xmlhttp.send();

            location.reload();
        }

        function modifyCourse(id)
        {
            xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function()
            {
                if (this.readyState === 4 && this.status === 200)
                {
                    document.getElementById("infoCourse").innerHTML = this.responseText;
                }
            };

            xmlhttp.open("GET", "infoCourse.php?id="+id,true);
            xmlhttp.send();
        }

        function addDrillToCourse(idCourse, idDrill)
        {
            xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function()
            {
                if (this.readyState === 4 && this.status === 200)
                {
                    document.getElementById("infoCourse").innerHTML = this.responseText;
                }
            };

            xmlhttp.open("GET", "infoCourse.php?idAdd="+idDrill+"&idCourse="+idCourse,true);
            xmlhttp.send();
        }

        function removeDrillFromCourse(idCourse, idDrill)
        {
            xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function()
            {
                if (this.readyState === 4 && this.status === 200)
                {
                    document.getElementById("infoCourse").innerHTML = this.responseText;
                }
            };

            xmlhttp.open("GET", "infoCourse.php?idRemove="+idDrill+"&idCourse="+idCourse,true);
            xmlhttp.send();
        }

        function addGroupToCourse(idCourse, idGroup)
        {
            xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function()
            {
                if (this.readyState === 4 && this.status === 200)
                {
                    console.log("idGroup :" + idGroup + " idCourse: " + idCourse);
                    document.getElementById("infoCourse").innerHTML = this.responseText;
                }
            };

            xmlhttp.open("GET", "infoCourse.php?idAddGroup="+idGroup+"&idCourse="+idCourse,true);
            xmlhttp.send();
        }

        function removeGroupFromCourse(idCourse, idGroup)
        {
            xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function()
            {
                if (this.readyState === 4 && this.status === 200)
                {
                    console.log("idGroup :" + idGroup + " idCourse: " + idCourse);
                    document.getElementById("infoCourse").innerHTML = this.responseText;
                }
            };

            xmlhttp.open("GET", "infoCourse.php?idRemoveGroup="+idGroup+"&idCourse="+idCourse,true);
            xmlhttp.send();
        }

        function showModalWindow()
        {
            console.log("show");
            document.getElementById("modalWindow").style.display='block';
        }


        window.onclick = function(event)
        {
            var modal = document.getElementById("modalWindow");

            if (event.target == modal)
            {
                modal.style.display = "none";
            }
        }

        function confirmWindow(message)
        {
            return confirm(message);
        }

    </script>
</head>

<body>
    <div>
    <?php include('sideMenu.php') ?>

        <div class="topMenu col12 colt12 colm12 floatLeft">
            <div class="col2 colt2 colm12 floatLeft"> &nbsp; </div>
            <div class="col10 colt10 colm12 floatLeft">
                <div class="title col6 colt6 colm6 floatLeft">
                    <h1 > Gestion des Courses </h1>
                </div>
                <div class="floatLeft col2 colt2 colm3">
                    <?php makeAddCourseButton(); ?>
                </div>
                <div class="floatLeft col4 colt4 colm3">
                    <button class="buttonImport">Importer des données</button>
                </div>

            </div>
        </div>

        <div class="col2 colt2 colm12 floatLeft">
            &nbsp;
        </div>

        <div class="mainContent floatLeft col10 colt10 colm12">
            <?php writeTable(); ?>
        </div>
    </div>




    <div class="modal" id="modalWindow">
        <div class="modal-content animate padding30" id="infoCourse">

        </div>
    </div>
</body>
</html>
