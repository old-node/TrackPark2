import React, { Component } from "react";
import { Table } from "semantic-ui-react";
import { withRouter } from "react-router-dom";

/**
 * Tableau d'information sur une liste d'athlete
 */
class DrillTable extends Component {
  openDrill(id) {
    window.location.replace(`/drill/${id}`);
  }

  render() {
    const drills = this.props.drills;
    return (
      <Table celled id="drill-table" className="unstackable">
        <Table.Header>
          <Table.Row>
            <Table.HeaderCell>Nom</Table.HeaderCell>
            <Table.HeaderCell>Essais</Table.HeaderCell>
            <Table.HeaderCell>Objectif</Table.HeaderCell>
            <Table.HeaderCell>Casquette</Table.HeaderCell>
          </Table.Row>
        </Table.Header>
        <Table.Body>
          {drills.map(drill => (
            <Table.Row key={drill.id}>
              <Table.Cell>{drill.name}</Table.Cell>
              <Table.Cell>{drill.allowed_tries}</Table.Cell>
              <Table.Cell>{drill.success_treshold}</Table.Cell>
              <Table.Cell>{drill.cap}</Table.Cell>
            </Table.Row>
          ))}
        </Table.Body>
      </Table>
    );
  }
}

export default withRouter(DrillTable);
