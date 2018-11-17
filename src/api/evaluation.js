import APIRequestHandler from "./APIRequestHandler";
import Endpoints from "./Endpoints";

const EvaluationAPI = {
  all: async function() {
    return APIRequestHandler.query(Endpoints.EVALUATION);
  },
  get: async function(id) {
    return APIRequestHandler.query(Endpoints.EVALUATION + `?id=${id}`);
  },
  ofAthlete: async function(id) {
    return APIRequestHandler.query(Endpoints.EVALUATION + `?athlete=${id}`);
  },
  ofCoach: async function(id) {
    return APIRequestHandler.query(Endpoints.EVALUATION + `?coach=${id}`);
  }
};

export default EvaluationAPI;
