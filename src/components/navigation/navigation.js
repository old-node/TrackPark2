import React, { Component } from 'react';
import '../../css/navigation/navigation.css';
import Header from './header';
import Menu from './menu';

export default class Navigation extends Component {
  render(props) {
    //this.props.handler("Test1")
    return (
      <div id="navigation" className="navigation">
        <Menu
          active={this.props.active}
          handler={this.props.handler} />
        <Header
          title={this.props.active} />
      </div>
    );
  }
}
