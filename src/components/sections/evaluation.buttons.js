import React, { Component } from "react";
import { withRouter } from "react-router-dom";
import EvaluationAPI from "../../api/evaluation";
import ResultStates from "../../api/ResultStates";

class EvaluationButtons extends Component {
    constructor(props) {
        super(props);

        this.state = {
            error: null,
            isLoaded: false,
            success: 0,
            tries: 0,
            evaluation: this.props.evaluation,
            drill: this.props.drill,
            state: this.props.evaluation.result_state
        }

        this.addSuccess = this.addSuccess.bind(this);
        this.addTries = this.addTries.bind(this);
        this.isOver = this.isOver.bind(this);
        this.isSuccess = this.isSuccess.bind(this);
    }

    addSuccess = function() {
        if (this.state.state !== ResultStates.TODO) {
            return;
        }
        let newSuccess = this.state.success + 1;

        this.setState({
            success: newSuccess
        }, () => this.addTries())
    } 

    addTries() {
        if (this.state.state !== ResultStates.TODO) {
            return;
        }

        let newTries = this.state.tries + 1;

        this.setState({
            tries: newTries
        }, () => {
            
            EvaluationAPI.update(this.state.evaluation.id, {value: this.state.success, state: this.state.state});
        })

        if (this.isOver()) {
            let newState = null;
            
            if (this.isSuccess()) {
                newState = ResultStates.PASSED;
            } else {
                newState = ResultStates.FAILEd;
            }
            
            this.setState({
                state: newState      
            }, () => {
                EvaluationAPI.update(this.state.evaluation.id, {value: this.state.success, state: newState})
                this.render()
            }) 
        }
    }

    isOver() {
        return this.state.tries >= this.state.drill.allowed_tries;
    }

    isSuccess() {
        return this.state.success >= this.state.drill.success_treshold;
    }

    render() {
        return (
            <div>
                <span id='success'>Success : {this.state.success}</span>
                <span id='total'>Total : {this.state.drill.allowed_tries}</span>
                <button onClick={this.addSuccess}>Success</button>
                <button onClick={this.addTries}>Fail</button>
            </div>
        )
    }
}

export default withRouter(EvaluationButtons);
