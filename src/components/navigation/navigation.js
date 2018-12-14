/**************************************************************************************
Fichier :       navigation.js
Auteur :        Olivier Lemay Dostie
Fonctionnalité : Affichage du menu et du haut de page.
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
import '../../css/navigation/navigation.css';
import Header from './header';
import Menu from './menu';

export default class Navigation extends Component {
  render(props) {
    return (
      <div id="navigation" className="navigation">
        {/* TrackPark2 menu */}
        <Menu
          active={this.props.active}
          handler={this.props.handler} />
        {/* TrackPark2 header */}
        <Header
          title={this.props.active} />
      </div>
    );
  }
}
