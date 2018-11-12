import React, { Component } from 'react';
import '../../css/content/content.css';
import Frame from './frame';
import Info from './info';
import Popup from './popup';

export default class Content extends Component {
  render(props) {
    return (
      <main id="content" className="content">
        <h2>
            Content Component
        </h2>
        <Frame />
        <Info />
        <Popup />
      </main>
    );
  }
}

