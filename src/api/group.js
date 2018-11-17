import APIRequestHandler from "./APIRequestHandler";
import Endpoints from "./Endpoints";

const GroupAPI = {
  all: async function() {
    return APIRequestHandler.query(Endpoints.GROUP);
  },
  get: async function(id) {
    return APIRequestHandler.query(Endpoints.GROUP + `?id=${id}`);
  },
  ofCoach: async function(id) {
    return APIRequestHandler.query(Endpoints.GROUP + `?coach=${id}`);
  }
};

export default GroupAPI;
