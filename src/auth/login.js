/**************************************************************************************
Fichier :       login.js
Auteur :        Antoine Gagnon
Fonctionnalité : Connexion d'un utilisateur.
Date :          22 novembre 2018
=======================================================================================
Vérification :
Date        Nom                     Approuvé
=======================================================================================
Historique de modification :
Date        Nom                     Description
2018-12-14	Olivier Lemay Dostie    Ajout des description
**************************************************************************************/

import React, { Component } from "react";
import { withRouter } from "react-router-dom";
import AuthManager from './AuthManager';

/**
 * Login box component
 */
class Login extends Component {

  constructor(props) {
    super(props);

    this.loginClick = this.loginClick.bind(this);
    this.handleKeyPress = this.handleKeyPress.bind(this);
  }

  loginClick() {
    let username = document.getElementById('username').value;
    let password = document.getElementById('password').value;

    //Login and redirect to home page
    AuthManager.auth(username, password)
      .then(() => {
        window.location.replace('/')
      });
  }

  handleKeyPress(event) {
    //Fire login when enter is pressed
    if (event.key === 'Enter') {
      this.loginClick();
    }
  }

  render() {
    return (
      <div className="form">
        <label for="username"><b>Nom d'utilisateur</b></label><br />
        <input onKeyPress={this.handleKeyPress} id='username' type="text" placeholder="Nom d'utilisateur" name="username" required /><br />

        <label for="password"><b>Mot de passe</b></label><br />
        <input onKeyPress={this.handleKeyPress} id='password' type="password" placeholder="Mot de passe" name="password" required /><br />

        <button class="green-button" onClick={this.loginClick}>Connexion</button>
      </div>
    );
  }
}

export default withRouter(Login);
