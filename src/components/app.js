import React from 'react'
import Navigation from './navigation/navigation'
import Content from './content/content'
import Footnote from './footnote/footnote'
//import logo from './logo.svg'
//require('../css/app.css')

const App = () => (
  
  <div>
    <Navigation />
    <Content value="test"/>
    <Footnote />
  </div>
)

export default App;

/*
    <h1>
        App Component
    </h1>
  <header className="app-header">
    <img src={logo} className="app-logo" alt="logo" />
    <p>
      Edit <code>src/app.js</code> and save to reload.
    </p>
  </header>
  <header id="navigation"></header>
  <main id="content"></main>
  <footer id="footnote"></footer>
*/
