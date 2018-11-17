import React, { Component } from "react";
import { withRouter } from "react-router-dom";
import AuthManager from "./AuthManager";
import "../css/login.css";

class AuthCheckHack extends Component {
  constructor(props) {
    super(props);
  }

  componentWillMount() {
    console.log(AuthManager.coach_id);
    console.log(AuthManager.isLoggedIn());
    if (!AuthManager.isLoggedIn() && !window.location.href.includes("login")) {
      window.location.replace("login");
    }
  }

  render() {
    return <div />;
  }
}

export default withRouter(AuthCheckHack);
