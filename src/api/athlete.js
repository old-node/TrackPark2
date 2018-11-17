import APIRequestHandler from "./APIRequestHandler";
import Endpoints from "./Endpoints";

const AthleteAPI = {
  all: async function() {
    return APIRequestHandler.query(Endpoints.ATHLETE);
  },
  get: async function(id) {
    return APIRequestHandler.query(`${Endpoints.ATHLETE_CATEGORY}?id=${id}`);
  },
  withCoach: async function(id) {
    return APIRequestHandler.query(`${Endpoints.ATHLETE_CATEGORY}?coach=${id}`);
  },
  inGroup: async function(id) {
    return APIRequestHandler.query(`${Endpoints.ATHLETE_CATEGORY}?group=${id}`);
  }
};

export default AthleteAPI;
