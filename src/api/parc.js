import APIRequestHandler from "./APIRequestHandler";
import Endpoints from "./Endpoints";

const ParkApi = {

  /**
   * Get all courses
   */
  all: async function () {
    return APIRequestHandler.query(Endpoints.PARC);
  },

  /**
   * Get a specific course by its id
   * @param {int} id
   */
  get: async function (id) {
    return APIRequestHandler.query(`${Endpoints.PARC}?id=${id}`);
  }
};

export default ParkApi;
