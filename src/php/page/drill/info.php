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

function deleteDrill()
{
    $drillDelete = DrillManager::loadDrill($_GET['idDeleteDrill']);
    DrillManager::removeDrill($drillDelete);
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

function showDrillInfo($drill)
{
    echo '<label for="name">Nom du Drill</label>';
    echo "<input type='text' name='name' id='name' value='{$drill->getName()}'><br><br>";

    echo "<label for='type'>Type</label>";
    echo "<input type='text' name='type' id='type' value='{$drill->getTypeID()}'><br><br>";

   //writeComboCaps($drill->getID());

    echo "<label for='goal'>Objectif</label>";
    echo "<input type='text' name='goal' id='goal' value='{$drill->getGoal()}'><br><br>";

    echo "<label for='allowedTries'>Nombre d'essais alloués</label>";
    echo "<input type='text' name='allowedTries' id='allowedTries' value='{$drill->getAllowedTries()}'><br><br>";

    echo "<label for='allowedTime'>Temps alloué</label>";
    echo "<input type='text' name='allowedTime' id='allowedTime' value='{$drill->getAllowedTime()}'><br><br>";

    echo "<label for='successThreshold'>Nombre pour réussir</label>";
    echo "<input type='text' name='successThreshold' id='successThreshold' value='{$drill->getSuccessThreshold()}'><br><br>";

    echo "<label for='failureThreshold'>Nombre pour échouer</label>";
    echo "<input type='text' name='failureThreshold' id='failureThreshold' value='{$drill->getFailureThreshold()}'><br><br>";

    echo "<button value={$drill->getID()} class='buttonGreen saveButton' name='id' onclick='saveDrill({$drill->getID()})'>Enregistrer</button>";

}

if ($_SERVER['REQUEST_METHOD'] === "POST")
{

}
else
{
    if (isset($_GET['saveDrill']))
    {
        $drill = DrillManager::loadDrill($_GET['saveDrill']);
        $drill->setName($_GET['name']);
        $drill->setTypeID($_GET['type']);
        //$drill->setCap($_GET['cap']);
        $drill->setGoal($_GET['goal']);
        $drill->setAllowedTries($_GET['allowedTries']);
        $drill->setAllowedTime(($_GET['allowedTime']));
        $drill->setSuccessThreshold($_GET['successThreshold']);
        $drill->setFailureThreshold($_GET['failureThreshold']);
        DrillManager::updateDrill($drill);
        showDrillInfo($drill);
    }
    elseif (isset($_GET['idDeleteDrill']))
    {
        deleteDrill();
    }
    elseif (isset($_GET['addDrill']))
    {
        $newDrill = new Drill(null, null, null, null, null, null, null, null, null, null);
        $newID = DrillManager::addDrill($newDrill);
        $drill = DrillManager::loadDrill($newID);
        showDrillInfo($drill);
    }
    else
    {
        $drill = DrillManager::loadDrill($_GET['id']);
        showDrillInfo($drill);
    }
}

?>
