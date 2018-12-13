import React, { Component } from 'react';
import '../../css/navigation/header.css';

export default class Header extends Component {
  render(props) {
    if (props === undefined) {
      props = { title: "", button: null }
    }

    return (
      <header id="header" className="header topMenu col12 colt12 colm12 floatLeft">
        <h3>
          {this.props.title}
        </h3>
      </header>

    );
  }
}
