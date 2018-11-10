/**************************************************************************************
Fichier :       cap.js
Auteur :        Antoine Gagnon
Fonctionnalité : Validifie le formulaire de création ou de modification d'une caquette.
Date :          5 mai 2018
=======================================================================================
Vérification :
Date        Nom                     Approuvé
2018-05-06  Olivier Lemay Dostie    Oui
=======================================================================================
Historique de modification :
Date        Nom                     Description
2018-05-05	Antoine Gagnon          Création
**************************************************************************************/

function validateForm() {
    var form = document.forms["capFrm"];

    if(form["code"].value === "") {
        alert("Veuillez enter un code");
        return false;
    }

    if(form["name"].value === "") {
        alert("Veuillez enter un nom");
        return false;
    }

    if(form["description"].value === "") {
        alert("Veuillez enter une description");
        return false;
    }

    var hexPattern = /^[0-9a-f]{3,6}$/i;

    if(form["color"].value === "") {
        alert("Veuillez enter un code");
        return false;
    }

    if(!hexPattern.test(form["color"].value)) {
        alert("Couleur invalide");
        return false;
    }
}