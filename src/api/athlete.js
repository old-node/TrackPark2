import APIRequestHandler from "./APIRequestHandler";
import Endpoints from "./Endpoints";

const AthleteAPI = {

  /**
   * Get all the athletes
   * @returns {Promise} with all the athletes in an array
   */
  all: async function () {
    return APIRequestHandler.query(Endpoints.ATHLETE);
  },

  /**
   * Get a specific athlete by its id
   * @param {int} id
   * @returns {Promise} with the specified athlete in an array
   */
  get: async function (id) {
    return APIRequestHandler.query(`${Endpoints.ATHLETE}?id=${id}`);
  },

  /**
   * Get all the athletes that have a specific coach
   * @param {int} id
   */
  withCoach: async function (id) {
    return APIRequestHandler.query(`${Endpoints.ATHLETE}?coach=${id}`);
  },

  /**
   * Get all the athletes in a specific group
   * @param {int} id
   */
  inGroup: async function (id) {
    return APIRequestHandler.query(`${Endpoints.ATHLETE}?group=${id}`);
  }
};

export default AthleteAPI;
