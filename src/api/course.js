import APIRequestHandler from "./APIRequestHandler";
import Endpoints from "./Endpoints";

const CourseAPI = {
  all: async function() {
    return APIRequestHandler.query(Endpoints.COURSE);
  },
  get: async function(id) {
    return APIRequestHandler.query(Endpoints.COURSE + `?id=${id}`);
  }
};

export default CourseAPI;
