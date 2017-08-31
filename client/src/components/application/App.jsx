// dependencies
import React from 'react';
import { Provider } from 'react-redux';
import { BrowserRouter as Router, Route } from 'react-router-dom'

// components
import LoginComponent from '../login/LoginContainer';
import Dashboard from '../dashboard/Dashboard';

const App = ({store}) => (
  <Provider store={store}>
    <Router>
      <div>
        <Route path="/" component={LoginComponent} />
        <Route path="/potato" component={Dashboard} />
      </div>
    </Router>
  </Provider>
);

App.propTypes = {
  store: React.PropTypes.object.isRequired,
};

export default App;
