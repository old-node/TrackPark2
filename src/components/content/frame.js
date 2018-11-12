import React, { Component } from 'react'
import '../../css/content/frame.css'
import { Switch } from 'react-router-dom'
import { notfound, sessions, home, contact, section_switch } from '../../constants';
import { makeRoute } from '../../functions'
//, Route

export default class Frame extends Component {
  constructor(props) {
    super(props)

    const SectionRoutes = section_switch.component;
    this.routes = () => (
      makeRoute(notfound)+
      makeRoute(sessions.login)+
      makeRoute(sessions.register)+
      makeRoute(sessions.forgot)+
      makeRoute(sessions.logout)+
      makeRoute(home)+
      makeRoute(contact)+
      <SectionRoutes />
    )
  }

  render(props) {
    return (
      <div id="frame" className="frame">
        <h3>
            Frame Component
        </h3>
        <Switch>
          { this.routes }
        </Switch>
      </div>
    );
  }
}
