<?php
/**************************************************************************************
Fichier :       addCap.php
Auteur :        Antoine Gagnon
Fonctionnalité : Permet d'ajouter une casquette.
Date :          28 avril 2018
=======================================================================================
Vérification :
Date		Nom					    Approuvé
2018-05-06  Olivier Lemay Dostie    Oui
=======================================================================================
Historique de modification :
Date		Nom						Description
2018-04-28	Antoine Gagnon          Création
2018-05-04  Olivier Lemay Dostie    Mise a jour de l'historique et versionnement.
**************************************************************************************/

include_once './AuthenticationManager.class.php';
include_once './PermissionHelper.php';
include_once './RequestUtil.php';
include_once './SessionUtil.php';
include_once './Cap.class.php';
include_once './HTMLUtil.php';

session_start_if_not_started();

if(!isLoggedInUserAdmin()) {
    header("Location: login.php?rd=" . getPath());
    return;
}

if(isPost()) {
    if(isPostSetAndNotEmpty('code') && isPostSetAndNotEmpty('name')
        && isPostSetAndNotEmpty('description') && isPostSetAndNotEmpty('color')) {
        try {
            Cap::newCap($_POST['code'], $_POST['name'], $_POST['description'],$_POST['color']);;
        } catch (Exception $e) {
        }
    }
    header("Location: manageCap.php");
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
    <title>Ajouter une casquette</title>
    <link rel="stylesheet" type="text/css" href="./css/stylesheet.css">
    <script src="js/cap.js"></script>
</head>

<body class="modal-content animate padding30">
<form name="capFrm" onsubmit="return validateForm()" action="" method="post">

    <label for="code">Code: </label>
    <input type="text" name="code" id="code">
    <br><br>

    <label for="name">Nom: </label>
    <input type="text" name="name" id="name">
    <br><br>

    <label for="description">Description: </label>
    <textarea name="description" id="description"></textarea>
    <br><br>

    <label for="color">Couleur: </label>
    #<input type="text" name="color" id="color">
    <br><br>

    <button class="buttonGreen" type="submit">Ajouter cap</button>
</form>
</body>
</html>
