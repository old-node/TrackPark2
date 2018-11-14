<?php
/**************************************************************************************
Fichier :       editCap.php
Auteur :        Antoine Gagnon
Fonctionnalité : Permet la modification de casquette
Date :          28 avril 2018
=======================================================================================
Vérification :
Date        Nom	                    Approuvé
2018-05-06  Olivier Lemay Dostie    Oui
=======================================================================================
Historique de modification :
Date        Nom	                    Description
2018-04-28  Antoine Gagnon          Création
2018-04-28  Olivier Lemay Dostie    Versionnement pour merger
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
include_once 'Cap.class.php';
include_once 'HTMLUtil.php';

/**
 *
 */
if (isPost()) {

    $cap = null;
    if (isPostSetAndNotEmpty('code')) {
        $cap = Cap::fromID($_POST['code']);
    }

    if (is_null($cap)) {
        http_response_code(400);
        return;
    }

    if (isPostSetAndNotEmpty('name')) {
        $cap->setName($_POST['name']);
    }

    if (isPostSetAndNotEmpty('description')) {
        $cap->setDescription($_POST['description']);
    }

    if (isPostSetAndNotEmpty('color')) {
        $cap->setColor($_POST['color']);
    }
    header("Location: manageCap.php");
    return;
}

$cap = null;

if (isset($_GET['code'])) {
    $cap = Cap::fromID($_GET['code']);
}

if (is_null($cap)) {
    header("Location: manageCap.php");
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
    <script src="js/cap.js"></script>
    <title><?php echo $cap->getName(); ?></title>
</head>
<body class="modal-content animate padding30">

<h1><?php echo $cap->getName(); ?></h1>

<form action="" onsubmit="return validateForm()" method="POST" name="capFrm">

    <label for="code">Code: </label>
    <input disabled type="text" name="" value="<?php echo $cap->getCode()?>">
    <input style="visibility: hidden" hidden type="text" name="code" id="code" value="<?php echo $cap->getCode()?>">
    <br><br>

    <label for="name">Nom: </label>
    <input type="text" name="name" id="name" value="<?php echo $cap->getName()?>">
    <br><br>

    <label for="description">Description: </label>
    <textarea name="description"><?php echo $cap->getDescription()?></textarea>
    <br><br>

    <label for="color">Couleur: </label>
    #<input type="text" name="color" id="color" value="<?php echo $cap->getColor()?>">
    <br><br>

    <br><br>
    <button type="submit">Enregistrer modifications</button>
</form>

<form class='modifAthlete' id='form'  action="/TrackPark-P2/person/athlete/UIWAthleteManager.php"
      method="post" onsubmit="return confirm('Êtes-vous sûr de vouloir enregistrer cet athlète?')">

  <table border="1">
    <tr>
      <td>
        <input type="image" id="profile" width="100" height="200" alt="Image du profil"
               src=""><br>
        <label for='profile_image_url'>URL de l'image</label><br>
        <input type='url' name='profile_image_url' id="profile_image_url"><br><br>
      </td>
      <td>
        <label for='firstname'>Prénom</label>
        <input type='text' name='firstname' id="firstname"><br><br>

        <label for='name'>Nom de famille</label>
        <input type='text' name='name' id="name"><br><br>

        <label for='gender'>Genre</label>
        <select name='gender' id='gender'>
          <option id='0' value='0'>Inconnu</option>
          <option id='1' value='1'>Homme</option>
          <option id='2' value='2'>Femme</option>
          <option id='9' value='9'>Non applicable</option>
        </select><br><br>

        <label for='dob'>Date de naissance</label>
        <input type='date' name='dob' id="dob"><br><br>

        <label for='creation_date'>Date d'inscription</label>
        <input type='date' name='creation_date' id="creation_date"><br><br>

        <label for='inactive'>Inactif</label>
        <input type='checkbox' name='inactive' id="inactive" value="false"><br><br>
      </td>
    </tr>
    <tr>
      <td>
        <label for='phone_number'>Numéro de téléphone</label><br>
        <input type='tel' name='phone_number' id="phone_number"><br><br>

        <label for='email'>Adresse courriel</label><br>
        <input type='email' name='email' id="email"><br><br>

        <label for='caps'>Casquettes obtenues</label><br>
        <p id='caps'>Aucune casquette</p><br>

        <label for='new_cap'>Ajouter une casquette</label><br>
        <select name='new_cap' id='new_cap'>
          <option id='1' value='1'>Blanche</option>
          <option id='2' value='2'>Grise</option>
          <!-- Ajouter les autres avec une function si désiré...
          Il sera peux-être préférable de limiter l'interface pour
          que l'administrateur ne puisse donner que la casquette
          suivante que l'athlète pourait obtenir. -->
        </select><br>
        <!-- Changer soit la value du bouton en fonction du select
        ou avoir un deuxième bouton programmé comme le suivant:
        <input type="button" value="Rétrograder"> -->
        <input type="button" value="Promouvoir">
      </td>
      <td>
        <label for='address'>Adresse</label><br>
        <textarea name='address' id='address' cols='40' rows='2'></textarea><br><br>

        <label for='profile_info'>Description du profil</label><br>
        <textarea name='profile_info' id='profile_info' cols='40' rows='5'></textarea><br><br>

        <label for='comments'>Commentaires</label><br>
        <textarea name='comments' id='comments' cols='40' rows='5'></textarea><br><br>
      </td>
    </tr>
  </table>
  <button  type='submit' value={$_GET['id']} name='id'>Enregistrer</button>
</body>
</html>
