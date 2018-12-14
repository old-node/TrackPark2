/**************************************************************************************
Fichier :       parc.group.js
Auteur :        Jean-Alain Sainton
Fonctionnalité : Liste des parcs.
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

import ParcTable from "./tables/parc";

import ParcAPI from "../../api/parc";
// import AuthManager from "../../auth/AuthManager";

class ParcList extends Component {
  constructor(props) {
    super(props);

    this.state = {
      error: null,
      isLoaded: false,
      parcs: []
    };
  }

  async componentDidMount() {
    ParcAPI.all().then(
      result => {
        this.setState({
          isLoaded: true,
          parcs: result
        });
      },
      error => {
        this.setState({
          isLoaded: true,
          error
        });
      }
    );
  }

  render() {
    //this.setState({state:{active:"Carte des parcs"}})
    const { error, isLoaded, parcs } = this.state;
    if (error) {
      return <div>Error: {error.message}</div>;
    } else if (!isLoaded) {
      return <div>Loading...</div>;
    } else {
      return (
        <div>
          <h1>Cartes des parcs</h1>
          <ParcTable parcs={parcs} />
        </div>
      );
    }
  }
}

export default withRouter(ParcList);
