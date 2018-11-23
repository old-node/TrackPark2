import React, { Component } from "react";
import Navigation from "./navigation/navigation";
import Content from "./content/content";
import Footnote from "./footnote/footnote";
import AuthCheckHack from "../auth/auth";
import { parkgroup } from '../constants';

//require('../css/app.css')

class App extends Component {
  constructor(props) {
    super(props);

    parkgroup.path = "/parktest"
    
    // TODO: Get the section and the title related to the current path
    let active = "login"
    let title = "Connexion"
  }
  
  
  render() {
    return (
      <div>
        <AuthCheckHack />
        <Navigation title={this.title} active={this.active} />
        <Content section={parkgroup}/>
        <Footnote />
      </div>
    );
  }
}

export default App;