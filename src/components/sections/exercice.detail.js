import React, { Component } from "react";
import { withRouter } from "react-router-dom";
import { List } from 'semantic-ui-react'
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
      drill: null,
      evaluations: [],
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
      return (
        <div>
          <h3>Nom</h3>
          <span className="drillInfo">{drill.name}</span>
          <h3>Description</h3>
          <span className="drillInfo">{drill.goal}</span>

          <h3>Informations</h3>

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
                      <List.Header>Casquette: {drill.cap}</List.Header>
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
