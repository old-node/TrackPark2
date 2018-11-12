import React from 'react'
import { Link } from 'react-router-dom'
import { Route } from 'react-router-dom'

export function makeMenuLink(section, active) {
  if (section.name === active) {
    return(<li><Link className="sideMenuButton active" to={section.href}>{section.name}</Link></li>);
  } else {
    return(<li key={section.id}><Link key={section.id} className="sideMenuButton" to={section.href}>{section.name}</Link></li>);
  }
}

export function makeInfoLink(section, number) {
  return(<li key={section.id}><Link to={section.href+number}>{section.name}</Link></li>);
}

export function makeRoute(section) {
  if (section === undefined) {
    return(<Route />)
  }
  if (section.exact) {
    return(<Route exact path={section.path} component={section.component}/>)
  } else {
    return(<Route path={section.path} component={section.component}/>)
  }
}

