/**************************************************************************************
Fichier :       home.js
Auteur :        Olivier Lemay Dostie
Fonctionnalité : Fichier central de l'application TrackPark2.
Date :          22 novembre 2018
=======================================================================================
Vérification :
Date        Nom                     Approuvé
=======================================================================================
Historique de modification :
Date        Nom                     Description
2018-12-13	Francis Forest          Ajout du contenu
2018-12-14	Olivier Lemay Dostie    Ajout des description et modification du titre
**************************************************************************************/

import React, { Component } from 'react';
import AuthManager from "../auth/AuthManager";
import '../css/home.css';
import CoachAPI from '../api/coach';
import GroupAPI from '../api/group';
import GroupTable from "./sections/tables/groups";

export default class Home extends Component {
  constructor(props) {
    super(props)
    this.props.setTitle("TrackPark2")

    this.state = {
      error: null,
      isLoaded: false,
      coach: null,
      groups: null,
    }
  }

  async componentDidMount() {
    let id = await AuthManager.getCoachId();

    await CoachAPI.get(id)
      .then(result => this.setState({ coach: result[0], }))
      .then(() =>
        Promise.all([
          GroupAPI.ofCoach(id).then(
            result => this.setState({ groups: result})
          )
        ]).then(() => {
          this.setState({ isLoaded: true });
        })
      ).catch((error) => this.setState({ error: error }));
  }

  render(props) {
    const { error, isLoaded, groups } = this.state;
    if (error) {
      return <div>Error: {error.message}</div>;
    } else if (!isLoaded) {
      return <div>Loading...</div>;
    } else {
      return (
        <div id="home" className="home">
          <h1>TrackPark2</h1>
          <h3>Bonjour {this.state.coach.first_name} {this.state.coach.name}</h3>
          <h3>Voici vos groupes à évaluer</h3>
          <GroupTable groups={groups} />
        </div>
      );
    }
  }
}
