<?php
/**************************************************************************************
Fichier :       editUser.php
Auteur :        Antoine Gagnon
Fonctionnalité : Modifier un utilisateur
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

include_once 'SessionUtil.php';
include_once 'PermissionHelper.php';
include_once 'RequestUtil.php';
session_start_if_not_started();
if(!isLoggedInUserAdmin()) {
    header("Location: login.php?rd=" . getPath());
    return;
}

include_once 'User.class.php';
include_once 'UserType.class.php';
include_once 'AuthenticationManager.class.php';

if (isPost()) {

    $user = null;
    if (isPostSetAndNotEmpty('id')) {
        $user = User::fromID($_GET['id']);
    }

    if ($user === null) {
        http_response_code(400);
        return;
    }

    if (isPostSetAndNotEmpty('username')) {
        $user->setUsername($_POST['username']);
    }

    if (isPostSetAndNotEmpty('password')) {
        $user->setPassword($_POST['password']);
    }

    if (isPostSetAndNotEmpty('type')) {
        $type = UserType::fromID($_POST['type']);
        if (!is_null($type)) {
            $user->setUserType($type);
        }

    }

    header("Location: manageUsers.php");
    return;
}

$user = null;

if (isset($_GET['id'])) {
    $user = User::fromID($_GET['id']);
}

if (is_null($user)) {
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
    <script src="js/user.js"></script>

    <title><?php echo $user->getUsername()?></title>
</head>
<body class="modal-content animate padding30">
<form action="" name="userFrm" onsubmit="return validateForm()" method="post">
    <?php
    echo '<input type="hidden" value="' . $user->getID() . '" name="id" />';

    echo '<label for="username"><b>Nom d\'utilisateur: </b></label>';
    echo '<input type="text" name="username" value="' . $user->getUsername() . '">';
    echo '</br></br>';

    echo '<label for="password"><b>Mot de passe: </b></label>';
    echo '<input type="password" name="password">';
    echo '</br></br>';

    echo '<label for="type"><b>Type d\'utilisateur: </b></label>';
    echo '<select name="type">';
    $types = UserType::getAllTypes();

    $userType = $user->getUserType()->getId();

    foreach ($types as $type) {
        $id = $type->getId();
        echo '<option value="' . $id . '" ';
        if ($userType === $id) echo 'selected';
        echo '>' . $type->getName() . '</option>';
    }

    echo '</select>';
    ?>
    <br><br>
    <button class="buttonGreen" type="submit">Enregistrer modifications</button>
</form>
</body>
</html>
