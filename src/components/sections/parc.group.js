import React, { Component } from "react";
import { withRouter } from "react-router-dom";

import ParcTable from "./tables/parc";

import ParcAPI from "../../api/parc";
import AuthManager from "../../auth/AuthManager";

class ParcList extends Component {
  constructor(props) {
     super(props);

    this.state = {
      error: null,
      isLoaded: false,
      parcs: []
    };
  }

  async componentDidMount() {
    ParcAPI.all().then(
      result => {
        this.setState({
          isLoaded: true,
          parcs: result
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
    const { error, isLoaded, parcs } = this.state;
    if (error) {
      return <div>Error: {error.message}</div>;
    } else if (!isLoaded) {
      return <div>Loading...</div>;
    } else {
      return (
        <ParcTable parcs={parcs} />
        );
    }
  }
}

export default withRouter(ParcList);
