import React, { Component } from "react";
import { withRouter } from "react-router-dom";

import GroupAPI from "../../api/group";
import GroupTable from "./tables/groups";

class GroupList extends Component {
  constructor(props) {
    super(props);

    this.state = {
      error: null,
      isLoaded: false,
      groups: []
    };
  }

  async componentDidMount() {
    GroupAPI.all().then(
      result => {
        this.setState({
          isLoaded: true,
          groups: result
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
    const { error, isLoaded, groups } = this.state;
    if (error) {
      return <div>Error: {error.message}</div>;
    } else if (!isLoaded) {
      return <div>Loading...</div>;
    } else {
      return (
        <GroupTable groups={groups} />
      );
    }
  }
}

export default withRouter(GroupList);
