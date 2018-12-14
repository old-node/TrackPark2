import React, { Component } from "react";
import { withRouter } from "react-router-dom";

import AthleteTable from "./tables/athlete";

import AthleteAPI from "../../api/athlete";
import AuthManager from "../../auth/AuthManager";

class AthleteList extends Component {
  constructor(props) {
    super(props);

    this.state = {
      error: null,
      isLoaded: false,
      athletes: []
    };
  }

  async componentDidMount() {
    AthleteAPI.withCoach(AuthManager.getCoachId()).then(
      result => {
        this.setState({
          isLoaded: true,
          athletes: result
        });
      },
      error => {
        this.setState({
          isLoaded: true,
          error
        });
      }
    );
  }

  render() {
    const { error, isLoaded, athletes } = this.state;
    if (error) {
      return <div>Error: {error.message}</div>;
    } else if (!isLoaded) {
      return <div>Loading...</div>;
    } else {
      return (
        <div>
          <h1>Athlètes que vous évaluez</h1>
          <AthleteTable athletes={athletes} />
        </div>
        
      );
    }
  }
}

export default withRouter(AthleteList);
