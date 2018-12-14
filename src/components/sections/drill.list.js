import React, { Component } from "react";
import { withRouter } from "react-router-dom";

import DrillTable from "./tables/drill"
import DrillAPI from "../../api/drill"

class DrillList extends Component {
  constructor(props) {
    super(props);

    this.state = {
      error: null,
      isLoaded: false,
      drills: []
    };
  }

  async componentDidMount() {
    DrillAPI.all().then(
      result => {
        this.setState({
          isLoaded: true,
          drills: result
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
    const { error, isLoaded, drills } = this.state;
    if (error) {
      return <div>Error: {error.message}</div>;
    } else if (!isLoaded) {
      return <div>Loading...</div>;
    } else {
      return (
        <div>
          <h1>Exercices</h1>
          <DrillTable drills={drills} />
        </div>
      );
    }
  }
}

export default withRouter(DrillList);
