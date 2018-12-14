/**************************************************************************************
Fichier :       course-type.js
Auteur :        Antoine Gagnon
Fonctionnalité : API des types de parcours.
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
