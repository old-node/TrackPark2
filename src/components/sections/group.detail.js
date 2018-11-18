import React, { Component } from "react";
import { Table, Button, Icon } from "semantic-ui-react";
import { withRouter, Link } from "react-router-dom";

import GroupAPI from "../../api/group";
import AthleteAPI from "../../api/athlete";
import CoachAPI from "../../api/coach";

class GroupDetail extends Component {
  constructor(props) {
    super(props);

    this.state = {
      error: null,
      isLoaded: false,
      group: null
    };
  }

  async componentDidMount() {
    let groupId = this.props.match.params.id;

    Promise.all([
      GroupAPI.get(groupId).then(
        result => {
          this.state.group = result[0];
        },
        error => {
          this.state.error = error;
        }
      ),
      AthleteAPI.inGroup(groupId).then(
        result => {
          this.state.athletes = result;
        },
        error => {
          this.state.error = error;
        }
      ),
      CoachAPI.forGroup(groupId).then(
        result => {
          this.state.coachs = result;
        },
        error => {
          this.state.error = error;
        }
      )
    ]).then(() => {
      this.state.isLoaded = true;
      this.forceUpdate();
    });
  }

  render() {
    const { error, isLoaded, group, athletes, coachs } = this.state;
    if (error) {
      return <div>Error: {error.message}</div>;
    } else if (!isLoaded) {
      return <div>Loading...</div>;
    } else {
      return (
        <div>
            <h1>{group.name}</h1>
            <h2>{group.description}</h2>

            <h3>Évaluateurs</h3>
            <Table celled id="eval-table">
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

            <h3>Athletes</h3>
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
                </Table.Row>
            ))}
            </Table.Body>
            </Table>
        </div>
      );
    }
  }
}

export default withRouter(GroupDetail);
