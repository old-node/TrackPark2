/**************************************************************************************
Fichier :       Coach.js
Auteur :        Olivier Lemay Dostie
Fonctionallité : Classe déservant les évaluateurs
Date :          2018-11-10
=======================================================================================
Vérification :
Date		    Nom					            Approuvé

=======================================================================================
Historique de modification :
Date		    Nom						          Description
2018-11-10	Olivier Lemay Dostie    Création
**************************************************************************************/

import coach_i from './coach_i'
import Person from '../Person'

class Coach extends Person {
  constructor(id, address, category, gender,
    firstName, lastName, birthday, email, phoneNumber,
    profileImageUrl, profileInfo, comments/*, etc*/) {
    super(3, id, address, category, gender,
      firstName, lastName, birthday, email, phoneNumber,
      profileImageUrl, profileInfo, comments);
    this._coach = coach_i;
    this._coach.section = 3;
    //this._coach.etc = etc;
  }

  get get() {
    let coach = super.get();
    //coach.etc = this.etc();
  return coach;
  }
  set set(coach: coach_i) {
    constructor(coach.section, coach.id,
      coach.firstName, coach.lastName,
      coach.birthday, coach.email,coach.phoneNumber,
      coach.profileImageUrl, coach.profileInfo, coach.comments/*, etc*/);
  }

  get section() {
    return super.section();
  }

  get etc() {
    return this._coach.etc;
  }
  set etc(etc) {
    //this._coach.etc = etc;
  }


};

export default Coach;
