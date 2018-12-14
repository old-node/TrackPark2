/**************************************************************************************
Fichier :       evaluation.list.js
Auteur :        Francis Forest
Fonctionnalité : Liste des évaluations.
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

import EvaluationAPI from "../../api/evaluation";
import EvaluationTable from "./tables/evaluation";
import AuthManager from "../../auth/AuthManager";
import ResultStates from "../../api/ResultStates";

class EvaluationList extends Component {
  constructor(props) {
    super(props);

    this.state = {
      error: null,
      isLoaded: false,
      evaluations: []
    };
  }

  async componentDidMount() {
    EvaluationAPI.ofCoach(AuthManager.getCoachId()).then(
      result => {
        this.setState({
          isLoaded: true,
          evaluations: result
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
    const { error, isLoaded, evaluations } = this.state;
    if (error) {
      return <div>Error: {error.message}</div>;
    } else if (!isLoaded) {
      return <div>Loading...</div>;
    } else {
      return (
        <div>
          <h1>Évaluations</h1>
          <h3>À faire</h3>
          <EvaluationTable evaluations={evaluations} status={ResultStates.TODO} />
          <h3>Terminées</h3>
          <EvaluationTable evaluations={evaluations} />
        </div>
        );
    }
  }
}

export default withRouter(EvaluationList);
