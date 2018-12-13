import React, { Component } from "react";
import { withRouter } from "react-router-dom";
import EvaluationAPI from "../../api/evaluation";
import ResultStates from "../../api/ResultStates";

// Contient les boutons pour évaluer un athlète sur un exercice
class EvaluationButtons extends Component {
    constructor(props) {
        super(props);

        // Variables des boutons
        this.state = {
            error: null,
            isLoaded: false,
            success: this.props.evaluation.numerical_value,
            tries: 0,
            evaluation: this.props.evaluation,
            drill: this.props.drill,
            state: this.props.evaluation.result_state
        }

        // Méthodes des boutons
        this.addSuccess = this.addSuccess.bind(this);
        this.addTries = this.addTries.bind(this);
        this.isOver = this.isOver.bind(this);
        this.isSuccess = this.isSuccess.bind(this);
    }

    // Ajoute un succès
    addSuccess = async function() {
        if (this.state.state !== ResultStates.TODO) {
            return;
        }
        let newSuccess = this.state.success + 1;

        await this.setState({
            success: newSuccess
        })

        this.addTries()
    } 

    // Ajoute un essai
    addTries = async function() {
        if (this.state.state !== ResultStates.TODO) {
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
            let newState = null;
            
            if (this.isSuccess()) {
                newState = ResultStates.PASSED;
            } else {
                newState = ResultStates.FAILEd;
            }
            
            await this.setState({
                state: newState      
            }) 

            // Update la DB
            await EvaluationAPI.update(this.state.evaluation.id, {value: this.state.success, state: newState});
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

    // Affichage des boutons
    render() {
        return (
            <div>
                <span id='success'>Succès : {this.state.success}</span>
                <span id='total'>Total : {this.state.drill.allowed_tries}</span>
                <button className='ui button' onClick={this.addSuccess}>Succès</button>
                <button className='ui button' onClick={this.addTries}>Raté</button>
            </div>
        )
    }
}

export default withRouter(EvaluationButtons);
