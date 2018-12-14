/**************************************************************************************
Fichier :       cap.js
Auteur :        Antoine Gagnon
Fonctionnalité : API des casquettes.
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
