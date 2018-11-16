import React, { Component } from 'react';
import '../../css/content/content.css';
import Frame from './frame';
import Info from './info';
import Popup from './popup';
import { Switch } from 'react-router-dom'
import { Route } from 'react-router-dom'

import ParkGroup  from '../sections/park.group';
import AthleteList from '../sections/athlete.list';

export default class Content extends Component {
  render(props) {
    return (
      <main id="content" className="content">
        <Info />
        <Popup />


        <Switch>
          <Route exact path="/athlete" component={AthleteList} />
        </Switch>

        <Switch>
              <Route exact path="/parkgroup" component={ParkGroup}/>
        </Switch>


      </main>
    );
  }
}

