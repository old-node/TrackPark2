import APIRequestHandler from "./APIRequestHandler";
import Endpoints from "./Endpoints";

const DrillTypeAPI = {

    /**
     * Get all drill type
     */
    all: async function () {
        return APIRequestHandler.query(Endpoints.DRILL_TYPE);
    },

    /**
     * Get a specific drill type by its id
     * @param {int} id
     */
    get: async function (id) {
        return APIRequestHandler.query(`${Endpoints.DRILL_TYPE}?id=${id}`);
    }
};

export default DrillTypeAPI;
