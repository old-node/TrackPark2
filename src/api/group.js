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
  },
  addRight: async function(group, coach, type) { //TODO: test this
    let body = {
        action: "addRight",
        group: group,
        coach: coach,
        type: type
    }
    return APIRequestHandler.post(Endpoints.GROUP, body);
  }
};

export default GroupAPI;
