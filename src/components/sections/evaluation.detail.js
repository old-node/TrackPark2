import React, { Component } from "react";
import { Table } from "semantic-ui-react";
import { withRouter } from "react-router-dom";

import CoachTable from "./tables/coach";
import DrillTable from "./tables/drill";
import ResultTable from "./tables/result";

import AthleteAPI from "../../api/athlete";
import CoachAPI from "../../api/coach";
import EvaluationAPI from "../../api/evaluation";
import DrillAPI from "../../api/drill";
import ResultStates from "../../api/ResultStates";
import EvaluationButtons from "./evaluation.buttons.js";

class EvaluationDetail extends Component {
  constructor(props) {
    super(props);

    this.state = {
      error: null,
      isLoaded: false,
      evaluation: null,
      success: 0,
      tries: 0,
    };

    // Méthodes des boutons
    this.addSuccess = this.addSuccess.bind(this);
    this.addTries = this.addTries.bind(this);
    this.isOver = this.isOver.bind(this);
    this.isSuccess = this.isSuccess.bind(this);
  }

  async componentDidMount() {
    //Querries to the API to get all the information needed
    let evaluationId = this.props.match.params.id;

    await EvaluationAPI.get(evaluationId)
      .then(result => this.setState({ evaluation: result[0], 
                                      success: result[0].numerical_value,
      }))
      .then(() =>
        Promise.all([
          DrillAPI.get(this.state.evaluation.drill).then(
            result => this.setState({ drill: result[0],
                                      tries: result[0].allowed_tries})
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

      if (this.state.evaluation.result_state === ResultStates.TODO) {
        this.setState({tries: 0})
      }
  }

  // Ajoute un succès
  addSuccess = async function() {
    if (this.state.evaluation.result_state !== ResultStates.TODO) {
        return;
    }
    console.log("passed");
    let newSuccess = this.state.success + 1;

    await this.setState({
        success: newSuccess
    })

    this.addTries()
} 

  // Ajoute un essai
  addTries = async function() {
      if (this.state.evaluation.result_state !== ResultStates.TODO) {
          return;
      }
      let newTries = this.state.tries + 1;

      await this.setState({
          tries: newTries
      });

      // Update la DB
      await EvaluationAPI.update(this.state.evaluation.id, {value: this.state.success});

      // Vérifie si c'est le dernier essai avant la fin de l'exercice
      if (this.isOver()) {
          let newEval = this.state.evaluation;

          if (this.isSuccess()) {
            newEval.result_state = ResultStates.PASSED;
          } else {
            newEval.result_state = ResultStates.FAILEd;
          }
          
          await this.setState({
              evaluation: newEval     
          }) 

          // Update la DB
          await EvaluationAPI.update(this.state.evaluation.id, {value: this.state.success, state: this.state.evaluation.result_state});
      }
  }

  // Vérifie si l'exercice est terminé
  isOver() {
      return this.state.tries >= this.state.drill.allowed_tries;
  }

  // Vérifie si c'est un succès
  isSuccess() {
      return this.state.success >= this.state.drill.success_treshold;
  }

  render() {
    const { error, isLoaded, athlete, drill, evaluation } = this.state;
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

          <h2>Résultat</h2>
          <ResultTable evaluations={[this.state.evaluation]}></ResultTable>

          <h2>Éxercice</h2>
          <DrillTable drills={[drill]}></DrillTable>

          <EvaluationButtons addSuccess={this.addSuccess} 
                             addTries={this.addTries} 
                             isOver={this.isOver} 
                             isSuccess={this.isSuccess}
                             success={this.state.success}
                             tries={this.state.tries} />
        </div>
      );
    }
  }
}

export default withRouter(EvaluationDetail);
