
// A simple data exemple API that will be used to get the data for our
// components. On a real website, a more robust data fetching
// solution would be more appropriate.
const AthleteAPI = {
  athletes: [
    { number: 1, name: "Ben Blocker", birthday: "2001-10-19" },
    { number: 2, name: "Dave Defender", birthday: "1998-10-13" },
    { number: 3, name: "Sam Sweeper", birthday: "2003-07-03" },
    { number: 4, name: "Matt Midfielder", birthday: "2004-08-04" },
    { number: 5, name: "William Winger", birthday: "2002-04-01" },
    { number: 6, name: "Fillipe Forward", birthday: "2004-06-25" }
  ],
  all: function() { return this.athletes},
  get: function(id) {
    const isAthlete = p => p.number === id
    return this.athletes.find(isAthlete)
  }
}

export default AthleteAPI
