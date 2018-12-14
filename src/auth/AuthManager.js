/**************************************************************************************
Fichier :       AuthManager.js
Auteur :        Antoine Gangon
Fonctionnalité : Gestionnaire des autentifications.
Date :          22 novembre 2018
=======================================================================================
Vérification :
Date        Nom                     Approuvé
=======================================================================================
Historique de modification :
Date        Nom                     Description
2018-12-14	Olivier Lemay Dostie    Ajout des description
**************************************************************************************/

class AuthManager {
  token = null;
  user_id = null;
  coach_id = null;

  /**
   * Log user in
   * @param {string} username
   * @param {string} password
   */
  auth(username, password) {
    return fetch("http://localhost/api/v2/auth.php", {
      method: "POST",
      body: JSON.stringify({ username: username, password: password })
    })
      .then(res => res.json())
      .then(res => {
        sessionStorage.setItem("token", res.token);
        sessionStorage.setItem("user_id", res.id);
        sessionStorage.setItem("coach_id", res.coach);
      })
      .catch(err => {
        console.log(err);
      });
  }

  isLoggedIn() {
    return sessionStorage.getItem("token") !== null;
  }

  getUserId() {
    return sessionStorage.getItem("user_id");
  }

  getCoachId() {
    return sessionStorage.getItem("coach_id");
  }

  getToken() {
    return sessionStorage.getItem("token");
  }
}

const instance = new AuthManager();

export default instance;
