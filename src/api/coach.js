/**************************************************************************************
Fichier :       coach.js
Auteur :        Antoine Gagnon
Fonctionnalité : API des évaluateurs.
Date :          22 novembre 2018
=======================================================================================
Vérification :
Date        Nom                     Approuvé
=======================================================================================
Historique de modification :
Date        Nom                     Description
2018-12-14	Olivier Lemay Dostie    Ajout des description
**************************************************************************************/

import APIRequestHandler from "./APIRequestHandler";
import Endpoints from "./Endpoints";

const CoachAPI = {

  /**
   * Get all the coaches
   */
  all: async function () {
    return APIRequestHandler.query(Endpoints.COACH);
  },

  /**
   * Get a specific coat by its id
   * @param {int} id
   */
  get: async function (id) {
    return APIRequestHandler.query(`${Endpoints.COACH}?id=${id}`);
  },

  /**
   * Get a coach for a given group
   * @param {int} id
   */
  forGroup: async function (id) {
    return APIRequestHandler.query(`${Endpoints.COACH}?group=${id}`);
  },

  /**
   * Add group to coach
   * @param {int} idCoach 
   * @param {int} idGroup 
   */
  addGroup: async function (idCoach, idGroup) {
    return APIRequestHandler.query(`${Endpoints.COACH}?idCoach=${idCoach}&idGroup=${idGroup}`);
  }
};

export default CoachAPI;
