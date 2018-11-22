import APIRequestHandler from "./APIRequestHandler";
import Endpoints from "./Endpoints";

const CourseTypeAPI = {

    /**
     * Get all course types
     */
    all: async function () {
        return APIRequestHandler.query(Endpoints.COURSE_TYPE);
    },

    /**
     * Get a specific course type bu its id
     * @param {int} id
     */
    get: async function (id) {
        return APIRequestHandler.query(`${Endpoints.COURSE_TYPE}?id=${id}`);
    }
};

export default CourseTypeAPI;
