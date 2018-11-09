/**************************************************************************************
 Fichier :       userType.js
 Auteur :        Antoine Gagnon
 Fonctionnalité : Validifie le formulaire de création ou de modification
 * d'un type d'utilisateur.
 Date :          5 mai 2018
 =======================================================================================
 Vérification :
 Date        Nom                     Approuvé
 =======================================================================================
 Historique de modification :
 Date        Nom                     Description
 2018-05-06	Antoine Gagnon          Création
 **************************************************************************************/

function validateForm() {
    var form = document.forms["usrTypeFrm"];

    if(form["name"].value === "") {
        alert("Veuillez enter un nom");
        return false;
    }

    if(form["description"].value === "") {
        alert("Veuillez entrer une description");
        return false;
    }

    if(form["level"].value === "") {
        alert("Veuillez entrer un niveau de permission");
        return false;
    }

    if(form["level"].value > 255 || form["level"].value < 0) {
        alert("Veuillez entrer un niveau de permission entre 0 et 255");
        return false;
    }
}