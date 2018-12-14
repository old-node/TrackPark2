import React, { Component } from "react";
import { withRouter } from "react-router-dom";

import AthleteTable from "./tables/athlete";
import CoachTable from "./tables/coach";

import GroupAPI from "../../api/group";
import AthleteAPI from "../../api/athlete";
import CoachAPI from "../../api/coach";

class GroupDetail extends Component {
  constructor(props) {
    super(props);

    this.state = {
      error: null,
      isLoaded: false,
      group: null
    };
  }

  async componentDidMount() {
    let groupId = this.props.match.params.id;

    Promise.all([
      GroupAPI.get(groupId).then(
        result => this.setState({ group: result[0] })
      ),
      AthleteAPI.inGroup(groupId).then(
        result => this.setState({ athletes: result })
      ),
      CoachAPI.forGroup(groupId).then(
        result => this.setState({ coachs: result })
      )
    ]).then(() => {
      this.setState({ isLoaded: true });
    }).catch((error) => this.setState({ error: error }));
  }

  render() {
    const { error, isLoaded, group, athletes, coachs } = this.state;
    if (error) {
      return <div>Error: {error.message}</div>;
    } else if (!isLoaded) {
      return <div>Loading...</div>;
    } else {
      return (
        <div>
          <h1>{group.name}</h1>
          <h2>{group.description}</h2>
          

          <h3>Athletes</h3>
          <AthleteTable athletes={athletes} />

            <h3>Évaluateurs</h3>
          <CoachTable coachs={coachs} />
        </div>
      );
    }
  }
}

export default withRouter(GroupDetail);
