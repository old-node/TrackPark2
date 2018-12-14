/**************************************************************************************
Fichier :       course.js
Auteur :        Antoine Gagnon
Fonctionnalité : API des parcours.
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

const CourseAPI = {

  /**
   * Get all courses
   */
  all: async function () {
    return APIRequestHandler.query(Endpoints.COURSE);
  },

  /**
   * Get a specific course by its id
   * @param {int} id
   */
  get: async function (id) {
    return APIRequestHandler.query(`${Endpoints.COURSE}?id=${id}`);
  },

  /**
   * Get a specific course by its id
   * @param {int} id
   */
  forCoach: async function (coach) {
    return APIRequestHandler.query(`${Endpoints.COURSE}?coach=${coach}`);
  }
};

export default CourseAPI;
