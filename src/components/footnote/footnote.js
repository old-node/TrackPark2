/**************************************************************************************
Fichier :       footnote.js
Auteur :        Olivier Lemay Dostie
Fonctionnalité : Affichage complet du pied de page.
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
//import '../../css/footnote/footnote.css';
import Footer from './footer';
import Toast from './toast';

export default class Footnote extends Component {
  render(props) {
    return (
      <div id="footnote" className="footnote col12 colt12 colm12 floatLeft">
        <h2>
        </h2>
        <Footer />
        <Toast />
      </div>
    );
  }
}

