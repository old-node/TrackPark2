import React, { Component } from "react";
import { withRouter } from "react-router-dom";

import GroupTable from "./tables/groups";
import EvaluationTable from "./tables/evaluation";

import AthleteInfo from "./info/athlete.info";

import GroupAPI from "../../api/group";
import AthleteAPI from "../../api/athlete";
import EvaluationAPI from "../../api/evaluation";

/**
 * Informations sur l'athlète, les groupes dont il fait partie et ses évaluations
 */
class AthleteDetail extends Component {
  constructor(props) {
    super(props);

    this.state = {
      error: null,
      isLoaded: false
    };
  }

  async componentDidMount() {

    //Querries to the API to get all the data needed
    let athleteId = this.props.match.params.id;

    Promise.all([
      GroupAPI.ofAthlete(athleteId).then(
        result => {
          this.state.groups = result;
        },
        error => {
          this.state.error = error;
        }
      ),
      AthleteAPI.get(athleteId).then(
        result => {
          this.state.athlete = result[0];
        },
        error => {
          this.state.error = error;
        }
      ),
      EvaluationAPI.ofAthlete(athleteId).then(
        result => {
          this.state.evaluations = result;
        },
        error => {
          this.state.error = error;
        }
      )
    ]).then(() => {
      this.state.isLoaded = true;
      this.forceUpdate();
    });
  }

  render() {
    const { error, isLoaded, groups, athlete, evaluations } = this.state;
    if (error) {
      return <div>Error: {error.message}</div>;
    } else if (!isLoaded) {
      return <div>Loading...</div>;
    } else {
      return (
        <div>
          <AthleteInfo athlete={athlete} />

          <h3>Groupes</h3>
          <GroupTable groups={groups} />

          <h3>Évaluations</h3>
          <EvaluationTable evaluations={evaluations} />
        </div>
      );
    }
  }
}

export default withRouter(AthleteDetail);
