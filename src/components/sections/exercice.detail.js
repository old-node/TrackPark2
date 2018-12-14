import React, { Component } from "react";
import { withRouter } from "react-router-dom";
import { List } from 'semantic-ui-react'

/*import GroupTable from "./tables/groups";
import EvaluationTable from "./tables/evaluation";

import AthleteInfo from "./info/athlete.info";

import GroupAPI from "../../api/group";
import AthleteAPI from "../../api/athlete";
import EvaluationAPI from "../../api/evaluation";*/
import DrillAPI from "../../api/drill";

/**
 * Informations sur l'athlète, les groupes dont il fait partie et ses évaluations
 */
class ExerciceDetail extends Component {
  constructor(props) {
    super(props)
    this.props.setTitle("Exercices")

    this.state = {
      error: null,
      isLoaded: false,
      drill: null
    };
  }

  async componentDidMount() {

    //Querries to the API to get all the data needed
    let id = this.props.match.params.id;

    Promise.all([
      DrillAPI.get(id).then((res) => this.setState({ drill: res[0] }))
    ]).then(() => {
      this.setState({ isLoaded: true });
    }).catch((error) => {
      this.setState({ error: error });
    });
  }

  render() {
    const { error, isLoaded, drill } = this.state;
    if (error) {
      return <div>Error: {error.message}</div>;
    } else if (!isLoaded) {
      return <div>Loading...</div>;
    } else {
      console.log(drill);
      return (
        <div>
          <h1>{drill.name}</h1>
          <h2>{drill.goal}</h2>

          <List>
            <List.Item>
              <List.Icon name='thumbs up' />
              <List.Content>
                <List.Header>Objectifs</List.Header>
                <List.List>
                  <List.Item>
                    <List.Icon name='crosshairs' />
                    <List.Content>
                      <List.Header>But: {drill.goal}</List.Header>
                    </List.Content>
                  </List.Item>
                  <List.Item>
                    <List.Icon name='redo' />
                    <List.Content>
                      <List.Header>Nombre d'essaies permis: {drill.allowed_tries}</List.Header>
                    </List.Content>
                  </List.Item>
                  <List.Item>
                    <List.Icon name='clock' />
                    <List.Content>
                      <List.Header>Temps alloué: {drill.allowed_time} minutes</List.Header>
                    </List.Content>
                  </List.Item>
                </List.List>
              </List.Content>
            </List.Item>
            <List.Item>
              <List.Icon name='question' />
              <List.Content>
                <List.Header>Informations</List.Header>
                <List.List>
                  <List.Item>
                    <List.Icon name='terminal' />
                    <List.Content>
                      <List.Header>Code: {drill.id}</List.Header>
                    </List.Content>
                  </List.Item>
                  <List.Item>
                    <List.Icon name='angle double up' />
                    <List.Content>
                      <List.Header>Cap: {drill.cap}</List.Header>
                    </List.Content>
                  </List.Item>
                </List.List>
              </List.Content>
            </List.Item>
          </List>

        </div>
      );
    }
  }
}

export default withRouter(ExerciceDetail);
