/**************************************************************************************
Fichier :       Identite.js
Auteur :        Olivier Lemay Dostie
Fonctionallité : Classe parente aux objets de section de TrackPark2
Date :          2018-11-10
=======================================================================================
Vérification :
Date		    Nom                     Approuvé
2018-1
=======================================================================================
Historique de modification :
Date		    Nom                     Description
2018-11-10	Olivier Lemay Dostie    Création
**************************************************************************************/

import React from 'react';
import identite_i from './identite_i'

class Identite extends React.Component {
  constructor(section, id) {
    super();
    this._identite = identite_i;
    this._identite.section = section;
    this._identite.id = id;
  }

  get get() {
    return this._identite;
  }
  set set(identite: identite_i) {
      constructor(identite.section, identite.id);
  }

  get section() {
    if (this.constructor === Identite) {
      throw new Error("Can't instantiate abstract class!");
    }
      return this._identite.section;
  }

  get id() {
    return this._identite.id;
  }
  set id(id) {
    this._identite.id = id;
  }

};

export default Identite;
