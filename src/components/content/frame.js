import React, { Component } from 'react'
import '../../css/content/frame.css'
import { Switch } from 'react-router-dom'
import { home } from '../../constants';
import { parkgroup } from '../../constants';

import AthleteList from '../sections/athlete.list';

import { park } from '../../constants';
import { Route } from 'react-router-dom';

export default class Frame extends Component {
  constructor(props) {
    super(props)
    console.log("hello")
  }

  render(props) {
    return (
      <div id="frame" className="frame">
        <h3>
        </h3>
        <Switch>
          <Route exact path="/" component={home.component} />
        </Switch>

        <Switch>
          <Route exact path="/athlete" component={AthleteList} />
        </Switch>

        <Switch>
          <Route exact path="/parkgroup" component={parkgroup.component} />
        </Switch>
        <Switch>
          <Route exact path="/park" component={park.component} />
        </Switch>
      </div>
    );
  }
}
