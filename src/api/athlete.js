import APIRequestHandler from "./APIRequestHandler";
import Endpoints from "./Endpoints";

const AthleteAPI = {
  all: async function() {
    return APIRequestHandler.query(Endpoints.ATHLETE);
  },
  get: async function(id) {
    return APIRequestHandler.query(Endpoints.ATHLETE + `?id=${id}`);
  },
  withCoach: async function(id) {
    return APIRequestHandler.query(Endpoints.ATHLETE + `?coach=${id}`);
  },
  inGroup: async function(id) {
    return APIRequestHandler.query(Endpoints.ATHLETE + `?group=${id}`);
  }
};

export default AthleteAPI;
