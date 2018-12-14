/**************************************************************************************
Fichier :       athlete.list.js
Auteur :        Antoine Gagnon
Fonctionnalité : Liste d'athlète.
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

import AthleteTable from "./tables/athlete";

import AthleteAPI from "../../api/athlete";
import AuthManager from "../../auth/AuthManager";

class AthleteList extends Component {
  constructor(props) {
    super(props);

    this.state = {
      error: null,
      isLoaded: false,
      athletes: []
    };
  }

  async componentDidMount() {
    AthleteAPI.withCoach(AuthManager.getCoachId()).then(
      result => {
        this.setState({
          isLoaded: true,
          athletes: result
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
    const { error, isLoaded, athletes } = this.state;
    if (error) {
      return <div>Error: {error.message}</div>;
    } else if (!isLoaded) {
      return <div>Loading...</div>;
    } else {
      return (
        <div>
          <h1>Athlètes que vous évaluez</h1>
          <AthleteTable athletes={athletes} />
        </div>
      );
    }
  }
}

export default withRouter(AthleteList);
