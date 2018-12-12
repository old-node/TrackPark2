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
      <Table celled id="result-table">
        <Table.Header>
          <Table.Row>
            <Table.HeaderCell>État</Table.HeaderCell>
            <Table.HeaderCell>Résultat</Table.HeaderCell>
          </Table.Row>
        </Table.Header>
        <Table.Body>
          {evaluations.map(evaluation => (
              <Table.Row key={evaluation.id} negative={evaluation.result_state === ResultStates.FAILEd}
              positive={evaluation.result_state === ResultStates.PASSED}>
              <Table.Cell>
                {" "}
                {evaluation.result_state === ResultStates.FAILEd
                  ? "Raté"
                  : evaluation.result_state === ResultStates.TODO
                    ? "À faire"
                    : "Passé"}
              </Table.Cell>
              <Table.Cell>{evaluation.numerical_value}</Table.Cell>
            </Table.Row>
          ))}
        </Table.Body>
      </Table>
    );
  }
}

export default withRouter(ResultTable);
