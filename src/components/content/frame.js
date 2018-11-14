import React, { Component } from 'react'
import '../../css/content/frame.css'
import { Switch } from 'react-router-dom'
import { home, contact } from '../../constants';
import { Route } from 'react-router-dom'

export default class Frame extends Component {
  constructor(props) {
    super(props)
    console.log("hello")
  }

  render(props) {
    return (
          <div id="frame" className="frame">
            <h3>
                Frame Component
            </h3>
            <Switch>
              <Route exact path="/" component={home.component}/>
            </Switch>
          </div>
      
    );
  }
}
