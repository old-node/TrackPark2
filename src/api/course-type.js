import APIRequestHandler from "./APIRequestHandler";
import Endpoints from "./Endpoints";

const CourseTypeAPI = {
  all: async function() {
    return APIRequestHandler.query(Endpoints.COURSE_TYPE);
  },
  get: async function(id) {
    return APIRequestHandler.query(`${Endpoints.COURSE_TYPE}?id=${id}`);
  }
};

export default CourseTypeAPI;
