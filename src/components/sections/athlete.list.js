import React, { Component } from "react";
import { Table } from "semantic-ui-react";
import { withRouter } from "react-router-dom";
import AthleteAPI from "../../api/athlete";

import GroupAPI from "../../api/group";

class AthleteList extends Component {
  constructor(props) {
    super(props);

    this.state = {
      error: null,
      isLoaded: false,
      athletes: []
    };
  }

  componentDidMount() {
    AthleteAPI.all().then(
      result => {
        this.setState({
          isLoaded: true,
          athletes: result
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
    const { error, isLoaded, athletes } = this.state;
    if (error) {
      return <div>Error: {error.message}</div>;
    } else if (!isLoaded) {
      return <div>Loading...</div>;
    } else {
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
              <Table.Row>
                <Table.Cell>{athlete.name}</Table.Cell>
                <Table.Cell>{athlete.first_name}</Table.Cell>
              </Table.Row>
            ))}
          </Table.Body>
        </Table>
      );
    }
  }
}

export default withRouter(AthleteList);
