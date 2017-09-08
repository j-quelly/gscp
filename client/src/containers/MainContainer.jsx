// dependencies
import React, { Component } from 'react';
import { connect } from 'react-redux';
import { Route, withRouter } from 'react-router-dom'

// components
import Dashboard from '../components/Dashboard';
import List from '../components/List';

// containers
import LoginContainer from './LoginContainer.jsx'

class Main extends Component {
  render() {
    console.log(this.props)
    console.log(this.context)
    return(
      <div className="wrapper">
        <Route exact path="/" component={Dashboard} />
        <Route path="/login" component={LoginContainer} />
        <Route path="/users" component={List} />
      </div>
    );
  }
}

const mapStateToProps = (state) => {
  return {
    token: state.authentication.token,
  };
};

const MainContainer = withRouter(connect(mapStateToProps, null)(Main));

export default MainContainer;