import APIRequestHandler from "./APIRequestHandler";
import Endpoints from "./Endpoints";

const CapAPI = {
  all: async function() {
    return APIRequestHandler.query(Endpoints.CAP);
  },
  get: async function(code) {
    return APIRequestHandler.query(`${Endpoints.ATHLETE_CATEGORY}?code=${code}`);
  }
};

export default CapAPI;
