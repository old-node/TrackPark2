/**************************************************************************************
Fichier :       course.list.js
Auteur :        Antoine Gagnon
Fonctionnalité : Liste de parcours.
Date :          22 novembre 2018
=======================================================================================
Vérification :
Date        Nom                     Approuvé
=======================================================================================
Historique de modification :
Date        Nom                     Description
2018-12-14	Olivier Lemay Dostie    Ajout des description
**************************************************************************************/

import React, { Component } from "react";
import { withRouter } from "react-router-dom";
import AuthManager from "../../auth/AuthManager";
import CourseAPI from "../../api/course";
import DrillAPI from "../../api/drill";
import DrillTable from "./tables/drill"

class EvaluationList extends Component {
  constructor(props) {
    super(props);

    this.state = {
      error: null,
      isLoaded: false,
      courses: [],
      drills: []
    };
  }

  async componentDidMount() {
    CourseAPI.forCoach(AuthManager.getCoachId()).then(
      result => {
        this.setState({
          courses: result
        });
      },
      error => {
        this.setState({
          isLoaded: true,
          error
        });
      }
    ).then(() => {
      const { courses } = this.state;

      let querries = []
      courses.forEach((course) => {
        querries.push(
          DrillAPI.forCourse(course.id).then((res) => {
            this.state.drills.push([res]);
          })
        )
      })

      Promise.all(querries).then(() => this.setState({ isLoaded: true }));
    });
  }
  render() {
    const { error, isLoaded, courses, drills } = this.state;
    if (error) {
      return <div>Error: {error.message}</div>;
    } else if (!isLoaded) {
      return <div>Loading...</div>;
    } else {
      return (
        <div>
          {drills.map((drill, index) => (
              <div>
                <h1>Parcours</h1>
                <h3>Nom du parcours</h3>
                {drill.map((sub, index) => (
                  <div>
                    <span className="drillInfo">{courses[index].name}</span>
                    <h3>Exercices du parcours</h3>
                    <DrillTable drills={sub} />
                  </div>
                ))}
              </div>
          ))}
        </div>
      );
    }
  }
}

export default withRouter(EvaluationList);
