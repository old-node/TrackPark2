<?php

include_once './AuthenticationManager.class.php';
include_once './PermissionHelper.php';
include_once './RequestUtil.php';
session_start_if_not_started();
if(!isLoggedInUserAdmin()) {
    header("Location: login.php?rd=" . getPath());
    return;
}


include_once "./Drill.class.php";
include_once "./DrillManager.class.php";
include_once "./Course.class.php";
include_once "./CourseManager.class.php";
include_once "./Cap.class.php";
include_once "./GroupManager.class.php";
include_once "./Group.class.php";

function makeCell($text)
{
    return "<td>" . $text . "</td>";
}

function makeRemoveButton($idDrill, $idCourse)
{
    return "<button value={$idDrill} class='buttonWhite' name='idRemove' onclick='removeDrillFromCourse({$idCourse}, this.value)'>Enlever du Course</button>";
}

function makeAddButton($idDrill, $idCourse)
{
    return "<button value={$idDrill} class='buttonWhite' name='idAdd' onclick='addDrillToCourse({$idCourse}, this.value)'>Ajouter au Course</button>";
}

function makeRemoveButtonGroup($idGroup, $idCourse)
{
    return "<button value={$idGroup} class='buttonWhite' name='idRemoveGroup' onclick='removeGroupFromCourse({$idCourse}, this.value)'>Enlever du Course</button>";
}

function makeAddButtonGroup($idGroup, $idCourse)
{
    return "<button value={$idGroup} class='buttonWhite' name='idAddGroup' onclick='addGroupToCourse({$idCourse}, this.value)'>Ajouter au Course</button>";
}

function deleteCourse()
{
    $courseDel = CourseManager::loadCourse($_GET['idDeleteCourse']);
    CourseManager::removeCourse($courseDel);
}

function writeComboCaps($id)
{
    echo "<label for='cap'>Casquette</label>";
    echo "<select name='cap' id='cap'>";

    $caps = Cap::getAllCaps();

    foreach ($caps as $cap)
    {
        if ($cap->getCode() == $id)
        {
            echo "<option id='{$cap->getCode()}' value='{$cap->getCode()}' selected>{$cap->getName()}</option>";
        }
        else
        {
            echo "<option id='{$cap->getCode()}' value='{$cap->getCode()}'>{$cap->getName()}</option>";
        }
    }

    echo "</select><br><br>";
}

function showCourseInfo($course)
{
    echo '<label for="name">Nom du Course</label>';
    echo "<input type='text' name='name' id='name' value='{$course->getName()}'><br><br>";

    echo "<label for='type'>Type</label>";
    echo "<input type='text' name='type' id='type' value='{$course->getType()}'><br><br>";

    //writeComboCaps($course->getID());

    //supprimer un drill du course
    echo "<br><br>";
    echo "<h3> Drills de ce Course </h3>";
    echo "<table>";

    echo makeCell("Nom") . makeCell("Type") . makeCell("") . makeCell("Objectif") . makeCell("Nombre d'essais") . makeCell("Temps alloué") . makeCell("Succès") . makeCell("Échec");
    foreach ($course->getDrills() as $d)
    {
        $d->printRowWithoutClosingTR();
        echo makeCell(makeRemoveButton($d->getID(), $course->getID()));
        echo "</tr>";
    }

    echo "</table>";

    //ajouter un drill au course
    echo "<br><br>";
    echo "<h3> Drills qui ne sont pas dans ce Course </h3>";

    echo "<table>";
    echo makeCell("Nom") . makeCell("Type") . makeCell("") . makeCell("Objectif") . makeCell("Nombre d'essais") . makeCell("Temps alloué") . makeCell("Succès") . makeCell("Échec");
    foreach (CourseManager::loadDrillsNotInCourse($course) as $d)
    {
        $d->printRowWithoutClosingTR();
        echo makeCell(makeAddButton($d->getID(), $course->getID()));
    }

    echo "</table>";

    ////////////////// Course ///////

    //supprimer un Group du Course
    echo "<br><br>";
    echo "<h3>Groups qui on ce Course</h3>";
    echo "<table>";
    echo makeCell("Nom") . makeCell("Description");
    foreach ($course->getGroups() as $g)
    {
        $group = GroupManager::loadGroup($g);
        echo "<tr>";
        echo makeCell($group->getName());
        echo makeCell($group->getDescription());
        echo makeCell(makeRemoveButtonGroup($g, $course->getID()));
        echo "</tr>";
    }

    echo "</table>";

    //ajouter un drill au course
    echo "<br><br>";
    echo "<h3> Groups qui n'ont pas ce Course </h3>";
    echo "<table class='minWidthTable'>";
    echo makeCell("Nom") . makeCell("Description");

    foreach (CourseManager::loadGroupsNotInCourse($course) as $g)
    {
        $group = GroupManager::loadGroup($g);
        echo "<tr>";
        echo makeCell($group->getName());
        echo makeCell($group->getDescription());
        echo makeCell(makeAddButtonGroup($g, $course->getID()));
        echo "</tr>";
    }

    echo "</table>";

    echo "<br><br>";
    echo "<button value={$course->getID()} class='buttonGreen saveButton' name='id' onclick='saveCourse({$course->getID()})'>Enregistrer</button>";
}


if ($_SERVER['REQUEST_METHOD'] === "POST")
{

}
else
{
    if (isset($_GET['saveCourse']))
    {
        $course = CourseManager::loadCourse($_GET['saveCourse']);
        $course->setName($_GET['name']);
        $course->setType($_GET['type']);
        CourseManager::updateCourse($course);
        showCourseInfo($course);
    }
    elseif (isset($_GET['idAdd']))
    {
        CourseManager::addDrillToCourse($_GET['idCourse'], $_GET['idAdd']);
        $course = CourseManager::loadCourse($_GET['idCourse']);
        showCourseInfo($course);
    }
    elseif (isset($_GET['idRemove']))
    {
        CourseManager::removeDrillFromCourse($_GET['idCourse'], $_GET['idRemove']);
        $course = CourseManager::loadCourse($_GET['idCourse']);
        showCourseInfo($course);
    }
    elseif (isset($_GET['idDeleteCourse']))
    {
        deleteCourse();
    }
    elseif (isset($_GET['addCourse']))
    {
        $newCourse = new Course(null, null, null);
        $newID = CourseManager::addCourse($newCourse);
        $course = CourseManager::loadCourse($newID);
        showCourseInfo($course);
    }
    elseif (isset($_GET['idAddGroup']))
    {
        CourseManager::addGroupToCourse($_GET['idCourse'], $_GET['idAddGroup']);
        $course = CourseManager::loadCourse($_GET['idCourse']);
        showCourseInfo($course);
    }
    elseif (isset($_GET['idRemoveGroup']))
    {
        CourseManager::removeGroupFromCourse(($_GET['idCourse']), $_GET['idRemoveGroup']);
        $course = CourseManager::loadCourse($_GET['idCourse']);
        showCourseInfo($course);
    }
    else
    {
        $course = CourseManager::loadCourse($_GET['id']);
        showCourseInfo($course);
    }
}

?>


