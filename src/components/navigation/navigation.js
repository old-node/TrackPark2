import React, { Component } from 'react';
import '../../css/navigation/navigation.css';
import Header from './header';
import Menu from './menu';

export default class Navigation extends Component {
  render(props) {
    return (
      <div id="navigation" className="navigation">
        <h2>
            Navigation Component
        </h2>
        <Menu />
        <Header />
      </div>
    );
  }
}
