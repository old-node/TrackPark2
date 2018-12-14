import React, { Component } from 'react'
import logo from '../../images/logo.png'
import { sections_group } from '../../constants'
import { makeMenuLink } from '../../functions'
import { Link } from 'react-router-dom'
require('../../css/stylesheet.css')
require('../../css/navigation/menu.css')

export default class Menu extends Component {
  constructor(props) {
    super(props)
    this.openMenu = this.openMenu.bind(this)
  }

  openMenu = function() {
    let topnav = document.getElementById("myTopnav")
    if (topnav.className === "topnav") {
      topnav.className += " responsive"
    } else {
      topnav.className = "topnav"
    }

    let menuTitle = document.getElementById("menuTitle");
    if (menuTitle.className === "menuTitle") {
      menuTitle.className += " hidden"
    } else {
      menuTitle.className = "menuTitle"
    }
  }

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
        <a href="#" className="icon" onClick={this.openMenu}>
          <i className="fa fa-bars"></i>
        </a>
      </nav>
    );
  }
}
