/**************************************************************************************
Fichier :       toast.js
Auteur :        Olivier Lemay Dostie
Fonctionnalité : Affichage d'une notification dans le bas de page.
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
//import '../../css/footnote/toast.css';

export default class Toast extends Component {
  render(props) {
    return (
      <div id="toast" className="toast">
        <h3>
        </h3>
      </div>
    );
  }
}
