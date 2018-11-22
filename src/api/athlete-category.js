import APIRequestHandler from "./APIRequestHandler";
import Endpoints from "./Endpoints";

const AthleteCategoryAPI = {

    /**
     * Get all the athlete categories
     * @returns {Promise} with an array of athlete categories
     */
    all: async function () {
        return APIRequestHandler.query(Endpoints.ATHLETE_CATEGORY);
    },
    /**
     * Get a specific athlete category by its ID
     * @param {int} id
     * @returns {Promise} with the athlete category in an array
     */
    get: async function (id) {
        return APIRequestHandler.query(`${Endpoints.ATHLETE_CATEGORY}?id=${id}`);
    }
};

export default AthleteCategoryAPI;
