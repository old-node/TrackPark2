<?php
/********************************************************
Fichier :       infoEvaluation.php
Auteur :        Francis Forest
Fonctionnalité :
Date :          2018-04-26
Vérification :
=========================================================
Historique de modifications :
Date        Nom	                  Description
=========================================================
********************************************************/

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
include_once "EvaluationManager.class.php";
include_once "Evaluation.class.php";

function deleteEvaluation()
{
    $eDelete = EvaluationManager::loadEvaluation($_GET['idDeleteEvaluation']);
    EvaluationManager::removeEvaluation($eDelete);
}

function showEvaluationInfo($e)
{
    echo "<label for='drill'>Drill</label>";
    echo "<input type='text' name='drill' id='drill' value='{$e->getDrillID()}'><br><br>";

    echo "<label for='drill'>Athelte</label>";
    echo "<input type='text' name='athlete' id='athlete' value='{$e->getAthleteID()}'><br><br>";

    //echo "<label for='course'>Course</label>";
    //echo "<input type='text' name='course' id='course'><br><br>";

    echo "<label for='coach'>Coach</label>";
    echo "<input type='text' name='coach' id='coach' value='{$e->getCoachID()}'><br><br>";

    //echo "<label for='cap'>Cap</label>";

    /*
    echo "<select name='cap' id='cap'>";
        <option id='1' value='1'>Blanche</option>
    </select><br><br>
    */

    echo "<label for='period'>Period</label>";
    echo "<input type='text' name='period' id='period' value='{$e->getPeriodID()}'><br><br>";

    echo "<label for='date'>Date</label>";
    echo "<input type='text' name='date' id='date' value='{$e->getDate()}'><br><br>";

    echo "<label for='numValue'>Numerical Value</label>";
    echo "<input type='text' name='numValue' id='numValue' value='{$e->getNumericalValue()}'><br><br>";

    echo "<label for='message'>Result Message</label>";
    echo "<input type='text' name='message' id='message' value='{$e->getResultMessage()}'><br><br>";

    echo "<label for='status'>Status</label>";
    echo "<input type='text' name='status' id='status' value='{$e->getResultState()}'><br><br>";

    echo "<label for='commentary'>Commentary</label>";
    echo "<input type='text' name='commentary' id='commentary' value='{$e->getCommentary()}'><br><br>";

    echo "<button value={$e->getID()} class='buttonGreen saveButton' name='id' onclick='saveEvaluation({$e->getID()})'>Enregistrer</button>";

}

if ($_SERVER['REQUEST_METHOD'] === "POST")
{

}
else
{
    if (isset($_GET['saveEvaluation']))
    {
        $e = EvaluationManager::loadEvaluation($_GET['saveEvaluation']);
        $e->setDrillID($_GET['drill']);
        $e->setAthleteID($_GET['athlete']);
        $e->setCoachID($_GET['coach']);
        $e->setPeriodID($_GET['period']);
        $e->setDate($_GET['date']);
        $e->setNumericalValue($_GET['numValue']);
        $e->setResultMessage($_GET['message']);
        $e->setResultState($_GET['status']);
        $e->setCommentary($_GET['commentary']);
        EvaluationManager::updateEvaluation($e);
        showEvaluationInfo($e);
    }
    elseif (isset($_GET['idDeleteEvaluation']))
    {
        deleteEvaluation();
    }
    elseif (isset($_GET['addEvaluation']))
    {
        $newE = new Evaluation(null, null, null, null, null, null, null, null, null, null, null);
        $newID = EvaluationManager::addEvaluation($newE);
        $e = EvaluationManager::loadEvaluation($newID);
        showEvaluationInfo($e);
    }
    else
    {
        $e = EvaluationManager::loadEvaluation($_GET['id']);
        showEvaluationInfo($e);
    }
}

?>
