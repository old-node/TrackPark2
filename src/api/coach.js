import APIRequestHandler from "./APIRequestHandler";
import Endpoints from "./Endpoints";

const CoachAPI = {
  all: async function() {
    return APIRequestHandler.query(Endpoints.COACH);
  },
  get: async function(id) {
    return APIRequestHandler.query(`${Endpoints.COACH}?id=${id}`);
  }
};

export default CoachAPI;
