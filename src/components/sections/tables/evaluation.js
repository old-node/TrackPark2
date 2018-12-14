import React, { Component } from "react";
import { Table } from "semantic-ui-react";
import { withRouter } from "react-router-dom";

import ResultStates from "../../../api/ResultStates";

/**
 * Tableau d'information sur une liste d'évaluation'
 */
class evaluationTable extends Component {
  openEvaluation(id) {
    window.location.replace(`/evaluation/${id}`);
  }
  render() {
    const evaluations = this.props.evaluations;
    const status = this.props.status;
    let filteredEvaluations = null;

    if (status !== undefined) {
      filteredEvaluations = evaluations.filter(evaluation => evaluation.result_state === status)
    } else {
      filteredEvaluations = evaluations.filter(evaluation => evaluation.result_state !== ResultStates.TODO);
    }
    
    return (
      <Table className="clickableTable unstackable" celled id="evaluation-table">
        <Table.Header>
          <Table.Row>
            <Table.HeaderCell>Athlète</Table.HeaderCell>
            <Table.HeaderCell className="tableCellMobile">Nom</Table.HeaderCell>
            <Table.HeaderCell>État</Table.HeaderCell>
            <Table.HeaderCell>Res.</Table.HeaderCell>
            <Table.HeaderCell>Total</Table.HeaderCell>
            <Table.HeaderCell>Seuil</Table.HeaderCell>
            <Table.HeaderCell>Date</Table.HeaderCell>
          </Table.Row>
        </Table.Header>
        <Table.Body>
          {filteredEvaluations.map(evaluation => (
            <Table.Row
              className="clickableTable"
              onClick={() => this.openEvaluation(evaluation.id)}
              key={evaluation.id}
              negative={evaluation.result_state === ResultStates.FAILEd}
              positive={evaluation.result_state === ResultStates.PASSED}
            >
              <Table.Cell>{evaluation.athlete_first_name + ' ' + evaluation.athlete_name}</Table.Cell>
              <Table.Cell className="tableCellMobile">{evaluation.drill_name}</Table.Cell>
              <Table.Cell>
                {evaluation.result_state === ResultStates.FAILEd
                  ? "Raté"
                  : evaluation.result_state === ResultStates.TODO
                    ? "À faire"
                    : "Passé"}
              </Table.Cell>
              <Table.Cell>{evaluation.numerical_value}</Table.Cell>
              <Table.Cell>{evaluation.allowed_tries}</Table.Cell>
              <Table.Cell>{evaluation.success_treshold}</Table.Cell>
              
              <Table.Cell>{evaluation.date}</Table.Cell>
            </Table.Row>
          ))}
        </Table.Body>
      </Table>
    );
  }
}

export default withRouter(evaluationTable);
