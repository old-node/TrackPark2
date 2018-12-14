/**************************************************************************************
Fichier :       header.js
Auteur :        Olivier Lemay Dostie
Fonctionnalité : Affichage du haut de page.
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
import '../../css/navigation/header.css';

export default class Header extends Component {
  render(props) {
    let hClass = "topMenu col12 colt12 colm12 floatLeft"
    this.props = { title: "" }
    if (this.props.title === "") {
      hClass += " header"
    } else {
      hClass += " headerWithText"
    }

    return (
      <header id="header" className={hClass} >
        <h3 className="blackHeader">
          {this.props.title}
        </h3>
      </header>

    );
  }
}
