import React, { Component } from 'react';
import '../../css/content/content.css';
import Info from './info';
import Popup from './popup';
import { Switch } from 'react-router-dom'
import { Route } from 'react-router-dom'

import ParkGroup  from '../sections/park.group';
import AthleteList from '../sections/athlete.list';
import GroupList from '../sections/group.list';
import Login from '../../auth/login';

export default class Content extends Component {
  render(props) {
    return (
      <main id="content" className="content col10 colt10 colm12 floatLeft">
        <Info />
        <Popup />

        <Switch>
            <Route exact path="/login" component={Login}></Route>
        </Switch>

        <Switch>
          <Route exact path="/athlete" component={AthleteList} />
        </Switch>

        <Switch>
          <Route exact path="/group" component={GroupList} />
        </Switch>

        <Switch>
              <Route exact path="/parkgroup" component={ParkGroup}/>
        </Switch>
      </main>
    );
  }
}

