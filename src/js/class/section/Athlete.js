/**************************************************************************************
Fichier :       Athlete.js
Auteur :        Olivier Lemay Dostie
Fonctionallité : Classe déservant les athlètes à évaluer
Date :          2018-11-10
=======================================================================================
Vérification :
Date		    Nom					            Approuvé

=======================================================================================
Historique de modification :
Date		    Nom						          Description
2018-11-10	Olivier Lemay Dostie    Création
**************************************************************************************/

import athlete_i from './athlete_i'
import Person from '../Person'

class Athlete extends Person {
  constructor(id, address, category, gender,
    firstName, lastName, birthday, email, phoneNumber,
    profileImageUrl, profileInfo, comments/*, etc*/) {
    super(3, id, address, category, gender,
      firstName, lastName, birthday, email, phoneNumber,
      profileImageUrl, profileInfo, comments);
    this._athlete = athlete_i;
    this._athlete.section = 3;
    //this._athlete.etc = etc;
  }

  get get() {
    let athlete = super.get();
    //athlete.etc = this.etc();
  return athlete;
  }
  set set(athlete: athlete_i) {
    constructor(athlete.section, athlete.id,
      athlete.firstName, athlete.lastName,
      athlete.birthday, athlete.email,athlete.phoneNumber,
      athlete.profileImageUrl, athlete.profileInfo, athlete.comments/*, etc*/);
  }

  get section() {
    return super.section();
  }

  get etc() {
    return this._athlete.etc;
  }
  set etc(etc) {
    //this._athlete.etc = etc;
  }


};

export default Athlete;
