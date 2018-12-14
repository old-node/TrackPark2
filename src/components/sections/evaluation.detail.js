import React, { Component } from "react";
// import { Table } from "semantic-ui-react";
import { withRouter } from "react-router-dom";

import CoachTable from "./tables/coach";
import DrillTable from "./tables/drill";
import ResultTable from "./tables/result";

import AthleteAPI from "../../api/athlete";
import CoachAPI from "../../api/coach";
import EvaluationAPI from "../../api/evaluation";
import DrillAPI from "../../api/drill";
// import ResultStates from "../../api/ResultStates";
import EvaluationButtons from "./evaluation.buttons.js";

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
      .then(result => this.setState({ evaluation: result[0] }))
      .then(() =>
        Promise.all([
          DrillAPI.get(this.state.evaluation.drill).then(
            result => this.setState({ drill: result[0] })
          ),
          AthleteAPI.get(this.state.evaluation.athlete).then(
            result => this.setState({ athlete: result[0] })
          ),
          CoachAPI.get(this.state.evaluation.coach).then(
            result => this.setState({ coach: result })
          )
        ]).then(() => {
          this.setState({ isLoaded: true });
        })
      ).catch((error) => this.setState({ error: error }));
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
          <DrillTable drills={[drill]}></DrillTable>

          <h2>Résultat</h2>
          <ResultTable evaluations={[evaluation]}></ResultTable>

          <h2>Coach</h2>
          <CoachTable coachs={coach} />
          <EvaluationButtons evaluation={evaluation} drill={drill} />
        </div>
      );
    }
  }
}

export default withRouter(EvaluationDetail);
