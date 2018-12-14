/**************************************************************************************
Fichier :       auth.js
Auteur :        Antoine Gagnon
Fonctionnalité : Autentification de l'utilisateur.
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
import AuthManager from "./AuthManager";
import "../css/login.css";

/**
 * Component qui vérifie si l'utilisateur est connecté
 */
class AuthCheckHack extends Component {

  componentWillMount() {

    //Redirect to login if user isn't logged in
    if (!AuthManager.isLoggedIn() && !window.location.href.includes("login")) {
      window.location.replace("login");
    }
  }

  render() {
    return <div />;
  }
}

export default withRouter(AuthCheckHack);
