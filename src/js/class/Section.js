/**************************************************************************************
Fichier :       Section.js
Auteur :        Olivier Lemay Dostie
Fonctionallité : Classe qui gère les sections de TrackPark2
Date :          2018-11-10
=======================================================================================
Vérification :
Date        Nom                     Approuvé
2018-1
=======================================================================================
Historique de modification :
Date        Nom                     Description
2018-11-10	Olivier Lemay Dostie    Création
**************************************************************************************/

import React from 'react';

class Section extends React.Component {
  constructor(section) {
    super();
    this._section = section;
  }

  get get() {
    return Section;
  }

  get a() {
    return this._section.a;
  }
  set a(a) {
    this._section.a = a;
  }

  render(props) {
    //let section = props.section;
    return (
      Section
    );
  }
};

export default Section;
