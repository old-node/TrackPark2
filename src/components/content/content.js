import React, { Component } from 'react';
import '../../css/content/content.css';
import Info from './info';
import Popup from './popup';
import { Switch } from 'react-router-dom'
import { Route } from 'react-router-dom'

import home from "../home";
import EvaluationList from "../sections/evaluation.list"
import ParkGroup from '../sections/park.group';
import AthleteList from '../sections/athlete.list';
import GroupList from '../sections/group.list';
import GroupDetail from '../sections/group.detail';
import Login from '../../auth/login';
import AthleteDetail from '../sections/athlete.detail';
import evaluationDetail from '../sections/evaluation.detail';
import ExerciceList from "../sections/drill.list";
import courseList from '../sections/course.list';
import ExerciceDetail from "../sections/exercice.detail";

/**
 * The main "window" of the app
 * Contains all the routes to each "pages"
 */
export default class Content extends Component {
  render(props) {
    return (
      <main id="content" className="content col10 colt10 colm12 floatLeft">
        <Info />
        <Popup />

        <Switch>
          <Route exact path="/"
            render={props => <ParkGroup handler={this.props.handler} />}
          ></Route>
        </Switch>

        <Switch>
          <Route exact path="/login" component={Login}></Route>
        </Switch>

        <Switch>
          <Route exact path="/athlete" component={AthleteList} />
          <Route exact path="/athlete/:id" component={AthleteDetail} />
        </Switch>

        <Switch>
          <Route exact path="/drill" component={ExerciceList} />
          <Route exact path="/drill/:id" component={ExerciceDetail} />
        </Switch>

        <Switch>
          <Route exact path="/course" component={courseList} />
        </Switch>

        <Switch>
          <Route exact path="/group/:id" component={GroupDetail} />
          <Route exact path="/group" component={GroupList} />
        </Switch>

        <Switch>
          <Route exact path="/evaluation/:id" component={evaluationDetail} />
          <Route exact path="/evaluation" component={EvaluationList} />
        </Switch>

        <Switch>
          <Route exact path="/parkgroup" component={ParkGroup} />
        </Switch>
      </main>
    );
  }
}

