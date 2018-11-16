import React, { Component } from 'react';
import '../../css/navigation/header.css';
import {Table } from 'semantic-ui-react'
import { withRouter } from 'react-router-dom';

class AthleteList extends Component {
    constructor(props) {
        super(props);
      }
      render() {
        return (
          <ul>
              <li>Jean Paul</li>
              <li>Jean Max</li>
          </ul>
        );
      }
}

export default withRouter(AthleteList);