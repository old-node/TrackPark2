/**************************************************************************************
Fichier :       evaluation.js
Auteur :        Antoine Gagnon
Fonctionnalité : API des évaluations.
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

const EvaluationAPI = {

  /**
   * Get all evaluations
   */
  all: async function () {
    return APIRequestHandler.query(Endpoints.EVALUATION);
  },

  /**
   * Get a specific evaluation by its id
   * @param {int} id
   */
  get: async function (id) {
    return APIRequestHandler.query(`${Endpoints.EVALUATION}?id=${id}`);
  },

  /**
   * Get all evaluations linked to a given athlete
   * @param {int} id
   */
  ofAthlete: async function (id) {
    return APIRequestHandler.query(`${Endpoints.EVALUATION}?athlete=${id}`);
  },

  /**
   * Get all evaluations done by a given coach
   * @param {int} id
   */
  ofCoach: async function (id) {
    return APIRequestHandler.query(`${Endpoints.EVALUATION}?coach=${id}`);
  },

  /**
   * Update a given evaluation
   * @param {int} id
   * @param {{state: boolean, numerical_value: int}} options
   */
  update: async function (id, options) {
    let body = {
      id: id
    }

    if (options.state !== undefined) {
      body.state = options.state;
    }

    if (options.value !== undefined) {
      body.numerical_value = options.value;
    }
    return APIRequestHandler.post(Endpoints.EVALUATION, body);
  }
};

export default EvaluationAPI;
