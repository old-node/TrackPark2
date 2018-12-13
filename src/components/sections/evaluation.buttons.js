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
            success: this.props.evaluation.numerical_value,
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

    addTries = async function() {
        if (this.state.state !== ResultStates.TODO) {
            return;
        }

        let newTries = this.state.tries + 1;

        await this.setState({
            tries: newTries
        });

        await EvaluationAPI.update(this.state.evaluation.id, {value: this.state.success});

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

            await EvaluationAPI.update(this.state.evaluation.id, {value: this.state.success, state: newState});
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
                <button className='ui button' onClick={this.addSuccess}>Succ&egrave;s</button>
                <button className='ui button' onClick={this.addTries}>Rat&eacute;</button>
            </div>
        )
    }
}

export default withRouter(EvaluationButtons);
