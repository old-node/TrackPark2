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
    if (props === undefined) {
      props = { active: "Accueil" }
    }

    //Création des boutons vers les différentes sections
    let buttonList = [];
    sections_group.forEach(element => {
      buttonList.push(makeMenuLink(element, props.section));
    });

    return (
      <nav id="myTopnav" className="topnav">
        <Link to='/'><img className="logo" src={logo} alt="logo" /></Link>
        <h3 id="menuTitle" className="menuTitle">{props.active}</h3>
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
