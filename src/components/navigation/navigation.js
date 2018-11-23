import React, { Component } from 'react';
import '../../css/navigation/navigation.css';
import Header from './header';
import Menu from './menu';

export default class Navigation extends Component {
  constructor(props) {
    super(props)
  }
  
  
  render(props) {
    return (
      <div id="navigation" className="navigation">
        <Menu active={this.props.active} />
        <Header title={this.props.title} />
      </div>
    );
  }
}
