import APIRequestHandler from "./APIRequestHandler";
import Endpoints from "./Endpoints";

const DrillTypeAPI = {
  all: async function() {
    return APIRequestHandler.query(Endpoints.DRILL_TYPE);
  },
  get: async function(id) {
    return APIRequestHandler.query(`${Endpoints.DRILL_TYPE}?id=${id}`);
  }
};

export default DrillTypeAPI;
