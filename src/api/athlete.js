import APIRequestHandler from "./APIRequestHandler";
import Endpoints from "./Endpoints";

const AthleteAPI = {
  all: async function() {
    return APIRequestHandler.query(Endpoints.ATHLETE, true);
  },
  get: async function(id) {
    return APIRequestHandler.query(Endpoints.ATHLETE + `?id=${id}`);
  }
};

export default AthleteAPI;
