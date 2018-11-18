import React, { Component } from "react";
import { Table, Button, Icon } from "semantic-ui-react";
import { withRouter, Link } from "react-router-dom";

import GroupAPI from "../../api/group";
import AuthManager from "../../auth/AuthManager";

class GroupList extends Component {
  constructor(props) {
    super(props);

    this.state = {
      error: null,
      isLoaded: false,
      groups: []
    };
  }

  async componentDidMount() {
    GroupAPI.all(AuthManager.getCoachId()).then(
      result => {
        this.setState({
          isLoaded: true,
          groups: result
        });
      },
      error => {
        this.setState({
          isLoaded: true,
          error
        });
      }
    );
  }
  render() {
    const { error, isLoaded, groups } = this.state;
    if (error) {
      return <div>Error: {error.message}</div>;
    } else if (!isLoaded) {
      return <div>Loading...</div>;
    } else {
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
                  <Button color="green" icon="right arrow" />
                </Table.Cell>
              </Table.Row>
            ))}
          </Table.Body>
        </Table>
      );
    }
  }
}

export default withRouter(GroupList);
