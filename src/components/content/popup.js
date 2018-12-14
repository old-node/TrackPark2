/**************************************************************************************
Fichier :       popup.js
Auteur :        Olivier Lemay Dostie
Fonctionnalité : Fenêtre modale ou non affiché dans la section actuelle.
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
import '../../css/content/popup.css';

export default class Popup extends Component {
  render(props) {
    return (
      <div id="popup" className="popup">
      </div>
    );
  }
}
