// dependencies
import React, { Component } from 'react';
import { connect } from 'react-redux';
import { Redirect } from 'react-router-dom';

// components
import SidebarComponent from '../components/Sidebar';

// helpers
import client from '../lib/Client.js';

class Sidebar extends Component {
  constructor(props) {
    super(props);

    this.getUserDetails = this.getUserDetails.bind(this);
  }

  componentWillMount() {
    this.getUserDetails();
  }

  getUserDetails() {
    const { token } = this.props;

    client.getUserDetails(token, (err) => {
      console.log('something bad happened');
    }, (res) => {
      console.log('something good might have happened');
    });
  }

  render() {
    const { token } = this.props;

    // TODO: refactor this logic is this logic can be determined elsewhere
    //       and passed as props from mapStateToProps
    const isLoggedOut = !token ? true : false;

    // TODO: refactor this logic is this logic can be determined elsewhere
    //       and passed as props from mapStateToProps
    if (!token) {
      return (<Redirect to="/login" />);
    }

    return (
      <SidebarComponent isLoggedOut={isLoggedOut} />
    );
  }
}

const mapStateToProps = (state) => {
  return {
    token: state.authentication.token,
  };
};

const SidebarContainer = connect(mapStateToProps, null)(Sidebar);

export default SidebarContainer;