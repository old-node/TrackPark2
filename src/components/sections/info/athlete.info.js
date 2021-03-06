/**************************************************************************************
Fichier :       athlete.info.js
Auteur :        Antoine Gagnon
Fonctionnalité : Fiche d'information sur un athlète.
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
import { Image } from "semantic-ui-react";
import { withRouter } from "react-router-dom";

/**
 * Informations détaillés sur un athlete
 */
class AthleteInfo extends Component {
  render() {
    const athlete = this.props.athlete; //Informations de l'athlètes
    //this.props.handler()
    return (
      <div className="col12 colt12 colm12 floatLeft">
        <Image
          circular={true}
          className="col3 colt3 colm12 floatLeft"
          src={athlete.profile_image_url}
        />
        <div className="col9 colt9 colm12 infoBox">
          <h1>
            {athlete.first_name} {athlete.name}
          </h1>
          <h2>Contact</h2>
          <ul className="infoList">
            <li>{athlete.phone_number}</li>
            <li>{athlete.email}</li>
          </ul>
          <h2>Info</h2>
          <ul className="infoList">
            <li>{athlete.profile_info}</li>
            <li>{athlete.comments}</li>
          </ul>
        </div>
      </div>
    );
  }
}

export default withRouter(AthleteInfo);
