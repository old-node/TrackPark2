/**************************************************************************************
Fichier :       user.js
Auteur :        Antoine Gagnon
Fonctionnalité : Validifie le formulaire de création ou de modification
 * d'un utilisateur.
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
    var form = document.forms["userFrm"];

    if(form["username"].value === "") {
        alert("Veuillez enter un nom d'utilisateur");
        return false;
    }

    if(form["type"].value === "") {
        alert("Veuillez sélectionner un type d'utilisateur");
        return false;
    }
}