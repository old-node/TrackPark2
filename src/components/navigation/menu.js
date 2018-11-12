import React, { Component } from 'react'
import logo from '../../images/logo.png'
import { sections_group } from '../../constants'
import { makeMenuLink } from '../../functions'
require('../../css/stylesheet.css')
require('../../css/navigation/menu.css')

export default class Menu extends Component {
  render(props) {
    if (props === undefined) {
      props = {active: ""}
    }
    let buttonList = [];
    sections_group.forEach(element => {
      buttonList.push(makeMenuLink(element, props.section));
    });
    return (
      <nav id="menu" className="menu sideMenu col2 colt2 colm12 floatLeft">
        <h3>
            Menu Component
        </h3>
        <img className="logo" src={logo} alt="logo" />
        <ul>
          { buttonList }
        </ul>
      </nav>
    );
  }
}
