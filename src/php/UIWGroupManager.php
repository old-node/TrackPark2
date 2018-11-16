<?php
/**************************************************************************************
Fichier :       UIWGroupManager.php
Auteur :		    Francis Forest
Fonctionallité : Fichier qui construit la maquete UIWAthleteManager.
 * Affiche le gestionnaire des athlètes.
Date :          23 avril 2018
=======================================================================================
Vérification :
Date		    Nom					          Approuvé
2018-05-06	Olivier Lemay Dostie  Création
=======================================================================================
Historique de modification :
Date		    Nom						        Description
2018-04-28	Francis Forest        Création
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
include_once "Group.class.php";
include_once "GroupManager.class.php";

if ($_SERVER['REQUEST_METHOD'] === "POST")
{
    updateGroup();
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
    return "<button class='buttonGreen marginAuto' value={$id} name='id' onclick='modifyGroup(this.value); showModalWindow();'>Modifier</button>";
}

function makeButtonDelete($id)
{
    return "<button class='buttonWhite marginAuto' value={$id} name='idDeleteGroup' onclick='deleteGroup({$id})'>Supprimer</button>";
}

function writeTitle($title)
{
    echo "<h1>{$title}</h1>";
}

function writeTable()
{
    echo "<table>";
    echo "<tr>" . makeCell("Nom") . makeCell("Description") . makeCell("Modifier") . makeCell("Supprimer") . "</tr>";

    foreach (GroupManager::loadGroups() as $g)
    {
        echo "<tr>";
        echo makeCell($g->getName()) . makeCell($g->getDescription());
        echo makeCell(makeButtonModify($g->getID()));
        echo makeCell(makeButtonDelete($g->getID()));
        echo "</tr>";
    }

    echo "</table><br>";
}

function makeAddGroupButton()
{
    echo "<button class='buttonAdd' value='1' name='addGroup' onclick='addNewGroup(); showModalWindow();'>Ajouter un Groupe</button>";
}

function updateGroup()
{
    $group = new Group($_POST['id'], $_POST['name'], $_POST['description']);
    GroupManager::updateGroup($group);
}
?>

<html>
<head>

    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="./css/stylesheet.css">
    <title>TrackPark</title>

    <script src="js/util.js"></script>
    <script>
        function saveGroup(idGroup)
        {
            let name = document.getElementById("name").value;
            let description = document.getElementById("description").value;
            let coach = document.getElementById("coach").value;

            xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function()
            {
                if (this.readyState === 4 && this.status === 200)
                {
                    document.getElementById("infoGroup").innerHTML = this.responseText;
                    window.location = window.location.pathname;
                }
            };

            xmlhttp.open("GET", "infoGroup.php?saveGroup="+idGroup+"&name="+name+"&description="+description+"&coach="+coach,true);
            xmlhttp.send();
        }

        function addNewGroup()
        {
            xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function()
            {
                if (this.readyState === 4 && this.status === 200)
                {
                    document.getElementById("infoGroup").innerHTML = this.responseText;
                }
            };

            xmlhttp.open("GET", "infoGroup.php?addGroup=1",true);
            xmlhttp.send();
        }

        function deleteGroup(idGroup)
        {
            if (!confirmWindow("Êtes-vous sûr de vouloir supprimer ce Groupe?"))
            {
                return;
            }
            xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function()
            {
                if (this.readyState === 4 && this.status === 200)
                {
                    document.getElementById("infoGroup").innerHTML = this.responseText;
                }
            };

            xmlhttp.open("GET", "infoGroup.php?idDeleteGroup="+idGroup,true);
            xmlhttp.send();

            location.reload();
        }

        function modifyGroup(id)
        {
            xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function()
            {
                if (this.readyState === 4 && this.status === 200)
                {
                    document.getElementById("infoGroup").innerHTML = this.responseText;
                }
            };

            xmlhttp.open("GET", "infoGroup.php?id="+id,true);
            xmlhttp.send();
        }

        function addAthleteToGroup(idGroup, idAthlete)
        {
            xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function()
            {
                if (this.readyState === 4 && this.status === 200)
                {
                    document.getElementById("infoGroup").innerHTML = this.responseText;
                }
            };

            xmlhttp.open("GET", "infoGroup.php?idAdd="+idAthlete+"&idGroup="+idGroup,true);
            xmlhttp.send();
        }

        function removeAthleteFromGroup(idGroup, idAthlete)
        {
            xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function()
            {
                if (this.readyState === 4 && this.status === 200)
                {
                    document.getElementById("infoGroup").innerHTML = this.responseText;
                }
            };

            xmlhttp.open("GET", "infoGroup.php?idRemove="+idAthlete+"&idGroup="+idGroup,true);
            xmlhttp.send();
        }

        function removeCourseFromGroup(idGroup, idCourse)
        {
            xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function()
            {
                if (this.readyState === 4 && this.status === 200)
                {
                    document.getElementById("infoGroup").innerHTML = this.responseText;
                }
            };

            xmlhttp.open("GET", "infoGroup.php?idRemoveGroupCourse="+idCourse+"&idGroup="+idGroup,true);
            xmlhttp.send();
        }

        function addCourseToGroup(idGroup, idCourse)
        {
            xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function()
            {
                if (this.readyState === 4 && this.status === 200)
                {
                    document.getElementById("infoGroup").innerHTML = this.responseText;
                }
            };

            xmlhttp.open("GET", "infoGroup.php?idAddGroupCourse="+idCourse+"&idGroup="+idGroup,true);
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
<?php include('sideMenu.html') ?>

    <div class="topMenu col12 colt12 colm12 floatLeft">
        <div class="col2 colt2 colm12 floatLeft"> &nbsp; </div>
        <div class="col10 colt10 colm12 floatLeft">
            <div class="title col6 colt6 colm6 floatLeft">
                <h1 > Gestion des Groupes </h1>
            </div>
            <div class="floatLeft col2 colt2 colm3">
                <?php makeAddGroupButton(); ?>
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
    <div class="modal-content animate padding30" id="infoGroup">

    </div>
</div>
</body>
</html>