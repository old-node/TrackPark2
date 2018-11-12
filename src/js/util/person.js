/**************************************************************************************
Fichier :       person.js
Auteur :        Olivier Lemay Dostie
Fonctionnalité : Validifie le formulaire de création ou de modification d'une personne.
Date :          5 mai 2018
=======================================================================================
Vérification :
Date        Nom                     Approuvé
=======================================================================================
Historique de modification :
Date        Nom                     Description
2018-05-05	Olivier Lemay Dostie    Création
**************************************************************************************/


function validateForm(formID) {
  let form = document.forms[formID];

  /*let inputs = [form['firstname'], form['lastname']];
  let inputNames = ['prénom', 'nom de famille'];*/

  function isEmpty(id, idName) {
    if (form[id].value === "") {
      alert("Veuillez enter un "+idName+".");
      return true;
    }
    return false;
  }

  if (isEmpty('firstname', 'prénom')) {
    return false;
  }
  if (isEmpty('lastname', 'nom de famille')) {
    return false;
  }
}