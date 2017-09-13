// dependencies
import React from 'react';
import { connect } from 'react-redux';
import { Route, withRouter } from 'react-router-dom';

// components
import Dashboard from '../components/Dashboard';
import List from '../components/List';

// containers
import LoginContainer from './LoginContainer';

const Main = () => (
  <div className="wrapper">
    <Route exact path="/" component={Dashboard} />
    <Route path="/login" component={LoginContainer} />
    <Route path="/users" component={List} />
    <Route path="*" componennt={Dashboard} />
  </div>
);

const mapStateToProps = state => (
  {
    token: state.authentication.token,
  }
);

const MainContainer = withRouter(connect(mapStateToProps, null)(Main));

export default MainContainer;
