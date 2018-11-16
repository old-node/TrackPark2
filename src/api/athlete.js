const AthleteAPI = {
  all: async function() {
    return fetch("http://localhost/api/v2/athlete.php").then(res => res.json());
  },
  get: async function(id) {
    const response = await fetch("http://localhost/athlete.php?id=" + id);
    //const json = await response.json();
    return await response.json();
  }
};

export default AthleteAPI;
