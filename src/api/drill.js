/**************************************************************************************
Fichier :       drill.js
Auteur :        Antoine Gagnon
Fonctionnalité : API des exercices.
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

  /**
   * Get the drills in a course
   * @param {int} id 
   */
  forCourse: async function(id) {
    return APIRequestHandler.query(`${Endpoints.DRILL}?course=${id}`)
  }
};

export default DrillAPI;
