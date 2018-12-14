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
        }
    }

    // Affichage des boutons
    render() {
        return (
            <div>
                <span id='success'>Succès : {this.props.success}</span>
                <span id='total'>Essais : {this.props.tries}</span>
                <button className='ui button' onClick={this.props.addSuccess}>Succès</button>
                <button className='ui button' onClick={this.props.addTries}>Raté</button>
            </div>
        )
    }
}

export default withRouter(EvaluationButtons);
