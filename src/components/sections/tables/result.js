/**************************************************************************************
Fichier :       result.js
Auteur :        Antoine Gagnon
Fonctionnalité : Tableau contenant une liste de résultat d'évaluation.
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
import ResultStates from "../../../api/ResultStates";

/**
 * Tableau d'information sur une liste d'athlete
 */
class ResultTable extends Component {
  render() {
    const evaluations = this.props.evaluations;
    return (
      <Table celled id="result-table" className="unstackable">
        <Table.Header>
          <Table.Row>
            <Table.HeaderCell>Réussite</Table.HeaderCell>
            <Table.HeaderCell>Total</Table.HeaderCell>
            <Table.HeaderCell>État</Table.HeaderCell>
          </Table.Row>
        </Table.Header>
        <Table.Body>
          {evaluations.map(evaluation => (
              <Table.Row key={evaluation.id} negative={evaluation.result_state === ResultStates.FAILEd} positive={evaluation.result_state === ResultStates.PASSED} >
              <Table.Cell>{this.props.success}</Table.Cell>
              <Table.Cell>{this.props.tries}</Table.Cell>
              <Table.Cell>
                {" "}
                {evaluation.result_state === ResultStates.FAILEd
                  ? "Raté"
                  : evaluation.result_state === ResultStates.TODO
                    ? "À faire"
                    : "Passé"}
              </Table.Cell>
            </Table.Row>
          ))}
        </Table.Body>
      </Table>
    );
  }
}

export default withRouter(ResultTable);
