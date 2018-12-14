import React, { Component } from "react";
import { Table } from "semantic-ui-react";
import { withRouter } from "react-router-dom";

/**
 * Tableau d'information sur une liste de groupe
 */
class GroupTable extends Component {
  openGroup(id) {
    window.location.replace(`/group/${id}`);
  }
  render() {
    const groups = this.props.groups;
    return (
      <Table className="clickableTable unstackable" celled id="group-table">
        <Table.Header>
          <Table.Row>
            <Table.HeaderCell>Nom</Table.HeaderCell>
            <Table.HeaderCell>Description</Table.HeaderCell>
            <Table.HeaderCell>Nb At.</Table.HeaderCell>
          </Table.Row>
        </Table.Header>
        <Table.Body>
          {groups.map(group => (
            <Table.Row onClick={() => this.openGroup(group.id)} key={group.id}>
              <Table.Cell>{group.name}</Table.Cell>
              <Table.Cell>{group.description}</Table.Cell>
              <Table.Cell>{group.nb_athletes}</Table.Cell>
            </Table.Row>
          ))}
        </Table.Body>
      </Table>
    );
  }
}

export default withRouter(GroupTable);
