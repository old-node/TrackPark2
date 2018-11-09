<?php
/**************************************************************************************
Fichier :       addUserType.php
Auteur :        Antoine Gagnon
Fonctionnalité : Permet d'ajouter un type d'utilisateur.
Date :          26 avril 2018
=======================================================================================
Vérification :
Date		Nom					    Approuvé
2018-05-06  Olivier Lemay Dostie    Oui
=======================================================================================
Historique de modification :
Date		Nom						Description
2018-04-26  Antoine Gagnon          Création
2018-05-04  Olivier Lemay Dostie    Mise a jour de l'historique et versionnement.
**************************************************************************************/

include_once 'AuthenticationManager.class.php';
include_once 'User.class.php';
include_once 'UserType.class.php';

include_once 'SessionUtil.php';
include_once 'PermissionHelper.php';
include_once 'RequestUtil.php';
session_start_if_not_started();
if(!isLoggedInUserAdmin()) {
    header("Location: login.php?rd=" . getPath());
    return;
}

if(isPost()) {
    if(isPostSetAndNotEmpty('name') && isPostSetAndNotEmpty('description') && isPostSetAndNotEmpty('level')) {
        try {
            UserType::newUserType($_POST['name'], $_POST['description'],$_POST['level']);;
        } catch (Exception $e) {
        }

    }
    header("Location: manageUserType.php");
    return;
}
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ajouter un type d'utilisateur</title>
    <link rel="stylesheet" type="text/css" href="./css/stylesheet.css">
    <script src="js/userType.js"></script>
</head>
<body class="modal-content animate padding30">

<form name="usrTypeFrm"  onsubmit="return validateForm()" action="" method="post">

    <label for="name">Nom: </label>
    <input type="text" name="name" id="name">
    <br><br>

    <label for="description">Description: </label>
    <textarea name="description"></textarea>
    <br><br>

    <label for="level">Niveau: </label>
    <input type="number" name="level" id="level">
    <br><br>

    <button type="submit">Ajouter type</button>
</form>
</body>
</html>
