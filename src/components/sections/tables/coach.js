/**************************************************************************************
Fichier :       coach.js
Auteur :        Antoine Gagnon
Fonctionnalité : Tableau contenant une liste d'évaluateur.
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
 * Tableau d'information sur un coach
 */
class coachTable extends Component {
  render() {
    const coachs = this.props.coachs;
    return (
      <Table celled id="coach-table" className="clickableTable unstackable">
        <Table.Header>
          <Table.Row>
            <Table.HeaderCell className="tblNom">Nom</Table.HeaderCell>
            <Table.HeaderCell className="tblPrenom">Prénom</Table.HeaderCell>
            <Table.HeaderCell className="tblTel">Téléphone</Table.HeaderCell>
            <Table.HeaderCell className="tblPhoto">Photo</Table.HeaderCell>
          </Table.Row>
        </Table.Header>
        <Table.Body>
          {coachs.map(coach => (
            <Table.Row key={coach.id}>
              <Table.Cell>{coach.name}</Table.Cell>
              <Table.Cell>{coach.first_name}</Table.Cell>
              <Table.Cell>{coach.phone_number}</Table.Cell>
              <Table.Cell className="imgTable"><img src={coach.profile_image_url }
                alt={coach.firstname + ' ' + coach.name} width="75px" ></img></Table.Cell>
            </Table.Row>
          ))}
        </Table.Body>
      </Table>
    );
  }
}

export default withRouter(coachTable);


