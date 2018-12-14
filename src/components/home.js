import React, { Component } from 'react';
import AuthManager from "../auth/AuthManager";
import '../css/home.css';
import CoachAPI from '../api/coach';
import GroupAPI from '../api/group';
import GroupTable from "./sections/tables/groups";

export default class Home extends Component {
  constructor(props) {
    super(props);

    this.state = {
      error: null,
      isLoaded: false,
      coach: null,
      groups: null,
    }
  }

  //<h3>{this.state.coach.name}</h3>

  async componentDidMount() {
    let id = await AuthManager.getCoachId();

    await CoachAPI.get(id)
      .then(result => this.setState({ coach: result[0], }))
      .then(() =>
        Promise.all([
          GroupAPI.ofCoach(id).then(
            result => this.setState({ groups: result})
          )
        ]).then(() => {
          this.setState({ isLoaded: true });
        })
      ).catch((error) => this.setState({ error: error }));
  }

  render(props) {
    const { error, isLoaded, groups } = this.state;
    if (error) {
      return <div>Error: {error.message}</div>;
    } else if (!isLoaded) {
      return <div>Loading...</div>;
    } else {
      return (
        <div id="home" className="home">
          <h3>Bonjour {this.state.coach.first_name} {this.state.coach.name}</h3>
          <h3>Voici vos groupes à évaluer</h3>
          <GroupTable groups={groups} />
        </div>

        
      );
    }
  }
}
