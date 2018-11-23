<?php
/**************************************************************************************
Fichier :       UIWAthleteManager.php
Auteur :		    Olivier Lemay Dostie
Fonctionallité : Fichier qui construit la maquete UIWAthleteManager.
 * Affiche le gestionnaire des athlètes.
Date :          23 avril 2018
=======================================================================================
Vérification :
Date		    Nom					          Approuvé
=======================================================================================
Historique de modification :
Date		    Nom						        Description
2018-04-23	Olivier Lemay Dostie	Création
2018-04-28  Olivier Lemay Dostie	Versionnement pour merger
**************************************************************************************/

include_once 'AuthenticationManager.class.php';
include_once 'PermissionHelper.php';
include_once 'RequestUtil.php';
session_start_if_not_started();
if(!isLoggedInUserAdmin()) {
    header("Location: login.php?rd=" . getPath());
    return;
}


include_once "HTMLUtil.php";
include_once "CtrlGeneral.php";

include_once "Athlete.class.php";
include_once "AthleteManager.class.php";
include_once "Cap.class.php";
//include_once "SQLConnector.class.php";
AthleteManager::init();

if ($_SERVER['REQUEST_METHOD'] === "POST")
{
    updateAthlete();
    //echo $_POST['id'];
}


function writeTable()
{
    echo "<table class='ui celled table clickableTable'>";
    echo "<thead> <tr>" . makeCellTH("Nom") . makeCellTH("Casquette") . makeCellTH("Catégorie") . "</tr> </thead>";

    foreach (AthleteManager::getPersons() as $a)
    {
      $c = $a->getHighestCapID();
      if (empty($c)) {
          $capName = "Aucune";
      } else {
        $cap = Cap::fromID($c);
        $capName = $cap->getName();
      }
        echo "<tr>";
        echo makeCell($a->getFullname()) . makeCell($capName) . makeCell($a->fetchCategory());
        echo makeCell(makeButtonModifyCustom("editAthlete.php?id=".$a->getId(), $a->getId()));
        echo makeCell(makeButtonDeleteCustom("deleteAthlete.php",$a->getId()));
        echo "</tr>";
    }

    echo "</table><br>";
}

function makeAddAthleteButton()
{
    echo "<button class='buttonAdd' value='1' name='addAthlete' onclick='addNewAthlete(); showModalWindow();'>Ajouter un athlète</button>";
}

function updateAthlete()
{
    $athlete = Athlete::fromId($_POST['id']);
    $athlete->initAthlete($_POST['id'], $_POST['address'], $_POST['category'], $_POST['gender'],
        $_POST['firstname'], $_POST['name'],$_POST['dob'],$_POST['email'], $_POST['phone_number'],
        $_POST['profile_image_url'], $_POST['profile_info'], $_POST['comments'], $_POST['creation_date'],
        false, $_POST['inactive']);
    AthleteManager::updateAthlete($athlete);
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>TrackPark - Athlètes</title>
  <link rel="shortcut icon" href="%PUBLIC_URL%/favicon.ico">
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/semantic-ui@2.4.0/dist/semantic.min.css">
  <script src="js/util.js"></script>
  <script>

    function saveAthlete(idAthlete)
    {
      console.log("hello");
      let address = document.getElementById("address").value;
      let category = document.getElementById("category").value;
      let gender = document.getElementById("gender").value;
      let firstname = document.getElementById("firstname").value;
      let lastname = document.getElementById("lastname").value;
      let birthday = document.getElementById("birthday").value;
      let email = document.getElementById("email").value;
      let phone_number = document.getElementById("phone_number").value;
      let profile_image_url = document.getElementById("profile_image_url").value;
      let profile_info = document.getElementById("profile_info").value;
      let comments = document.getElementById("comments").value;
      //let availabilities = document.getElementById("availabilities").value;
      //let holidays = document.getElementById("holidays").value;
      //let banned = document.getElementById("banned").value;
      let inactive = document.getElementById("inactive").value;
      let creation_date = document.getElementById("creation_date").value;
      let caps = document.getElementById("caps").value;
      let groups = document.getElementById("groups").value;
      let evals = document.getElementById("evals").value;

      let xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function()
      {
        if (this.readyState === 4 && this.status === 200)
        {
          document.getElementById("infoAthlete").innerHTML = this.responseText;
          window.location = window.location.pathname;
        }
      };

      xmlhttp.open("GET", "infoDrill.php?saveAthlete="+idAthlete+
          "&address="+address+"&category="+category+"&gender="+gender+
          "&firstname="+firstname+"&lastname="+lastname+
          "&birthday="+birthday+"&email="+email+"&phone_number="+phone_number+
          "&profile_image_url="+profile_image_url+"&profile_info="+profile_info+"&=comments"+comments+
          /*"&availabilities="+availabilities+"&holidays="+holidays+"&banned="+banned+*/
          "&inactive="+inactive+"&creation_date="+creation_date+
          "&caps="+caps+"&groups="+groups+"&evals="+evals,true);
      xmlhttp.send();
    }

    function addNewAthlete()
    {
      let xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function()
      {
        if (this.readyState === 4 && this.status === 200)
        {
          document.getElementById("infoAthlete").innerHTML = this.responseText;
        }
      };
      xmlhttp.open("GET", "infoAthlete.php?addAthlete=1",true);
      xmlhttp.send();
    }

    function deleteAthlete(idAthlete)
    {
      if (!confirmWindow("Êtes-vous sûr de vouloir supprimer cet athlète?"))
      {
        return;
      }
      let xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function()
      {
        if (this.readyState === 4 && this.status === 200)
        {
          document.getElementById("infoAthlete").innerHTML = this.responseText;
        }
      };

      xmlhttp.open("GET", "infoAthlete.php?idDeleteAthlete"+idAthlete,true);
      xmlhttp.send();

      location.reload();
    }

    function  modifyAthlete(id)
    {
      let xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function()
      {
        if (this.readyState === 4 && this.status === 200)
        {
          console.log(id);
          document.getElementById("infoAthlete").innerHTML = this.responseText;
        }
      };
      xmlhttp.open("GET", "infoAthlete.php?id="+id,true);
      xmlhttp.send();
    }

    function showModalWindow()
    {
      console.log("show");
      document.getElementById("modalWindow").style.display='block';
    }

    window.onclick = function(event)
    {
      let modal = document.getElementById("modalWindow");

      if (event.target === modal)
      {
        modal.style.display = "none";
      }
    };

    function confirmWindow(message)
    {
      return confirm(message);
    }

  </script>
</head>

<body>
    <div>
        <?php include('sideMenu.html') ?>
        <div class="topMenu col12 colt12 colm12 afterMenu">
            <div class="col2 colt2 colm12 floatLeft"> &nbsp; </div>
            <div class="col10 colt10 colm12 floatLeft">
                <div class="title col6 colt6 colm6 floatLeft">
                    <h1 > Gestion des athlètes </h1>
                </div>
                <div class="floatLeft col2 colt2 colm12">
                    <?php makeAddAthleteButton(); ?>
                </div>
                <!--<div class="floatLeft col4 colt4 colm12">
                  <button class="buttonImport">Importer des données</button>
                </div>-->
            </div>
        </div>

        <div class="col2 colt2 colm12 floatLeft">
          &nbsp;
        </div>

        <div class="mainContent afterMenu col10 colt10 colm12">
            <?php writeTable(); ?>
        </div>
    </div>

    <div class="modal" id="modalWindow">
      <div class="modal-content animate padding30" id="infoAthlete">
      </div>
    </div>

</body>
</html>

