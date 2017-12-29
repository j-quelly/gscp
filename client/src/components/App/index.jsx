// dependencies
import React from 'react';
import PropTypes from 'prop-types';
import { Provider } from 'react-redux';
import { BrowserRouter as Router } from 'react-router-dom';

// components
import ContainerComponent from '../Container';

// containers
import HeaderContainer from '../../containers/HeaderContainer';
import SidebarContainer from '../../containers/SidebarContainer';
import MainContainer from '../../containers/MainContainer';
import WrapperContainer from '../../containers/WrapperContainer';

/**
 * @description App component represents GSCP application
 *
 * @param {object} store - The application state
 *
 * @returns {<App />}
 */
const App = ({ store }) => (
  <Provider store={store}>
    <Router>
      <WrapperContainer>
        <HeaderContainer />
        <ContainerComponent>
          <SidebarContainer />
          <MainContainer />
        </ContainerComponent>
      </WrapperContainer>
    </Router>
  </Provider>
);

App.propTypes = {
  store: PropTypes.shape({
    // TODO:
  }).isRequired,
};

App.defaultProps = {
  store: {},
};

export default App;
