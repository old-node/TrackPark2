<?php
/**************************************************************************************
Fichier :       editCoach.php
Auteur :        Olivier Lemay Dostie
Fonctionnalité : Modifier un athlète
Date :          30 avril 2018
=======================================================================================
Vérification :
Date        Nom	                    Approuvé
=======================================================================================
Historique de modification :
Date        Nom	                    Description
2018-04-30  Olivier Lemay Dostie    Création
**************************************************************************************/

include_once './AuthenticationManager.class.php';
include_once './PermissionHelper.php';
include_once './RequestUtil.php';
session_start_if_not_started();
if(!isLoggedInUserAdmin()) {
    header("Location: login.php?rd=" . getPath());
    return;
}

include_once './RequestUtil.php';
include_once './SessionUtil.php';
include_once './Coach.class.php';
include_once './HTMLUtil.php';

if (isPost()) {

    $coach = null;
    if (isPostSetAndNotEmpty('id') && $_GET['id'] > 0) {
        $coach = Coach::fromID((int)$_GET['id']);
    }

    if ($coach === null) {
        http_response_code(400);
        return;
    }

    if (isPostSetAndNotEmpty('firstname')) {
        $coach->setFirstname($_POST['firstname']);
    }

    if (isPostSetAndNotEmpty('lastname')) {
        $coach->setLastname($_POST['lastname']);
    }

    if (isPostSetAndNotEmpty('new_address')) {
        //$id = PersonManager::addAddress($_POST['new_address']);
        //if ($id > 0) {
        //    $coach->setAddress($id);
        //}
    } else if (isPostSetAndNotEmpty('address') && $_POST['address'] > 0) {
        $coach->setAddress($_POST['address']);
    }

    if (isPostSetAndNotEmpty('gender')) {
        $coach->setGender($_POST['gender']);
    }

    if (isPostSetAndNotEmpty('profile_info')) {
        $coach->setProfileInfo($_POST['profile_info']);
    }

    if (isPostSetAndNotEmpty('profile_image_url')) {
        $coach->setProfileImageUrl($_POST['profile_image_url']);
    }

    if (isPostSetAndNotEmpty('dob')) {
        $coach->setBirthday($_POST['dob']);
    }

    if (isPostSetAndNotEmpty('collaboration')) {
        $groups = /*array*/($_POST['groups']);
        //GroupManager::addCollabCoach($coach->getId(), $groups);
    }

    if (isPostSetAndNotEmpty('assigned')) {
        $evaluations = /*array*/($_POST['evaluations']);
        //$e = EvaluationManager::addEvaluations($evaluations);
        //EvaluationManager::addEvaluations($coach->getId(), $e);
    }

    header("Location: UIWCoachManager.php");
    return;
}

function makeExtraView(Coach $coach) {

}

function makeProfileImageInput($url) {
    echo '<input type="image" id="profile" width="100" height="200" alt="Image du profil" src="'.$url.'"
      onclick"croppiePhoto(this)"><br>';
    makeTextareaInput('profile_image_url', "URL de l'image :", $url, 30, 2);
}

function makePrimaryInputs(Coach $coach) {
    makeInputType('text', 'firstname', 'Prénom :', $coach->getFirstname());
    makeInputType('text', 'lastname', 'Nom de famille :', $coach->getLastname());
    makeGenderInput($coach->getGender());
    makeInputType('date', 'dob', 'Date de naissance :', $coach->getBirthday());
    makeInputType('date', 'creation_date', 'Date d\'inscription :', $coach->getCreationDate());
    makeInputType('checkbox', 'inactive', 'Inactif :', $coach->isInactive());
}

function makeSecondaryInputs(Coach $coach) {
    makeInputType('tel', 'phone_number', 'Téléphone :', $coach->getPhoneNumber());
    makeInputType('email', 'email', 'Courriel :', $coach->getEmail());
    makeGroupInput($coach);
    makeEvaluationInput($coach);
}

function makeThirdInputs(Coach $coach) {
    makeTextareaInput('address', 'Adresse :', $coach->getAddressID(), 30, 2);
    makeTextareaInput('profile_info', 'Description :', $coach->getProfileInfo());
    makeTextareaInput('comments', 'Commentaires :', $coach->getComments());
}

function makeInputType($type, $inputName, $label, $value) {
    echo '<label for='.$inputName.'><b>'.$label.'</b></label>';
    echo '<input type="'.$type.'" name='.$inputName.' id='.$inputName.' value="' .$value. '">';
    echo '</br></br>';
}

function makeTextareaInput($inputName, $label, $value, $cols = 30, $rows = 4) {
    echo '<label for='.$inputName.'><b>'.$label.'</b></label>';
    echo '<textarea name="'.$inputName.'" id="'.$inputName.'"  cols="'.$cols.'" rows="'.$rows.'">'.$value.'</textarea>';
    echo '</br></br>';
}

function makeGenderInput($value) {
    echo '<label for="gender"><b>Genre :</b></label>';
    echo '<select name="gender" id="gender">';
    echo '<option value="0">Inconnu</option>';
    echo '<option value="1">Homme</option>';
    echo '<option value="2">Femme</option>';
    echo '<option value="9">Non applicable</option>';
    echo '</select>';
    echo '</br></br>';
    echo '<script>document.getElementById("gender").selectedIndex = '.$value.';</script>';
}

function makeGroupInput(Coach $coach) {

}

function makeEvaluationInput(Coach $coach) {

}

$coach = null;

if (!empty($_GET['id'])) {
    $coach = Coach::fromID((int)$_GET['id']);
}

if (is_null($coach)) {
    header("Location: UIWCoachManager.php");
}

?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" type="text/css" href="./css/stylesheet.css">
    <script src="js/person.js"></script>

    <title>Évaluateur - <?php $fullname = $coach->getFullname(); echo $fullname?></title>
    <script>
      function updatePhoto(url) {
        //document.getElementById('profile_photo_url').getAttribute('src') = url;
      }

      function croppiePhoto(frame) {
          if (frame.value != null && frame.value !== "") {
            $(function() {
              let basic = $('#profile').croppie({
                viewport: {
                  width: 100,
                  height: 200
                }
              });
              basic.croppie('bind', {
                url: frame.value,
                points: [77, 469, 280, 739]
              });
            });
          }
        }
    </script>
</head>
<body class="modal-content animate padding30">
<h3><?php echo $fullname?></h3>
<form class='modifCoach' id='coachFrm'  action="" name="coachFrm" onsubmit="return validateForm()" method="post">
    <?php echo '<input type="hidden" value="' . $coach->getID() . '" name="id" />'; ?>
    <table border="1">
        <tr>
            <td>
                <?php makeProfileImageInput($coach->getProfileImageUrl());
                makeExtraView($coach); ?>
            </td>
            <td>
                <?php makePrimaryInputs($coach); ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php makeSecondaryInputs($coach); ?>
            </td>
            <td>
                <?php makeThirdInputs($coach); ?>
            </td>
        </tr>
    </table>

    <br><br>
    <button class="buttonGreen" type="submit">Enregistrer les modifications</button>
    <br><br>

</form>
</body>
</html>
