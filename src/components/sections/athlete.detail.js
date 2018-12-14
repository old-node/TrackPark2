import React, { Component } from "react";
import { withRouter } from "react-router-dom";

import GroupTable from "./tables/groups";
import EvaluationTable from "./tables/evaluation";

import AthleteInfo from "./info/athlete.info";

import GroupAPI from "../../api/group";
import AthleteAPI from "../../api/athlete";
import EvaluationAPI from "../../api/evaluation";
import ResultStates from "../../api/ResultStates";

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
        result => this.setState({ groups: result })
      ),
      AthleteAPI.get(athleteId).then(
        result => this.setState({ athlete: result[0] })
      ),
      EvaluationAPI.ofAthlete(athleteId).then(
        result => this.setState({ evaluations: result })
      )
    ]).then(() => {
      this.setState({ isLoaded: true });
    }).catch((error) => {
      this.setState({ error: error });
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

          <h3>Évaluations à faire</h3>
          <EvaluationTable evaluations={evaluations} status={ResultStates.TODO} />

          <h3>Évaluations terminées</h3>
          <EvaluationTable evaluations={evaluations} />
        </div>
      );
    }
  }
}

export default withRouter(AthleteDetail);
