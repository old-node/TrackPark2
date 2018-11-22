import React from 'react'
import { Switch } from 'react-router-dom'
import { sections_group, sections } from '../../constants'
import { makeRoute } from '../../functions'

// The Switche component matches one of two different routes
// depending on the full pathname
const AthleteSwitch = () => (
  <Switch>
    {makeRoute(sections_group[1].component)}
    {makeRoute(sections[1].component)}
  </Switch>
)

export default AthleteSwitch
