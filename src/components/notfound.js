/**************************************************************************************
Fichier :       notfound.js
Auteur :        Olivier Lemay Dostie
Fonctionnalité : Page de redirection si une page est introuvable. (Erreur 404)
Date :          22 novembre 2018
=======================================================================================
Vérification :
Date        Nom                     Approuvé
=======================================================================================
Historique de modification :
Date        Nom                     Description
2018-12-14	Olivier Lemay Dostie    Ajout des description
**************************************************************************************/

import React, { Component } from 'react';
export default class NotFound extends Component {
  render(props) {
    return (
      <div id="home" className="home">
        <h3>
            404 Not Foud
        </h3>
      </div>
    );
  }
}
