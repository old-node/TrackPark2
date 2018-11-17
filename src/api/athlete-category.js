import APIRequestHandler from "./APIRequestHandler";
import Endpoints from "./Endpoints";

const AthleteCategoryAPI = {
  all: async function() {
    return APIRequestHandler.query(Endpoints.ATHLETE_CATEGORY);
  },
  get: async function(id) {
    return APIRequestHandler.query(Endpoints.ATHLETE_CATEGORY + `?id=${id}`);
  }
};

export default AthleteCategoryAPI;
