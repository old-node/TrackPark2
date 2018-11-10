/**************************************************************************************
Fichier :       util.js
Auteur :        Antoine Gagnon
Fonctionnalité : Fonctions utilitaires pour l'application Web TrackPark.
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

/**
 * Permet de rediriger l'utilisateur vers une autre page.
 *
 * @param url
 */
function redirect(url) {
    location.href = url;
}

function confirmWindow(message)
{
  return confirm(message);
}

/**
 * Affiche un message et procède à une action.
 *
 * @param message
 * @param action
 */
function confirmAndDo(message, action = null) {
    if(confirm(message)) {
        action();
    }
}

/**
 *
 */
function makeWindowModal() {
  window.onclick = function(event)
  {
    let modal = document.getElementById("modalWindow");

    if (event.target === modal)
    {
      modal.style.display = "none";
    }
  };
}