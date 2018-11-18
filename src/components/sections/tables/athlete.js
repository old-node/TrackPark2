import React, { Component } from "react";
import { Table, Button } from "semantic-ui-react";
import { withRouter, Link } from "react-router-dom";

class AthleteTable extends Component {
  render() {
    const athletes = this.props.athletes;
    return (
        <Table celled id="athlete-table">
          <Table.Header>
            <Table.Row>
              <Table.HeaderCell>Nom</Table.HeaderCell>
              <Table.HeaderCell>Prenom</Table.HeaderCell>
            </Table.Row>
          </Table.Header>
          <Table.Body>
            {athletes.map(athlete => (
              <Table.Row key={athlete.id}>
                <Table.Cell>{athlete.name}</Table.Cell>
                <Table.Cell>{athlete.first_name}</Table.Cell>
                <Table.Cell>
                  <Link to={`/athlete/${athlete.id}`}><Button color="green" icon="right arrow" /></Link>
                </Table.Cell>
              </Table.Row>
            ))}
          </Table.Body>
        </Table>
    );
  }
}

export default withRouter(AthleteTable);