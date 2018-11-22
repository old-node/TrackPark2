import React, { Component } from "react";
import { Table } from "semantic-ui-react";
import { withRouter } from "react-router-dom";

import CoachTable from "./tables/coach";

import AthleteAPI from "../../api/athlete";
import CoachAPI from "../../api/coach";
import EvaluationAPI from "../../api/evaluation";
import DrillAPI from "../../api/drill";
import ResultStates from "../../api/ResultStates";

class EvaluationDetail extends Component {
  constructor(props) {
    super(props);

    this.state = {
      error: null,
      isLoaded: false,
      evaluation: null
    };
  }

  async componentDidMount() {
    //Querries to the API to get all the information needed
    let evaluationId = this.props.match.params.id;

    EvaluationAPI.get(evaluationId)
      .then(
        result => {
          this.state.evaluation = result[0];
        },
        error => {
          this.state.error = error;
        }
      )
      .then(() =>
        Promise.all([
          DrillAPI.get(this.state.evaluation.drill).then(
            result => {
              this.state.drill = result[0];
            },
            error => {
              this.state.error = error;
            }
          ),
          AthleteAPI.get(this.state.evaluation.athlete).then(
            result => {
              this.state.athlete = result[0];
            },
            error => {
              this.state.error = error;
            }
          ),
          CoachAPI.get(this.state.evaluation.coach).then(
            result => {
              this.state.coach = result;
            },
            error => {
              this.state.error = error;
            }
          )
        ]).then(() => {
          this.state.isLoaded = true;
          this.forceUpdate();
        })
      );
  }

  render() {
    const { error, isLoaded, athlete, coach, drill, evaluation } = this.state;
    if (error) {
      return <div>Error: {error.message}</div>;
    } else if (!isLoaded) {
      return <div>Loading...</div>;
    } else {
      return (
        <div>
          <h1>
            Évaluation de {athlete.first_name} {athlete.name} -{" "}
            {evaluation.date}
          </h1>
          <h2>Éxercice</h2>
          <Table celled id="drill-table">
            <Table.Header>
              <Table.Row>
                <Table.HeaderCell>Nom</Table.HeaderCell>
                <Table.HeaderCell>Objectif</Table.HeaderCell>
                <Table.HeaderCell>Essaies alloués</Table.HeaderCell>
                <Table.HeaderCell>Objectif réussite</Table.HeaderCell>
                <Table.HeaderCell>Casquette</Table.HeaderCell>
              </Table.Row>
            </Table.Header>
            <Table.Body>
              <Table.Row key={drill.id}>
                <Table.Cell>{drill.name}</Table.Cell>
                <Table.Cell>{drill.goal}</Table.Cell>
                <Table.Cell>{drill.allowed_tries}</Table.Cell>
                <Table.Cell>{drill.success_treshold}</Table.Cell>
                <Table.Cell>{drill.cap}</Table.Cell>
              </Table.Row>
            </Table.Body>
          </Table>
          <h2>Résultat</h2>
          <Table celled id="result-table">
            <Table.Header>
              <Table.Row>
                <Table.HeaderCell>État</Table.HeaderCell>
                <Table.HeaderCell>Résultat</Table.HeaderCell>
              </Table.Row>
            </Table.Header>
            <Table.Body>
              <Table.Row negative={evaluation.result_state === ResultStates.FAILEd} positive={evaluation.result_state === ResultStates.PASSED} key={evaluation.id}>
                <Table.Cell>
                  {" "}
                  {evaluation.result_state === ResultStates.FAILEd
                    ? "Raté"
                    : evaluation.result_state === ResultStates.TODO
                      ? "À faire"
                      : "Passé"}
                </Table.Cell>
                <Table.Cell>{evaluation.numerical_value}</Table.Cell>
              </Table.Row>
            </Table.Body>
          </Table>
          <h2>Coach</h2>
          <CoachTable coachs={coach} />
        </div>
      );
    }
  }
}

export default withRouter(EvaluationDetail);
