import React from 'react'
import { Link } from 'react-router-dom'
import { Route } from 'react-router-dom'

export function makeMenuLink(section, active) {

  //External link
  if (section.href.match("^(http|https)://")) {
    return (<li><a className="" href={section.href}>{section.name}</a></li>)
  }

  if (section.name === active) {
    return (<li key={section.id}><Link className="active" to={section.href}>{section.name}</Link></li>);
  } else {
    return (<li key={section.id}><Link key={section.id} className="" to={section.href}>{section.name}</Link></li>);
  }
}

export function makeInfoLink(section, number) {
  return (<li key={section.id}><Link to={section.href + number}>{section.name}</Link></li>);
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

