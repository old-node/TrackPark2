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
    this.state = {
      active: "Acceuil",
      title: "",
    }
  }

  handler = async function(value) {
    this.setState({
      active: value
    })
  }
  //
  render() {
    return (
      <div>
        <AuthCheckHack />
        <Navigation
          title={this.state.title}
          active={this.state.active}
          handler={this.handler} />
        <Content />
        <Footnote />
      </div>
    );
  }
}

export default App;