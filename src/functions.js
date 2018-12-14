import React from 'react'
import { Link } from 'react-router-dom'
import { Route } from 'react-router-dom'

export function makeMenuLink(section, active, setActive) {
  let classActive = ""
  if (section.name === active) {
    classActive = "active"
  }
  if (section.href.match("^(http|https)://")) {
    classActive += " phpLink"
    return (<li key={section.id}><a className={classActive}
      onClick={() => {setActive(section.name)}}
      href={section.href}>{section.name}</a></li>)
  } else {
    classActive += " reactLink"
    return (<li key={section.id}><Link className={classActive}
      onClick={() => {setActive(section.name)}}
      to={section.href}>{section.name}</Link></li>);
  }
}

export function makeInfoLink(section, number) {
  return (<li key={section.id} onClick={toggleMenu}><Link to={section.href + number}>{section.name}</Link></li>);
}

export function makeRoute(section) {
  if (section === undefined) {
    return (<Route />)
  }
  if (section.exact) {
    return (<Route exact path={section.path} component={section.component} />)
  } else {
    return (<Route path={section.path} component={section.component} />)
  }
}

export function toggleMenu() {
  let topnav = document.getElementById("myTopnav");
    if (topnav.className === "topnav") {
      topnav.className += " responsive";
    } else {
      topnav.className = "topnav";
    }

    let menuTitle = document.getElementById("menuTitle");
    if (menuTitle.className === "menuTitle") {
      menuTitle.className += " hidden";
    } else {
      menuTitle.className = "menuTitle";
    }
}

