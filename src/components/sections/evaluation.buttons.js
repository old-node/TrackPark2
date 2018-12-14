/**************************************************************************************
Fichier :       evaluation.buttons.js
Auteur :        Francis Forest
Fonctionnalité : Boutons servant à l'évaluation.
Date :          22 novembre 2018
=======================================================================================
Vérification :
Date        Nom                     Approuvé
=======================================================================================
Historique de modification :
Date        Nom                     Description
2018-12-14	Olivier Lemay Dostie    Ajout des description
**************************************************************************************/

import React, { Component } from "react";
import { withRouter } from "react-router-dom";

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
