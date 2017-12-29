// dependencies
import React, { Component } from 'react';
import { connect } from 'react-redux';
import { Redirect } from 'react-router-dom';
import PropTypes from 'prop-types';

// components
import SidebarComponent from '../components/Sidebar';

// helpers
import client from '../lib/Client';

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
      // console.log(err);
    }, (res) => {
      // console.log(res);
    });
  }

  render() {
    const { token, isLoggedOut } = this.props;

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

Sidebar.propTypes = {
  token: PropTypes.string,
  isLoggedOut: PropTypes.bool,
};

Sidebar.defaultProps = {
  token: '',
  isLoggedOut: true,
};

const mapStateToProps = state => ({
  token: state.authentication.token,
  isLoggedOut: state.authentication.isLoggedOut,
});

const SidebarContainer = connect(mapStateToProps, null)(Sidebar);

export default SidebarContainer;
