// dependencies
import React from 'react';
import PropTypes from 'prop-types';
import { Provider } from 'react-redux';
import { BrowserRouter as Router } from 'react-router-dom'

// components
import Header from '../Header';

// containers
import SidebarContainer from '../../containers/SidebarContainer';
import MainContainer from '../../containers/MainContainer';

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
      <div className="wrapper">
        <Header />
        <div className="container-fluid container-fluid--fullscreen">
          <div className="row row--fullscreen">
            <SidebarContainer />
            <MainContainer />
          </div>
        </div>
      </div>
    </Router>
  </Provider>
);
App.propTypes = {
  store: PropTypes.object.isRequired,
};

export default App;
