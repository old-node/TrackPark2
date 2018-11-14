<?php
/**************************************************************************************
Fichier :       infoAthlete.php
Auteur :        Olivier Lemay Dostie
Fonctionallité : Fichier qui construit la maquete ifoAthlete.
Affiche les informations en lien avec un athlète.
Date :          23 avril 2018
=======================================================================================
Vérification :
Date        Nom					    Approuvé
=======================================================================================
Historique de modification :
Date        Nom					    Description
2018-04-27	Olivier Lemay Dostie	Création
**************************************************************************************/

include_once 'AuthenticationManager.class.php';
include_once 'PermissionHelper.php';
include_once 'RequestUtil.php';
session_start_if_not_started();
if(!isLoggedInUserAdmin()) {
    header("Location: login.php?rd=" . getPath());
    return;
}


include_once "AthleteManager.class.php";
include_once "Athlete.class.php";
include_once "CoachManager.class.php";
include_once "Coach.class.php";

include_once "GroupManager.class.php";
include_once "Group.class.php";
include_once "EvaluationManager.class.php";
include_once "Evaluation.class.php";
include_once "CourseManager.class.php";
include_once "Course.class.php";

include_once 'SQLConnector.class.php';


function makeRemoveButtonCap($id)
{
    return makeRemoveButton($id, 'Cap', 'Rétrograder');
}

function makeAddButtonCap($id)
{
    return makeAddButton($id, 'Cap', 'Promouvoir');
}

function makeRemoveButtonGroup($id)
{
    return makeRemoveButton($id, 'Group', 'Désasigner');
}

function makeAddButtonGroup($id)
{
    return makeRemoveButton($id, 'Group', 'Assigner');
}

function deleteAthlete()
{
    //$oldAthlete = AthleteManager::getPerson($_GET['idDeleteAthlete']);
    AthleteManager::removePerson($_GET['idDeleteAthlete']);
}

$athlete = null;

if ($_SERVER['REQUEST_METHOD'] === "POST")
{

    if (isset($_POST['idRemoveCap']))
    {
    AthleteManager::removeCapFromAthlete($_POST['idRemoveCap'], $_POST['idAthlete']);
    }
    elseif (isset($_POST['idAddCap']))
    {
    AthleteManager::addCapToAthlete($_POST['idAddCap'], $_POST['idAthlete']);
    }
    elseif (isset($_POST['idRemoveGroup']))
    {
        GroupManager::removeAthleteFromGroup($_POST['idRemoveGroup'], $_POST['idAthlete']);
    }
    elseif (isset($_POST['idAddGroup']))
    {
        GroupManager::addAthleteToGroup($_POST['idAddGroup'], $_POST['idAthlete']);
    }
    elseif (isset($_POST['idRemoveEvaluation']))
    {
        //AthleteManager::removeEvaluationFromAthlete($_POST['idRemoveEvaluation'], $_POST['idAthlete']);
    }
    elseif (isset($_POST['idAddEvaluation']))
    {
        //AthleteManager::addEvaluationFromAthlete($_POST['idAddEvaluation'], $_POST['idAthlete']);
    }

    $athlete = Athlete::fromId($_POST['idAthlete']);
}
else
{
    if (isset($_GET['idDeleteAthlete']))
    {
        deleteAthlete();
        header("Location:  ./UIWAthleteManager.php");
        exit;
    }
    elseif (isset($_GET['addAthlete']))
    {
        $id = AthleteManager::insertFromAttributes(0, 0, 0, 0,
            '', '', '', '', '', '',
            '', '');
        $athlete = Athlete::fromId($id);
    }
    else
    {
        $athlete = Athlete::fromId($_GET['id']);
        $athlete->print();
    }
}
