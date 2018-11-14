<?php
/**************************************************************************************
Fichier :       editAthlete.php
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

include_once 'AuthenticationManager.class.php';
include_once 'PermissionHelper.php';
include_once 'RequestUtil.php';
session_start_if_not_started();
if(!isLoggedInUserAdmin()) {
    header("Location: login.php?rd=" . getPath());
    return;
}

include_once 'RequestUtil.php';
include_once 'SessionUtil.php';
include_once 'Athlete.class.php';
include_once 'HTMLUtil.php';

if (isPost()) {

    $athlete = null;
    if (isPostSetAndNotEmpty('id') && $_GET['id'] > 0) {
        $athlete = Athlete::fromID((int)$_GET['id']);
    }

    if ($athlete === null) {
        http_response_code(400);
        return;
    }

    if (isPostSetAndNotEmpty('firstname')) {
        $athlete->setFirstname($_POST['firstname']);
    }

    if (isPostSetAndNotEmpty('lastname')) {
        $athlete->setLastname($_POST['lastname']);
    }

    if (isPostSetAndNotEmpty('new_address')) {
        //$id = PersonManager::addAddress($_POST['new_address']);
        //if ($id > 0) {
        //    $athlete->setAddress($id);
        //}
    } else if (isPostSetAndNotEmpty('address') && $_POST['address'] > 0) {
        $athlete->setAddress($_POST['address']);
    }

    if (isPostSetAndNotEmpty('gender')) {
        $athlete->setGender($_POST['gender']);
    }

    if (isPostSetAndNotEmpty('category') && $_POST['address'] > 0) {
        $athlete->setCategoryID($_POST['category']);
    }

    if (isPostSetAndNotEmpty('profile_info')) {
        $athlete->setProfileInfo($_POST['profile_info']);
    }

    if (isPostSetAndNotEmpty('profile_image_url')) {
        $athlete->setProfileImageUrl($_POST['profile_image_url']);
    }

    if (isPostSetAndNotEmpty('dob')) {
        $athlete->setBirthday($_POST['dob']);
    }

    if (isPostSetAndNotEmpty('caps')) {
        $caps = array($_POST['caps']);
        $athlete->setCaps($caps);
    }

    if (isPostSetAndNotEmpty('groups')) {
        $groups = /*array*/($_POST['groups']);
        GroupManager::addAthleteToGroup($athlete->getId(), $groups);
    }

    if (isPostSetAndNotEmpty('evaluations')) {
        $evaluations = /*array*/($_POST['evaluations']);
        //$e = EvaluationManager::addEvaluations($evaluations);
        //EvaluationManager::addEvaluations($athlete->getId(), $e);
    }

    header("Location: UIWAthleteManager.php");
    return;
}

function makeStatisticView(Athlete $athlete) {

}

function makeProfileImageInput($url) {
    echo '<input type="image" id="profile" width="100" height="200" alt="Image du profil" src="'.$url.'"
      onclick"croppiePhoto(this)"><br>';
    makeTextareaInput('profile_image_url', "URL de l'image :", $url, 30, 2);
}

function makePrimaryInputs(Athlete $athlete) {
    makeInputType('text', 'firstname', 'Prénom :', $athlete->getFirstname());
    makeInputType('text', 'lastname', 'Nom de famille :', $athlete->getLastname());
    makeGenderInput($athlete->getGender());
    makeInputType('date', 'dob', 'Date de naissance :', $athlete->getBirthday());
    makeInputType('date', 'creation_date', 'Date d\'inscription :', $athlete->getCreationDate());
    makeInputType('checkbox', 'inactive', 'Inactif :', $athlete->isInactive());
}

function makeSecondaryInputs(Athlete $athlete) {
    makeCategoryInput($athlete->getCategoryID());
    makeInputType('tel', 'phone_number', 'Téléphone :', $athlete->getPhoneNumber());
    makeInputType('email', 'email', 'Courriel :', $athlete->getEmail());
    makeTextareaInput('text', 'Casquettes obtenues :', getCapList($athlete));
    makeCapInput($athlete);
    makeGroupInput($athlete);
    makeEvaluationInput($athlete);
}

function makeThirdInputs(Athlete $athlete) {
    makeTextareaInput('address', 'Adresse :', $athlete->getAddressID(), 30, 2);
    makeTextareaInput('profile_info', 'Description :', $athlete->getProfileInfo());
    makeTextareaInput('comments', 'Commentaires :', $athlete->getComments());
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

function makeCategoryInput($value) {
    $categories = null;//AthleteManager::getCategories();
    echo '<label for="category"><b>Catégorie :</b></label>';
    echo '<select name="category">';
    for ($i = 0; $i < count($categories); $i++) {
        echo '<option value="'.$i.'">'.$categories[$i].'</option>';
    }
    echo '</select>';
    echo '</br></br>';
    echo '<script>document.getElementById("category").selectedIndex = '.$value.';</script>';
}

function getCaps(Athlete $athlete) {
    $capCodes = $athlete->getCapIDs();
    $caps = array();
    foreach ($capCodes as $code) {
        array_push($caps, Cap::fromID($code));
    }
    return $caps;
}

function getCapList(Athlete $athlete) {
    $capCodes = getCaps($athlete);
    $list = "";
    foreach ($capCodes as $cap) {
        $list .= $cap->getName().", ";
    }
    return $list;
}

function makeCapInput(Athlete $athlete) {
    echo '<script>
    let selectedCode = "";
    function getSelectedCode() {
      return selectedCode;
    }
    let ownsIt = false;
    function updatePromotion(ownsTheCap) {
      selectedCode = document.getElementById("new_cap").selectedIndex;
      if (ownsTheCap) {
        document.getElementById("promote").value = "Rétrograder";
        ownsIt = false;
      } else {
        document.getElementById("promote").value = "Promouvoir";
        ownsIt = true;
      }
    }
    </script>';

    $caps = getCapList($athlete);

    /* TODO: Ajouter un textarea qui montre les casquetes obtenues.
    <label for='caps'>Casquettes obtenues</label><br>
        <p id='caps'>Aucune casquette</p><br>*/
    echo '<label for="new_cap"><b>Ajouter une casquette :</b></label>';
    echo '<select name="new_cap" id="new_cap" onchange"updatePromotion(
      <? php $athlete->hasCap(?>getSelectedCode();<?php); ?>)">';
    // TODO: rendre accessible en PHP la value du select.
    foreach ($caps as $cap) {
        echo '<option value="'.$cap->getCode().'">'.$cap->getName().'</option>';
    }
    echo '</select>';
    /*echo '</br>
    <input type="button" class="buttonGreen" id="promote" value="Promouvoir" onclick="'."
    if({this.value} == 'Promouvoir') {
        promote($code, $athlete);
    } else {
        demote($code, $athlete);
    }'.'">';*/
}

function makeGroupInput(Athlete $athlete) {

}

function makeEvaluationInput(Athlete $athlete) {

}

// TODO: Utiliser un mécanisme toggle au lieu de deux fonctions.
function promote(string $code, Athlete $athlete) {
    AthleteManager::addCapToAthlete($code,$athlete->getId());
}
function demote(string $code, Athlete $athlete) {
    AthleteManager::removeCapFromAthlete($code ,$athlete->getId());
}

$athlete = null;

if (!empty($_GET['id'])) {
    $athlete = Athlete::fromID((int)$_GET['id']);
}

if (is_null($athlete)) {
    header("Location: UIWAthleteManager.php");
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

    <title>Athlète - <?php $fullname = $athlete->getFullname(); echo $fullname?></title>
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
<form class='modifAthlete' id='athleteFrm'  action="" name="athleteFrm" onsubmit="return validateForm()" method="post">
    <?php echo '<input type="hidden" value="' . $athlete->getID() . '" name="id" />'; ?>
    <table border="1">
        <tr>
            <td>
                <?php makeProfileImageInput($athlete->getProfileImageUrl());
                makeStatisticView($athlete); ?>
            </td>
            <td>
                <?php makePrimaryInputs($athlete); ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php makeSecondaryInputs($athlete); ?>
            </td>
            <td>
                <?php makeThirdInputs($athlete); ?>
            </td>
        </tr>
    </table>

    <br><br>
    <button class="buttonGreen" type="submit">Enregistrer les modifications</button>
    <br><br>

</form>
</body>
</html>
