/**************************************************************************************
Fichier :       Person.js
Auteur :        Olivier Lemay Dostie
Fonctionallité : Classe parente aux personnes de TrackPark2
Date :          2018-11-10
=======================================================================================
Vérification :
Date		    Nom					            Approuvé
2018-1
=======================================================================================
Historique de modification :
Date		    Nom						          Description
2018-11-10	Olivier Lemay Dostie    Création
**************************************************************************************/

import Identite from './Identite';
import person_i from './person_i'

class Person extends Identite {
  constructor(section, id, address, category, gender,
    firstName, lastName, birthday, email, phoneNumber,
    profileImageUrl, profileInfo, comments) {
    super(section, id);
    this._person = person_i;
    this._person.firstName = firstName;
    this._person.lastName = lastName;
    this._person.birthday = birthday;
    this._person.email = email;
    this._person.phoneNumber = phoneNumber;
    this._person.profileImageUrl = profileImageUrl;
    this._person.profileInfo = profileInfo;
    this._person.comments = comments;
  }

  get get() {
      let person = this._person;
      person.section = super.section();
      person.id = super.id();
    return person;
  }
  set set(person: person_i) {
      constructor(person.section, person.id,
        person.firstName, person.lastName,
        person.birthday, person.email,person.phoneNumber,
        person.profileImageUrl, person.profileInfo, person.comments);
  }

  get section() {
    if (this.constructor === Person) {
      throw new Error("Can't instantiate abstract class!");
    }
      return super.section();
  }

  get address() {
    return this._person.address;
  }
  set address(address) {
    this._person.address = address;
  }

  get category() {
    return this._person.category;
  }
  set category(category) {
    this._person.category = category;
  }

  get gender() {
    return this._person.gender;
  }
  set gender(gender) {
    this._person.gender = gender;
  }

  get firstName() {
    return this._person.firstName;
  }
  set firstName(firstName) {
    this._person.firstName = firstName;
  }

  get lastName() {
    return this._person.lastName;
  }
  set lastName(lastName) {
    this._person.lastName = lastName;
  }

  get birthday() {
    return this._person.birthday;
  }
  set birthday(birthday) {
    this._person.birthday = birthday;
  }

  get email() {
    return this._person.email;
  }
  set email(email) {
    this._person.email = email;
  }

  get phoneNumber() {
    return this._person.phoneNumber;
  }
  set phoneNumber(phoneNumber) {
    this._person.phoneNumber = phoneNumber;
  }

  get profileImageUrl() {
    return this._person.profileImageUrl;
  }
  set profileImageUrl(profileImageUrl) {
    this._person.profileImageUrl = profileImageUrl;
  }

  get profileInfo() {
    return this._person.profileInfo;
  }
  set profileInfo(profileInfo) {
    this._person.profileInfo = profileInfo;
  }

  get comments() {
    return this._person.comments;
  }
  set comments(comments) {
    this._person.comments = comments;
  }

  get fullName() {
      return this.firstName() +" "+ this.lastName();
  }


};

export default Person;
