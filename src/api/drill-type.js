/**************************************************************************************
Fichier :       drill-type.js
Auteur :        Antoine Gagnon
Fonctionnalité : API des types d'exercices.
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
