<?php
/**************************************************************************************
Fichier :       register.php
Auteur :        Antoine Gagnon
Fonctionnalité : Permet de crée un nouvel utilisateur
Date :          2018-04-26
=======================================================================================
Vérification :
Date		Nom					    Approuvé
2018-05-06  Olivier Lemay Dostie    Oui
=======================================================================================
Historique de modification :
Date		Nom						Description
2018-04-28	Antoine Gagnon          Création
2018-04-29  Olivier Lemay Dostie    Versionnement et merge
 **************************************************************************************/

include_once 'AuthenticationManager.class.php';
include_once 'User.class.php';


session_start_if_not_started();

//Vérifie que l'utilisateur est un administrateur
include_once 'SessionUtil.php';
include_once 'PermissionHelper.php';
include_once 'RequestUtil.php';
session_start_if_not_started();
if(!isLoggedInUserAdmin()) {
    header("Location: login.php?rd=" . getPath());
    return;
}


if(isPost()) {
    if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['type'])) {
        try {
            $user = User::newUser($_POST['username'], $_POST['password'], $_POST['type'], null);
            header("Location: manageUsers.php");
            return;
        } catch (Exception $e) {
            header("Location: register.php");
            return;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>

<div class="form">
    <h2>TrackPark</h2>
    <form action="" method="post">
        <div class="container">
            <label for="username"><b>Nom d'utilisateur</b></label>
            <input type="text" placeholder="Nom d'utilisateur" name="username" required>

            <label for="password"><b>Mot de passe</b></label>
            <input type="password" placeholder="Mot de passe" name="password" required>

            <label for="type">Type d'utilisateur : </label>
            <select id="type" name="type" >
                <?php
                    $types = UserType::getAllTypes();
                    foreach($types as $type) {
                        echo "<option value='{$type->getID()}'>{$type->getName()} lvl: {$type->getPermissionLevel()}</option>";
                    }
                ?>
            </select>
            <button type="submit">Enregistrer</button>
        </div>
    </form>

    <?php showSessionInfo() ?>
</div>

</body>
</html>
