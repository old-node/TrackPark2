import React, { Component } from 'react';
import '../../css/navigation/navigation.css';
import Header from './header';
import Menu from './menu';

export default class Navigation extends Component {
  render(props) {
    return (
      <div id="navigation" className="navigation">
        {/* TrackPark2 menu */}
        <Menu
          active={this.props.active}
          handler={this.props.handler} />
        {/* TrackPark2 header */}
        <Header
          title={this.props.active} />
      </div>
    );
  }
}
