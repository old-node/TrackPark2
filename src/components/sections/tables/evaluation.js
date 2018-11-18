import React, { Component } from "react";
import { Table, Button } from "semantic-ui-react";
import { withRouter, Link } from "react-router-dom";

import ResultStates from "../../../api/ResultStates";

class evaluationTable extends Component {
  render() {
    const evaluations = this.props.evaluations;
    return (
        <Table celled id="evaluation-table">
          <Table.Header>
            <Table.Row>
              <Table.HeaderCell>Nom</Table.HeaderCell>
              <Table.HeaderCell>État</Table.HeaderCell>
              <Table.HeaderCell>Note</Table.HeaderCell>
              <Table.HeaderCell>Date</Table.HeaderCell>
            </Table.Row>
          </Table.Header>
          <Table.Body>
            {evaluations.map(evaluation => (
              <Table.Row key={evaluation.id} negative={evaluation.result_state === ResultStates.FAILEd} positive={evaluation.result_state === ResultStates.PASSED}>
                <Table.Cell>{evaluation.drill_name}</Table.Cell>
                <Table.Cell>{evaluation.result_state === ResultStates.FAILEd ? "Raté" : evaluation.result_state === ResultStates.TODO ? "À faire" : "Passé" }</Table.Cell>
                <Table.Cell>{evaluation.result_message}</Table.Cell>
                <Table.Cell>{evaluation.date}</Table.Cell>
                <Table.Cell>
                  <Link to={`/evaluation/${evaluation.id}`}><Button color="green" icon="right arrow" /></Link>
                </Table.Cell>
              </Table.Row>
            ))}
          </Table.Body>
        </Table>
    );
  }
}

export default withRouter(evaluationTable);