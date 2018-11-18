import React, { Component } from "react";
import { Table, Button, Icon } from "semantic-ui-react";
import { withRouter, Link } from "react-router-dom";

import AthleteTable from "./tables/athlete";
import CoachTable from "./tables/coach";

import GroupAPI from "../../api/group";
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
            Évaluation de {athlete.first_name} {athlete.name} - {evaluation.date}
          </h1>
            <h2>Éxercice</h2>
            Nom: {drill.name}<br />
            Objectif: {drill.goal}<br />
            Nombre d'essai alloués: {drill.allowed_tries}<br/>
            Objectif pour réussir: {drill.success_treshhold}<br/>
            Résultat pour rater: {drill.failure_treshhold}<br/>
            Cap: {drill.cap}<br/>

            <h2>Résultat</h2>
            État: {evaluation.result_state === ResultStates.FAILEd ? "Raté" : evaluation.result_state === ResultStates.TODO ? "À faire" : "Passé" }<br />
            Résultat: {evaluation.numerical_value}<br />

            <h2>Coach</h2>
            <CoachTable coachs={coach} />
        </div>
      );
    }
  }
}

export default withRouter(EvaluationDetail);
