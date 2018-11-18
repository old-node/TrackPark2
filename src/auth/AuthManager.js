class AuthManager {
  token = null;
  user_id = null;
  coach_id = null;

  auth(username, password) {
    return fetch("http://localhost/api/v2/auth.php", {
      method: "POST",
      body: JSON.stringify({ username: username, password: password })
    })
      .then(res => res.json())
      .then(res => {
        sessionStorage.setItem("token", res.token);
        sessionStorage.setItem("user_id", res.id);
        sessionStorage.setItem("coahc_id", res.coach);
        this.token = res.token;
        this.user_id = res.id;
        this.coach_id = res.coach;
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