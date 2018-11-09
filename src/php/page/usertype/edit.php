<?php
/**************************************************************************************
Fichier :       deleteUserType.php
Auteur :        Antoine Gagnon
Fonctionnalité : supprimer un type utilisateur du système
Date :          26 avril 2018
=======================================================================================
Vérification :
Date        Nom	                    Approuvé
2018-05-06  Olivier Lemay Dostie    Oui
=======================================================================================
Historique de modification :
Date        Nom	                    Description
2018-04-26  Antoine Gagnon          Création
2018-04-28  Olivier Lemay Dostie    Versionnement pour merger
**************************************************************************************/

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

include_once 'AuthenticationManager.class.php';

if (isPost()) {

    $type = UserType::fromID($_POST['id']);


    if ($type === null) {
        http_response_code(400);
        return;
    }

    if (isPostSetAndNotEmpty('name')) {
        $type->setName($_POST['name']);
    }

    if (isPostSetAndNotEmpty('description')) {
        $type->setDescription($_POST['description']);
    }

    if (isPostSetAndNotEmpty('level') && is_numeric($_POST['level'])) {
        $type->setPermissionLevel($_POST['level']);
    }

    header("Location: manageUserType.php");
    return;
}

$type = null;

if (isset($_GET['id'])) {
    $type = UserType::fromID($_GET['id']);
}

if (is_null($type)) {
    header("Location: manageUsers.php");
}

?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" type="text/css" href="./css/stylesheet.css">
    <script src="js/userType.js"></script>

    <title><?php echo $type->getName(); ?></title>
</head>
<body class="modal-content animate padding30">

<h1><?php echo $type->getName(); ?></h1>

<form action="" method="post">

    <input type="hidden" value="<?php echo $type->getID(); ?>" name="id" />

    <label for="name"><b>Nom: </b></label>
    <input type="text" name="name" value="<?php echo $type->getName(); ?>">
    </br></br>

    <label for="description"><b>Description: </b></label>
    <input type="text" name="description" value="<?php echo $type->getDescription(); ?>">
    </br></br>

    <label for="level"><b>Niveau de permission: </b></label>
    <input type="number" name="level" value="<?php echo $type->getPermissionLevel()?>">
    </br></br>

    <br><br>
    <button type="submit">Enregistrer modifications</button>
</form>
</body>
</html>
