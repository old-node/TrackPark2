/**************************************************************************************
Fichier :       parc.js
Auteur :        Antoine Gagnon
Fonctionnalité : API des parcs.
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

const ParkApi = {

  /**
   * Get all courses
   */
  all: async function () {
    return APIRequestHandler.query(Endpoints.PARC);
  },

  /**
   * Get a specific course by its id
   * @param {int} id
   */
  get: async function (id) {
    return APIRequestHandler.query(`${Endpoints.PARC}?id=${id}`);
  }
};

export default ParkApi;
