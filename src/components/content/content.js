/**************************************************************************************
Fichier :       content.js
Auteur :        Olivier Lemay Dostie
Fonctionnalité : Affichage complet de la section section actuelle.
Date :          22 novembre 2018
=======================================================================================
Vérification :
Date        Nom                     Approuvé
=======================================================================================
Historique de modification :
Date        Nom                     Description
2018-12-14	Olivier Lemay Dostie    Ajout des description
**************************************************************************************/

import React, { Component } from 'react';
import '../../css/content/content.css';
// import Frame from './frame';
import Info from './info';
import Popup from './popup';
import { Switch } from 'react-router-dom'
import { Route } from 'react-router-dom'

// All components that can be routed to
import Home from "../home";
import EvaluationList from "../sections/evaluation.list"
import ParkGroup from '../sections/park.group';
import AthleteList from '../sections/athlete.list';
import GroupList from '../sections/group.list';
import GroupDetail from '../sections/group.detail';
import Login from '../../auth/login';
import AthleteDetail from '../sections/athlete.detail';
import EvaluationDetail from '../sections/evaluation.detail';
import ExerciceList from "../sections/drill.list";
import CourseList from '../sections/course.list';
import ExerciceDetail from "../sections/exercice.detail";

/**
 * The main "window" of the app
 * Contains all the routes to each "pages"
 */
export default class Content extends Component {
  render(props) {
    return (
      <main id="content" className="content col10 colt10 colm12 floatLeft">
        <Switch>
          <Route exact path="/" render={props =>
            <Home setTitle={this.props.handler} />}
          />
        </Switch>

        <Switch>
          <Route exact path="/login" component={Login}></Route>
        </Switch>

        <Switch>
          <Route exact path="/athlete" component={AthleteList} />
          <Route exact path="/athlete/:id" render={props =>
            <AthleteDetail setTitle={this.props.handler} />}
          />
        </Switch>

        <Switch>
          <Route exact path="/drill" component={ExerciceList} />
          <Route exact path="/drill/:id" render={props =>
            <ExerciceDetail setTitle={this.props.handler} />}
          />
        </Switch>

        <Switch>
          <Route exact path="/course" component={CourseList} />
        </Switch>

        <Switch>
          <Route exact path="/group" component={GroupList} />
          <Route exact path="/group/:id" render={props =>
            <GroupDetail setTitle={this.props.handler} />}
          />
        </Switch>

        <Switch>
          <Route exact path="/evaluation" component={EvaluationList} />
          <Route exact path="/evaluation/:id" render={props =>
            <EvaluationDetail setTitle={this.props.handler} />}
          />
        </Switch>

        <Switch>
          <Route exact path="/parkgroup" component={ParkGroup} />
        </Switch>

        {/* Aditionnal optionnal Component for future implementation */}
        {/* <Frame /> */}
        <Info />
        <Popup />
      </main>
    );
  }
}

