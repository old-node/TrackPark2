import APIRequestHandler from "./APIRequestHandler";
import Endpoints from "./Endpoints";

const CapAPI = {
    /**
     * Get all caps
     */
    all: async function () {
        return APIRequestHandler.query(Endpoints.CAP);
    },

    /**
     * Get a specific cap by its code
     * @param {int} code
     */
    get: async function (code) {
        return APIRequestHandler.query(`${Endpoints.CAP}?code=${code}`);
    }
};

export default CapAPI;
