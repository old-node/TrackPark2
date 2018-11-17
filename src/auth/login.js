import React, { Component } from "react";
import { withRouter } from "react-router-dom";
import AuthManager from './AuthManager';


class Login extends Component {
  loginClick() {
    let username = document.getElementById('username').value;
    let password = document.getElementById('password').value;
    AuthManager.auth(username, password)
    .then(() => {
        window.location.replace('/')
    });
  }

  render() {
    return (
        <div className="form">
            <label for="username"><b>Nom d'utilisateur</b></label><br />
            <input id='username' type="text" placeholder="Nom d'utilisateur" name="username" required /><br />

            <label for="password"><b>Mot de passe</b></label><br />
            <input id='password' type="password" placeholder="Mot de passe" name="password" required /><br />

            <button onClick={this.loginClick}>Connexion</button>
        </div>
    );
  }
}

export default withRouter(Login);
