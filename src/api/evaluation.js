import APIRequestHandler from "./APIRequestHandler";
import Endpoints from "./Endpoints";

const EvaluationAPI = {
  all: async function() {
    return APIRequestHandler.query(Endpoints.EVALUATION);
  },
  get: async function(id) {
    return APIRequestHandler.query(`${Endpoints.EVALUATION}?id=${id}`);
  },
  ofAthlete: async function(id) {
    return APIRequestHandler.query(`${Endpoints.EVALUATION}?athlete=${id}`);
  },
  ofCoach: async function(id) {
    return APIRequestHandler.query(`${Endpoints.EVALUATION}?coach=${id}`);
  },
  update: async function(id, options) { //TODO: test this
    let body = {
        id: id
    }

    if(options.state !== undefined) {
        body.state = options.state;
    }

    if(options.value !== undefined) {
        body.numerical_value = options.value;
    }
    return APIRequestHandler.post(Endpoints.EVALUATION, body);
  }
};

export default EvaluationAPI;
