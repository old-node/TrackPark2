import React, { Component } from 'react'
import logo from '../../images/logo.png'
import { sections_group } from '../../constants'
import { makeMenuLink } from '../../functions'
import { Link } from 'react-router-dom'
import { toggleMenu } from '../../functions'
require('../../css/stylesheet.css')
require('../../css/navigation/menu.css')

export default class Menu extends Component {
  render(props) {
    //Si aucun onglet actif n'est défini
    if (this.props.active === undefined) {
      this.props = { active: "Login" }
    }

    //Création des boutons vers les différentes sections
    let buttonList = []
    sections_group.forEach(element => {
      buttonList.push(makeMenuLink(element, this.props.active, this.props.handler));
    })

    return (
      <nav id="myTopnav" className="topnav">
        <Link to='/'><img className="logo" src={logo} alt="logo" /></Link>
        <h3 id="menuTitle" className="menuTitle">{this.props.active}</h3>
        <ul className="noPaddingStart">
          {buttonList}
        </ul>
        <a href="#" className="icon" onClick={toggleMenu}>
          <i className="fa fa-bars"></i>
        </a>
      </nav>
    );
  }
}
