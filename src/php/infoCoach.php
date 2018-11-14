<?php
/**************************************************************************************
Fichier :       infoCoach.php
Auteur :		    Olivier Lemay Dostie
Fonctionallité : Fichier qui construit la maquete InfoCoach.
Affiche les informations en lien avec un évaluateur.
Date :          23 avril 2018
=======================================================================================
Vérification :
Date		    Nom					          Approuvé
=======================================================================================
Historique de modification :
Date		    Nom					          Description
2018-05-05	Olivier Lemay Dostie	Création
 **************************************************************************************/

include_once 'AuthenticationManager.class.php';
include_once 'PermissionHelper.php';
include_once 'RequestUtil.php';
session_start_if_not_started();
if(!isLoggedInUserAdmin()) {
    header("Location: login.php?rd=" . getPath());
    return;
}


include_once "CoachManager.class.php";
include_once "Coach.class.php";
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

function deleteCoach()
{
    //$oldCoach = CoachManager::getPerson($_GET['idDeleteCoach']);
    CoachManager::removePerson($_GET['idDeleteCoach']);
}

$coach = null;

if ($_SERVER['REQUEST_METHOD'] === "POST")
{

    if (isset($_POST['idUnassingGroup']))
    {
        //GroupManager::removeCoachAssingGroup($_POST['idRemoveGroup'], $_POST['idCoach']);
    }
    elseif (isset($_POST['idAssingGroup']))
    {
        //GroupManager::addCoachAssingGroup($_POST['idAddGroup'], $_POST['idCoach']);
    }
    elseif (isset($_POST['idUncollabGroup']))
    {
        //GroupManager::removeCoachCollabGroup($_POST['idRemoveGroup'], $_POST['idCoach']);
    }
    elseif (isset($_POST['idCollabGroup']))
    {
        //GroupManager::addCoachCollabGroup($_POST['idAddGroup'], $_POST['idCoach']);
    }
    elseif (isset($_POST['idRemoveEvaluation']))
    {
        //CoachManager::removeCoachEvaluation($_POST['idRemoveEvaluation'], $_POST['idCoach']);
    }
    elseif (isset($_POST['idAddEvaluation']))
    {
        $coach = null;
        //CoachManager::addCoachEvaluation($_POST['idAddEvaluation'], $_POST['idCoach']);
    }

    $coach = Coach::fromId($_POST['idCoach']);
}
else
{
    if (isset($_GET['idDeleteCoach']))
    {
        deleteCoach();
        header("Location:  ./UIWCoachManager.php");
        exit;
    }
    elseif (isset($_GET['addCoach']))
    {
        $id = CoachManager::insertFromAttributes(0, 0, 0, 0,
            '', '', '', '', '', '',
            '');
        $coach = Coach::fromId($id);
    }
    else
    {
        $coach = Coach::fromId($_GET['id']);
        $coach->print();
    }
}
