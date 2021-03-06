/**************************************************************************************
Fichier :       parc.js
Auteur :        Jean-Alain Sainton
Fonctionnalité : Tableau contenant une liste de parc.
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

/**
 * Tableau d'information sur une liste d'parc
 */
class ParcTable extends Component {
  render() {
    const parcs = this.props.parcs;
    return (
      <Table celled id="parc-table" className="clickableTable unstackable">
        <Table.Header>
          <Table.Row>
            <Table.HeaderCell>Nom</Table.HeaderCell>
            <Table.HeaderCell>Adresse</Table.HeaderCell>
          </Table.Row>
        </Table.Header>
        <Table.Body>
          {parcs.map(parc => (
            <Table.Row key={parc.id}>
              <Table.Cell>{parc.name}</Table.Cell>
              <Table.Cell>  <div id='googlemap'><a href={"https://www.google.com/maps/search/?api=1&query="+ parc.address.replace(" ", "+") }  target="_blank" rel="noopener noreferrer" alt="Lien vers Google Map">{parc.address} </a> </div></Table.Cell>
            </Table.Row>
          ))}
        </Table.Body>
     </Table>
    );
  }
}

export default withRouter(ParcTable);
