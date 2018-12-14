import React, { Component } from "react";
import Navigation from "./navigation/navigation";
import Content from "./content/content";
import Footnote from "./footnote/footnote";
import AuthCheckHack from "../auth/auth";

//import logo from './logo.svg'
//require('../css/app.css')

class App extends Component {
  constructor(props) {
    super(props)
    this.handler = this.handler.bind(this)
    this.header = {
      active: "Acceuil",
      title: "",
    }
  }

  handler(value) {
    this.setActive({
      active: value
    })
    this.setTitle({
      title: value
    })
  }

  render() {
    return (
      <div>
        <AuthCheckHack />
        <Navigation
          header={this.header}
          handler={this.handler} />
        <Content />
        <Footnote />
      </div>
    );
  }
}

export default App;