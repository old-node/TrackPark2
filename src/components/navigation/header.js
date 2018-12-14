import React, { Component } from 'react';
import '../../css/navigation/header.css';

export default class Header extends Component {
  render(props) {
    console.log(this.props)
    let hClass = "topMenu col12 colt12 colm12 floatLeft"
    this.props = { title: "" }
    if (this.props.title === "") {
      hClass += " header"
    } else {
      hClass += " headerWithText"
    }

    return (
      <header id="header" className={hClass} >
        <h3 className="blackHeader">
          {this.props.title}
        </h3>
      </header>

    );
  }
}
