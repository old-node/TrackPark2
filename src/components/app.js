import React, { Component } from "react";
import Navigation from "./navigation/navigation";
import Content from "./content/content";
import Footnote from "./footnote/footnote";
import AuthCheckHack from "../auth/auth";

//import logo from './logo.svg'
//require('../css/app.css')

class App extends Component {
  render() {
    return (
      <div>
        <AuthCheckHack />
        <Navigation />
        <Content />
        <Footnote />
      </div>
    );
  }
}

export default App;