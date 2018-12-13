import React, { Component } from 'react'
import logo from '../../images/logo.png'
import { sections_group } from '../../constants'
import { makeMenuLink } from '../../functions'
import { Link } from 'react-router-dom'
require('../../css/stylesheet.css')
require('../../css/navigation/menu.css')

export default class Menu extends Component {
  constructor(props) {
    super(props);
    this.myFunction = this.myFunction.bind(this);
  }
  myFunction = function() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
      x.className += " responsive";
    } else {
      x.className = "topnav";
    }
  }

  render(props) {

    //Si aucun onglet actif n'est défini
    if (props === undefined) {
      props = { active: "" }
    }

    //Création des boutons vers les différentes sections
    let buttonList = [];
    sections_group.forEach(element => {
      buttonList.push(makeMenuLink(element, props.section));
    });

    return (
      <nav id="myTopnav" className="topnav">
        <Link to='/'><img className="logo" src={logo} alt="logo" /></Link>
        <ul className="noPaddingStart">
          {buttonList}
        </ul>
        <a href="javascript:void(0);" className="icon" onClick={this.myFunction}>
          <i className="fa fa-bars"></i>
        </a>
      </nav>
    );
  }
}
