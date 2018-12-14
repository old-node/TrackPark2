import React, { Component } from "react";
import { withRouter } from "react-router-dom";

// import EvaluationTable from "./tables/evaluation";
import AuthManager from "../../auth/AuthManager";
import CourseAPI from "../../api/course";
import DrillAPI from "../../api/drill";
// import drill from "./tables/drill";
// import drillList from "./drill.list";
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

      console.log(courses);

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
      console.log(drills);
      return (
        <div>
          {drills.map((drill, index) => (
              <div>
              {drill.map((sub, index) => (
                <div>
                  <h1>{courses[index].name}</h1>
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
