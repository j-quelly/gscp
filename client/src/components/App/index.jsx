// dependencies
import React from 'react';
import PropTypes from 'prop-types';
import { Provider } from 'react-redux';
import { BrowserRouter as Router, Route } from 'react-router-dom'

// components
import LoginComponent from '../../containers/LoginContainer';
import Dashboard from '../Dashboard'; // TODO: finish this...

/**
 * @description App component represents GSCP application
 *
 * @param {object} store - The application state
 *
 * @returns {<App />}
 */
const App = ({store}) => (
  <Provider store={store}>
    <Router>
      <div>
        <Route exact path="/" component={LoginComponent} />
        <Route path="/dashboard" component={Dashboard} />
      </div>
    </Router>
  </Provider>
);
App.propTypes = {
  store: PropTypes.object.isRequired,
};

export default App;
