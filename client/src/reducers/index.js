import { combineReducers } from 'redux';

import authentication from './authentication';

const gscpApp = combineReducers({
  authentication,
});

export default gscpApp;
