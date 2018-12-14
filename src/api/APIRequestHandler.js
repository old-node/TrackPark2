/**************************************************************************************
Fichier :       APIRequestHandler.js
Auteur :        Antoine Gagnon
Fonctionnalité : Gestionnaire des APIs.
Date :          22 novembre 2018
=======================================================================================
Vérification :
Date        Nom                     Approuvé
=======================================================================================
Historique de modification :
Date        Nom                     Description
2018-12-14	Olivier Lemay Dostie    Ajout des description
**************************************************************************************/

/**
 * Classe qui permet de faire des requêtes à l'API
 */
class APIRequestHandler {
  /**
   * Query the given url and return a promise with the data in json format
   * @param {string} url the url to query
   * @param {boolean} auth indicate if the token should be passed in the headers
   */
  static query(url, auth = true) {

    if (auth) {
      if (url.includes('?')) {
        url += '&token=' + sessionStorage.getItem('token');
      } else {
        url += '?token=' + sessionStorage.getItem('token');
      }
    }

    return fetch(url).then(res => res.json());
  }

  /**
   * Post JSON data to a given URL
   * @param {string} url the url to post to
   * @param {json} body Json objet to post
   * @param {boolean} auth indicate if the token should be passed in the headers
   */
  static post(url, body, auth = true) {
    if (auth) {
      body['token'] = sessionStorage.getItem('token');
    }

    return fetch(url, { method: "POST", body: JSON.stringify(body) }).then(res => res.json());
  }
}

export default APIRequestHandler;
