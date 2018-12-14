import APIRequestHandler from "./APIRequestHandler";
import Endpoints from "./Endpoints";

const CourseAPI = {

  /**
   * Get all courses
   */
  all: async function () {
    return APIRequestHandler.query(Endpoints.COURSE);
  },

  /**
   * Get a specific course by its id
   * @param {int} id
   */
  get: async function (id) {
    return APIRequestHandler.query(`${Endpoints.COURSE}?id=${id}`);
  },

  /**
   * Get a specific course by its id
   * @param {int} id
   */
  forCoach: async function (coach) {
    return APIRequestHandler.query(`${Endpoints.COURSE}?coach=${coach}`);
  }
};

export default CourseAPI;
