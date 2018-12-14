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
            <div className="buttonContainer">
                <button className='ui button positive basic floatLeft' onClick={this.props.addSuccess}>Réussite</button>
                <button className='ui button negative basic floatLeft' onClick={this.props.addTries}>Échec</button>
            </div>
        )
    }
}

export default withRouter(EvaluationButtons);
