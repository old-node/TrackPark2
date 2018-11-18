import React, { Component } from "react";
import { Table, Button } from "semantic-ui-react";
import { withRouter, Link } from "react-router-dom";

class GroupTable extends Component {
  render() {
    const groups = this.props.groups;
    return (
      <Table celled id="group-table">
        <Table.Header>
          <Table.Row>
            <Table.HeaderCell>Nom</Table.HeaderCell>
            <Table.HeaderCell>Description</Table.HeaderCell>
          </Table.Row>
        </Table.Header>
        <Table.Body>
          {groups.map(group => (
            <Table.Row key={group.id}>
              <Table.Cell>{group.name}</Table.Cell>
              <Table.Cell>{group.description}</Table.Cell>
              <Table.Cell>
                <Link to={`/group/${group.id}`}>
                  <Button color="green" icon="right arrow" />
                </Link>
              </Table.Cell>
            </Table.Row>
          ))}
        </Table.Body>
      </Table>
    );
  }
}

export default withRouter(GroupTable);