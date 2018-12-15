/**************************************************************************************
Fichier :       app.js
Auteur :        Olivier Lemay Dostie
Fonctionnalité : Fichier central de l'application TrackPark2.
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
import Navigation from "./navigation/navigation";
import Content from "./content/content";
import Footnote from "./footnote/footnote";
import AuthCheckHack from "../auth/auth";
import { toggleMenu } from '../functions';

//import logo from './logo.svg'
//require('../css/app.css')

class App extends Component {
  constructor(props) {
    super(props)
    this.handler = this.handler.bind(this)
    this.state = {
      active: "Accueil",
      title: "",
    }
  }

  //Handler pour le changement de page dans l'application
  handler = (value) => {
    toggleMenu()
    this.setState({
      active: value
    })
  }

  render() {
    return (
      <div>
        <AuthCheckHack />
        <Navigation
          title={this.state.title}
          active={this.state.active}
          handler={this.handler} />
        <Content handler={this.handler} />
        <Footnote />
      </div>
    );
  }
}

export default App;