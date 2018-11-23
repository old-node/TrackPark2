import React, { Component } from 'react'
import logo from '../../images/logo.png'
import { sessions, sections_group } from '../../constants'
import { makeMenuLink } from '../../functions'
import { Link } from 'react-router-dom'
require('../../css/stylesheet.css')
require('../../css/navigation/menu.css')

export default class Menu extends Component {
  constructor(props) {
    super(props)
    let active = props.active
    let authenticated = true // props.authenticated
  }
  
  render() {

    //Création des boutons vers les différentes sections
    let buttonList = [];
    sections_group.forEach(element => {
      buttonList.push(makeMenuLink(element, this.active))
    });
    // TODO: Fix the undefined section.href 
    if (this.authenticated) {
      // buttonList.push(makeMenuLink(sessions[0], this.active))
    } else {
      // buttonList.push(makeMenuLink(sessions[3], this.active))
    }
    

    return (
      <nav id="menu" className="menu sideMenu col2 colt2 colm12 floatLeft">
        <Link to='/'><img className="logo" src={logo} alt="logo" /></Link>
        <ul>
          {buttonList}
        </ul>
      </nav>
    );
  }
}
