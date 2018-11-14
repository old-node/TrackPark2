<?php
/*******************************************************
Fichier :       infoGroup.php
Auteur :        Francis Forest
Fonctionnalité :
Date :          2018-04-26
Vérification :
=========================================================
Historique de modifications :
Date        Nom	                  Description
=========================================================
********************************************************/
/**************************************************************************************
Fichier :       infoGroup.php
Auteur :        Francis Forest
Fonctionnalité : Page qui permet la modification et l'affichage des groupes.
Date :          26 avril 2018
=======================================================================================
Vérification :
Date        Nom	                    Approuvé
2018-05-06  Olivier Lemay Dostie    Oui
=======================================================================================
Historique de modification :
Date        Nom	                    Description
2018-04-26  Francis Forest          Création
2018-04-29  Olivier Lemay Dostie    Versionnement pour merger
**************************************************************************************/

include_once 'AuthenticationManager.class.php';
include_once 'PermissionHelper.php';
include_once 'RequestUtil.php';
session_start_if_not_started();
if(!isLoggedInUserAdmin()) {
    header("Location: login.php?rd=" . getPath());
    return;
}


include_once "Drill.class.php";
include_once "DrillManager.class.php";
include_once "Course.class.php";
include_once "CourseManager.class.php";
include_once "Group.class.php";
include_once "GroupManager.class.php";
//include_once "Person.class.php";

function makeCell($text)
{
    return "<td>" . $text . "</td>";
}

function makeRemoveButton($idAthlete, $idGroup)
{
    return "<button class='buttonWhite' value={$idAthlete} name='idRemove' onclick='removeAthleteFromGroup({$idGroup}, this.value)'>Enlever du Groupe</button>";
}

function makeAddButton($idAthlete, $idGroup)
{
    return "<button value={$idAthlete} class='buttonWhite' name='idAdd' onclick='addAthleteToGroup({$idGroup}, this.value)'>Ajouter au Groupe</button>";
}

function makeRemoveButtonCourse($idCourse, $idGroup)
{
    return "<button value={$idCourse} class='buttonWhite' name='idRemoveGroupCourse' onclick='removeCourseFromGroup({$idGroup}, this.value)'>Enlever du Groupe</button>";
}

function makeAddButtonCourse($idCourse, $idGroup)
{
    return "<button value={$idCourse} class='buttonWhite' name='idAddGroupCourse' onclick='addCourseToGroup({$idGroup}, this.value)'>Ajouter au Groupe</button>";
}

function deleteGroup()
{
    $groupDelete = GroupManager::loadGroup($_GET['idDeleteGroup']);
    GroupManager::removeGroup($groupDelete);
}

function showGroupInfo($g)
{
    echo "<label for='name'>Nom du groupe</label>";
    echo "<input type='text' name='name' id='name' value='{$g->getName()}'><br><br>";

    echo "<label for='description'>Description</label>";
    echo "<input type='text' name='description' id='description' value='{$g->getDescription()}'><br><br>";

    echo "<label for='coach'>Coach</label>";
    echo "<input type='text' name='coach' id='coach' value='{$g->getAssignedCoach()}'><br><br>";

    echo "<h3>Athlete qui sont dans ce Group</h3>";

    //supprimer un athlete de ce group
    echo "<table>";

    foreach (GroupManager::getAthletesInGroup($g) as $a)
    {
        $athlete = Athlete::fromId($a);
        echo "<tr>";
        echo makeCell($athlete->fetchFullName());
        //echo makeCell($athlete->fetchPhoneNumber());
        //echo makeCell($athlete->fetchBirthday());
        echo makeCell(makeRemoveButton($a, $g->getID()));
        echo "</tr>";
    }

    echo "</table>";

    //ajouter un athlète au group
    echo "<h3>Athlete qui ne sont pas dans ce Group</h3>";
    echo "<table>";

    foreach (GroupManager::loadAthletesNotInGroup($g) as $a)
    {
        $athlete = Athlete::fromId($a);
        echo "<tr>";
        echo makeCell($athlete->fetchFullName());
        //echo makeCell($athlete->fetchPhoneNumber());
        //echo makeCell($athlete->fetchBirthday());
        echo makeCell(makeAddButton($a, $g->getID()));
        echo "</tr>";
    }

    echo "</table>";

    //supprimer un course de ce groupe
    echo "<h3>Courses de ce Group</h3>";

    echo "<table>";

    foreach ($g->getCourses() as $c)
    {
        $course = CourseManager::loadCourse($c);
        echo "<tr>";
        echo makeCell($course->getName());
        echo makeCell(makeRemoveButtonCourse($c, $g->getID()));
        echo "</tr>";
    }

    echo "</table>";


    //ajouter un course de ce groupe
    echo "<h3>Courses qui ne sont pas dans ce Group</h3>";
    echo "<table>";

    foreach (GroupManager::loadCoursesNotInGroup($g) as $c)
    {
        $course = CourseManager::loadCourse($c);
        echo "<tr>";
        echo makeCell($course->getName());
        echo makeCell(makeAddButtonCourse($c, $g->getID()));
        echo "</tr>";
    }

    echo "</table>";
    echo "<br><br>";
    echo "<button value={$g->getID()} class='buttonGreen saveButton' name='id' onclick='saveGroup({$g->getID()})'>Enregistrer</button>";

}

if ($_SERVER['REQUEST_METHOD'] === "POST")
{

}
else
{
    if (isset($_GET['saveGroup']))
    {
        $g = GroupManager::loadGroup($_GET['saveGroup']);
        $g->setName($_GET['name']);
        $g->setDescription($_GET['description']);
        $g->setAssignedCoach($_GET['coach']);
        GroupManager::updateGroup($g);
        showGroupInfo($g);
    }
    elseif (isset($_GET['idRemove']))
    {
        GroupManager::removeAthleteFromGroup($_GET['idGroup'], $_GET['idRemove']);
        $g = GroupManager::loadGroup($_GET['idGroup']);
        showGroupInfo($g);
    }
    elseif (isset($_GET['idAdd']))
    {
        GroupManager::addAthleteToGroup($_GET['idGroup'], $_GET['idAdd']);
        $g = GroupManager::loadGroup($_GET['idGroup']);
        showGroupInfo($g);
    }
    elseif (isset($_GET['idRemoveGroupCourse']))
    {
        GroupManager::removeCourseFromGroup($_GET['idGroup'], $_GET['idRemoveGroupCourse']);
        $g = GroupManager::loadGroup($_GET['idGroup']);
        showGroupInfo($g);
    }
    elseif (isset($_GET['idAddGroupCourse']))
    {
        GroupManager::addCourseToGroup($_GET['idGroup'], $_GET['idAddGroupCourse']);
        $g = GroupManager::loadGroup($_GET['idGroup']);
        showGroupInfo($g);
    }
    elseif (isset($_GET['idDeleteGroup']))
    {
        deleteGroup();

    }
    elseif (isset($_GET['addGroup']))
    {
        $newGroup = new Group(null, "", "");
        $newID = GroupManager::addGroup($newGroup);
        $g = GroupManager::loadGroup($newID);
        showGroupInfo($g);
    }
    else
    {
        $g = GroupManager::loadGroup($_GET['id']);
        showGroupInfo($g);
    }
}

?>

