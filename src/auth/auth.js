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
