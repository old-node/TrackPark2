import APIRequestHandler from "./APIRequestHandler";
import Endpoints from "./Endpoints";

const DrillAPI = {

  /**
   * Get all drills
   */
  all: async function () {
    return APIRequestHandler.query(Endpoints.DRILL);
  },

  /**
   * Get a specific drill by its id
   * @param {int} id
   */
  get: async function (id) {
    return APIRequestHandler.query(`${Endpoints.DRILL}?id=${id}`);
  },

  forCourse: async function(id) {
    return APIRequestHandler.query(`${Endpoints.DRILL}?course=${id}`)
  }
};

export default DrillAPI;
