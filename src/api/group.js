/**************************************************************************************
Fichier :       group.js
Auteur :        Antoine Gagnon
Fonctionnalité : API des groupes.
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

const GroupAPI = {

  /**
   * Get all groups
   */
  all: async function () {
    return APIRequestHandler.query(Endpoints.GROUP);
  },

  /**
   * Get a specific group
   * @param {int} id
   */
  get: async function (id) {
    return APIRequestHandler.query(`${Endpoints.GROUP}?id=${id}`);
  },

  /**
   * Get a group linked to a specific coach
   * @param {int} id
   */
  ofCoach: async function (id) {
    return APIRequestHandler.query(`${Endpoints.GROUP}?coach=${id}`);
  },

  /**
   * Get groups in which an athlete is
   * @param {int} id
   */
  ofAthlete: async function (id) {
    return APIRequestHandler.query(`${Endpoints.GROUP}?athlete=${id}`);
  },

  /**
   * Add permissions for a coach to a group
   * @param {int} group
   * @param {int} coach The coach ID
   * @param {AccessTypes} type The type of permission to give
   */
  addRight: async function (group, coach, type) { //TODO: test this
    let body = {
      action: "addRight",
      group: group,
      coach: coach,
      type: type
    }
    return APIRequestHandler.post(Endpoints.GROUP, body);
  }
};

export default GroupAPI;
