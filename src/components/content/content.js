import React, { Component } from 'react';
import '../../css/content/content.css';
import Frame from './frame';
import Info from './info';
import Popup from './popup';
import Park from '../sections/park';
import GroupPark from '../sections/park.group';
import Test from '../sections/sectionstest';
export default class Content extends Component {
  render(props) {
    return (
      <main id="content" className="content">
        <h2>
           Hello {this.props.value}
        </h2>
        <Frame />
        <Info />
        <Popup />
        <GroupPark/>
        <Park/>
        <Test/>
      </main>
    );
  }
}

