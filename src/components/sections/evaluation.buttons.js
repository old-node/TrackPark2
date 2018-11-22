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
    }

    addSuccess = function() {
        if (this.isOver()) {
            return;
        }
        let newSuccess = this.state.success + 1;

        this.setState({
            success: newSuccess
        }, () => this.addTries())
    } 

    addTries() {
        if (this.isOver()) {
            return;
        }

        let newTries = this.state.tries + 1;

        this.setState({
            tries: newTries
        }, () => {
            console.log("Success : " + this.state.success);
            console.log("Tries   : " + this.state.tries);
            console.log("Total   : " + this.state.total);
            console.log("ID      : " + this.state.evaluation.id);
            console.log("State   : " + this.state.state);
            console.log(this.state.drill);
            console.log(this.state.evaluation);
            console.log(this.state);

            EvaluationAPI.update(this.state.evaluation.id, {value: this.state.success, state: this.state.state});

        })
    }

    isOver() {
        if (this.state.state !== ResultStates.TODO) {
            return true;
        }

        if (this.state.tries >= this.state.drill.allowed_tries) {
            // Show Success or Failure
            this.setState({
                state: ResultStates.PASSED
            }, EvaluationAPI.update(this.state.evaluation.id, {value: this.state.success, state: this.state.state}))
            
            return true;
        }

        return false;
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
