import React, { Component } from 'react';
import '../../css/navigation/header.css';

export default class Header extends Component {
  constructor(props) {
    super(props)
  }
  
  
  render(props) {
    if (props === undefined) {
      props = { title: "", button: null }
    }

    return (
      <header id="header" className="header topMenu col10 colt10 colm12 floatLeft">
        <h3>
          {this.props.title}
        </h3>
      </header>

    );
  }
}
