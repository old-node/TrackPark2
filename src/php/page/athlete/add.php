<?php
/**************************************************************************************
Fichier :       addAthlete.php
Auteur :        Olivier Lemay Dostie
Fonctionnalité : Permet d'ajouter un athlète.
Date :          6 mai 2018
=======================================================================================
Vérification :
Date		Nom					    Approuvé
=======================================================================================
Historique de modification :
Date		Nom						Description
2018-05-06	Olivier Lemay Dostie   Création
**************************************************************************************/

include_once './AuthenticationManager.class.php';
include_once './PermissionHelper.php';
include_once './RequestUtil.php';
include_once './SessionUtil.php';
include_once './Athlete.class.php';
include_once './AthleteManager.class.php';
include_once './HTMLUtil.php';

session_start_if_not_started();

if(!isLoggedInUserAdmin()) {
    header("Location: login.php?rd=" . getPath());
    return;
}

if(isPost()) {
    if(isPostSetAndNotEmpty('id') && isPostSetAndNotEmpty('firstname')
        && isPostSetAndNotEmpty('lastname') && isPostSetAndNotEmpty('email')) {
        try {
            AthleteManager::insertFromAttributes(
                (int)$_POST['id'], (int)$_POST['address'], (int)$_POST['category'], (int)$_POST['gender'],
                (string)$_POST['first_name'], (string)$_POST['lastname'],
                (string)$_POST['birthday'], (string)$_POST['email'], (string)$_POST['phone_number'],
                (string)$_POST['profile_image_url'], (string)$_POST['profile_info'], (string)$_POST['comments']);
        } catch (Exception $e) {
        }
    }
    header("Location: UIWAthleteManger.php");
    return;
}
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ajouter un athlète</title>
    <link rel="stylesheet" type="text/css" href="./css/stylesheet.css">
    <script src="js/person.js"></script>
</head>

<body class="modal-content animate padding30">
<h3>Ajout d'un athlète</h3><br>
<form name="athleteFrm" onsubmit="return validateForm('athleteFrm')" action="" method="post">

    <label for="firstname">Prénom: </label>
    <input type="text" name="firstname" id="firstname">
    <br><br>

    <label for="lastname">Nom: </label>
    <input type="text" name="lastname" id="lastname">
    <br><br>

    <label for="birthday">Date de naissance: </label>
    <input type="date" name="birthday" id="birthday">
    <br><br>

    <label for="profile_info">Description: </label>
    <textarea name="profile_info" id="profile_info"></textarea>
    <br><br>

    <button type="submit" class="buttonGreen">Ajouter l'athlète</button>
</form>
</body>
</html>
