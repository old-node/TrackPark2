<?php
/**************************************************************************************
Fichier :       UIWCoachManager.php
Auteur :		    Olivier Lemay Dostie
Fonctionallité : Fichier qui construit la maquete UIWCoachManager.
Affiche le gestionnaire des évaluateurs.
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

include_once "HTMLUtil.php";
include_once "CtrlGeneral.php";

include_once "Coach.class.php";
include_once "CoachManager.class.php";
//include_once "SQLConnector.class.php";
CoachManager::init();

if ($_SERVER['REQUEST_METHOD'] === "POST")
{
  updateCoach();
}

function writeTable()
{
  echo "<table>";
  echo "<tr>" . makeCellTH("Nom") . makeCellTH("Courriel") . "</tr>";

  foreach (CoachManager::getPersons() as $c)
  {
    echo "<tr>";
    echo makeCell($c->getFullname()) . makeCell($c->getEmail());
    echo makeCell(makeButtonModifyCustom("editCoach.php?id=".$c->getId(), $c->getId()));
    echo makeCell(makeButtonDeleteCustom("deleteCoach.php",$c->getId()));
    echo "</tr>";
  }

  echo "</table><br>";
}


function makeAddCoachButton()
{
  echo "<button class='buttonAdd' value='1' name='addCoach' onclick='addNewCoach(); showModalWindow();'>Ajouter un évaluateur</button>";
}

function updateCoach()
{
  $coach = Coach::fromId((int)$_POST['id']);
  $coach->initCoach($_POST['id'], $_POST['address'], $_POST['gender'],
  $_POST['firstname'], $_POST['name'],$_POST['dob'],$_POST['email'], $_POST['phone_number'],
  $_POST['profile_image_url'], $_POST['profile_info'], $_POST['comments'], $_POST['creation_date'],
  false, $_POST['inactive']);
  CoachManager::updateCoach($coach);
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="./css/stylesheet.css">
  <title>TrackPark - Évaluateurs</title>

  <script src="js/util.js"></script>
  <script>

    function saveCoach(idCoach)
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
          document.getElementById("infoCoach").innerHTML = this.responseText;
          window.location = window.location.pathname;
        }
      };

      xmlhttp.open("GET", "infoDrill.php?saveCoach="+idCoach+
          "&address="+address+"&category="+category+"&gender="+gender+
          "&firstname="+firstname+"&lastname="+lastname+
          "&birthday="+birthday+"&email="+email+"&phone_number="+phone_number+
          "&profile_image_url="+profile_image_url+"&profile_info="+profile_info+"&=comments"+comments+
          /*"&availabilities="+availabilities+"&holidays="+holidays+"&banned="+banned+*/
          "&inactive="+inactive+"&creation_date="+creation_date+
          "&caps="+caps+"&groups="+groups+"&evals="+evals,true);
      xmlhttp.send();
    }

    function addNewCoach()
    {
      let xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function()
      {
        if (this.readyState === 4 && this.status === 200)
        {
          document.getElementById("infoCoach").innerHTML = this.responseText;
        }
      };
      xmlhttp.open("GET", "infoCoach.php?addCoach=1",true);
      xmlhttp.send();
    }

    function deleteCoach(idCoach)
    {
      if (!confirmWindow("Êtes-vous sûr de vouloir supprimer cet évaluateur?"))
      {
        return;
      }
      let xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function()
      {
        if (this.readyState === 4 && this.status === 200)
        {
          document.getElementById("infoCoach").innerHTML = this.responseText;
        }
      };

      xmlhttp.open("GET", "infoCoach.php?idDeleteCoach"+idCoach,true);
      xmlhttp.send();

      location.reload();
    }

    function  modifyCoach(id)
    {
      let xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function()
      {
        if (this.readyState === 4 && this.status === 200)
        {
          console.log(id);
          document.getElementById("infoCoach").innerHTML = this.responseText;
        }
      };
      xmlhttp.open("GET", "infoCoach.php?id="+id,true);
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

  <div class="topMenu col12 colt12 colm12 floatLeft">
    <div class="col2 colt2 colm12 floatLeft"> &nbsp; </div>
    <div class="col10 colt10 colm12 floatLeft">
      <div class="title col6 colt6 colm6 floatLeft">
        <h1 > Gestion des évaluateurs </h1>
      </div>
      <div class="floatLeft col2 colt2 colm12">
          <?php makeAddCoachButton(); ?>
      </div>
      <div class="floatLeft col4 colt4 colm12">
        <button class="buttonImport">Importer des données</button>
      </div>
    </div>
  </div>

  <div class="col2 colt2 colm12 floatLeft">
    &nbsp;
  </div>

  <div class="mainContent floatLeft col10 colt10 colm12">
      <?php writeTable(); ?>
  </div>
</div>

<div class="modal" id="modalWindow">
  <div class="modal-content animate padding30" id="infoCoach">
  </div>
</div>

</body>
</html>
