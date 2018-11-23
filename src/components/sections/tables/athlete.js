import React, { Component } from "react";
import { Table } from "semantic-ui-react";
import { withRouter } from "react-router-dom";

/**
 * Tableau d'information sur une liste d'athlete
 */
class AthleteTable extends Component {
  constructor(props) {
    super(props)
  }
  
  
  openAthlete(id) {
    window.location.replace(`/athlete/${id}`);
  }

  render() {
    const athletes = this.props.athletes;
    return (
      <Table celled id="athlete-table" className="clickableTable">
        <Table.Header>
          <Table.Row>
            <Table.HeaderCell>Nom</Table.HeaderCell>
            <Table.HeaderCell>Prenom</Table.HeaderCell>
          </Table.Row>
        </Table.Header>
        <Table.Body>
          {athletes.map(athlete => (
            <Table.Row key={athlete.id} onClick={() => this.openAthlete(athlete.id)}>
              <Table.Cell>{athlete.name}</Table.Cell>
              <Table.Cell>{athlete.first_name}</Table.Cell>
            </Table.Row>
          ))}
        </Table.Body>
      </Table>
    );
  }
}

export default withRouter(AthleteTable);
