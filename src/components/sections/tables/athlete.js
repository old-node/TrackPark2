/**************************************************************************************
Fichier :       athlete.js
Auteur :        Olivier Lemay Dostie
Fonctionnalité : Tableau contenant une liste d'athlètes.
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
import { Table } from "semantic-ui-react";
import { withRouter } from "react-router-dom";
import '../../../css/tables.css';
/**
 * Tableau d'information sur une liste d'athlete
 */
class AthleteTable extends Component {
  openAthlete(id) {
    window.location.replace(`/athlete/${id}`);
  }

  render() {
    const athletes = this.props.athletes;
    return (
      <Table celled id="athlete-table" className="clickableTable unstackable">
        <Table.Header>
          <Table.Row>
          <Table.HeaderCell className="tblNom">Nom</Table.HeaderCell>
            <Table.HeaderCell className="tblPrenom">Prenom</Table.HeaderCell>
            <Table.HeaderCell className="tblTel">Tel</Table.HeaderCell>
            <Table.HeaderCell className="tblPhoto">Photo</Table.HeaderCell>
          </Table.Row>
        </Table.Header>
        <Table.Body>
          {athletes.map(athlete => (
            <Table.Row key={athlete.id} onClick={() => this.openAthlete(athlete.id)}>
              <Table.Cell>{athlete.name}</Table.Cell>
              <Table.Cell>{athlete.first_name}</Table.Cell>
              <Table.Cell>{athlete.phone_number}</Table.Cell>
            <Table.Cell className="imgTable"><img src={athlete.profile_image_url} alt={athlete.firstname + ' ' + athlete.name} width="75px"></img></Table.Cell>
            </Table.Row>
          ))}
        </Table.Body>
      </Table>
    );
  }
}

export default withRouter(AthleteTable);
