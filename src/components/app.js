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
        <Content value="test" />
        <Footnote />
      </div>
    );
  }
}

export default App;

/*
    <h1>
        App Component
    </h1>
  <header className="app-header">
    <img src={logo} className="app-logo" alt="logo" />
    <p>
      Edit <code>src/app.js</code> and save to reload.
    </p>
  </header>
  <header id="navigation"></header>
  <main id="content"></main>
  <footer id="footnote"></footer>
*/
