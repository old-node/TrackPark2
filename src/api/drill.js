import APIRequestHandler from "./APIRequestHandler";
import Endpoints from "./Endpoints";

const DrillAPI = {
  all: async function() {
    return APIRequestHandler.query(Endpoints.DRILL);
  },
  get: async function(id) {
    return APIRequestHandler.query(`${Endpoints.DRILL}?id=${id}`);
  }
};

export default DrillAPI;
