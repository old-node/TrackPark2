<?php
/**************************************************************************************
Fichier :       login.php
Auteur :        Antoine Gagnon
Fonctionnalité : Permet à un utilisateur de s'authentifier
Date :          26 avril 2018
=======================================================================================
Vérification :
Date        Nom	                    Approuvé
2018-05-06  Olivier Lemay Dostie    Oui
=======================================================================================
Historique de modification :
Date        Nom	                    Description
2018-04-26  Antoine Gagnon          Création
2018-04-29  Olivier Lemay Dostie    Versionnement pour merger
**************************************************************************************/

include_once 'AuthenticationManager.class.php';
include_once 'RequestUtil.php';
include_once 'Exceptions.php';


session_start();


if(isPost()) {
    if(isset($_POST['username']) && isset($_POST['password'])) {
        try {
            AuthenticationManager::tryLogUserIn($_POST['username'], $_POST['password']);

            if(isPostSetAndNotEmpty('rd')) {
                header("Location: " . $_POST['rd']);
            } else {
                redirectToRoot();
            }

        } catch (Exception $e) {
            LogLogger::log($_POST['username'], false);
            $_SESSION['error'] = "Mot de passe ou nom d'utilisateur incorrect.";
            header("Location: login.php");
            return;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>

<?php if(isset($_SESSION['error'])) {
    echo '<div class="error"><h2>';
    echo $_SESSION['error'];
    echo '</h2></div>';
    unset($_SESSION['error']);
}  ?>

<div class="form">
    <h2>TrackPark</h2>
    <form action="" method="post">
        <div class="container">

            <?php if(isGetSetAndNotEmpty('rd')) echo '<input hidden name="rd" value="'. $_GET['rd'] .'"/>'?>

            <label for="username"><b>Nom d'utilisateur</b></label>
            <input type="text" placeholder="Nom d'utilisateur" name="username" required>

            <label for="password"><b>Mot de passe</b></label>
            <input type="password" placeholder="Mot de passe" name="password" required>

            <button type="submit">Connection</button>
        </div>
    </form>
</div>

</body>
</html>
