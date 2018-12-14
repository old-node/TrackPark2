/**************************************************************************************
Fichier :       exercice.list.js
Auteur :        Antoine Gagnon
Fonctionnalité : Liste d'exercice.
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

import GroupAPI from "../../api/group";
import GroupTable from "./tables/groups";
import AuthManager from "../../auth/AuthManager"

class GroupList extends Component {
  constructor(props) {
    super(props);

    this.state = {
      error: null,
      isLoaded: false,
      groups: []
    };
  }

  async componentDidMount() {
    GroupAPI.ofCoach(AuthManager.getCoachId()).then(
      result => {
        this.setState({
          isLoaded: true,
          groups: result
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
    const { error, isLoaded, groups } = this.state;
    if (error) {
      return <div>Error: {error.message}</div>;
    } else if (!isLoaded) {
      return <div>Loading...</div>;
    } else {
      return (
        <div>
          <h1>Groupes que vous évaluez</h1>
          <GroupTable groups={groups} />
        </div>
      );
    }
  }
}

export default withRouter(GroupList);
