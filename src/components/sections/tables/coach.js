import React, { Component } from "react";
import { Table } from "semantic-ui-react";
import { withRouter } from "react-router-dom";

class coachTable extends Component {
  render() {
    const coachs = this.props.coachs;
    return (
        <Table celled id="coach-table">
          <Table.Header>
            <Table.Row>
              <Table.HeaderCell>Nom</Table.HeaderCell>
              <Table.HeaderCell>Prenom</Table.HeaderCell>
            </Table.Row>
          </Table.Header>
          <Table.Body>
            {coachs.map(coach => (
              <Table.Row key={coach.id}>
                <Table.Cell>{coach.name}</Table.Cell>
                <Table.Cell>{coach.first_name}</Table.Cell>
              </Table.Row>
            ))}
          </Table.Body>
        </Table>
    );
  }
}

export default withRouter(coachTable);