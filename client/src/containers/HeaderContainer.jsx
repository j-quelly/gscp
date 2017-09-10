// dependencies
import React, { Component } from 'react';
import { connect } from 'react-redux';

// components
import HeaderComponent from '../components/Header';

class Header extends Component {
  render() {
    const { token } = this.props;

    // TODO: refactor this logic is this logic can be determined elsewhere
    //       and passed as props from mapStateToProps
    const isLoggedOut = !token ? true : false;

    return(
      <HeaderComponent isLoggedOut={isLoggedOut} />
    );
  }
}

const mapStateToProps = (state) => {
  return {
    token: state.authentication.token,
  };
};

const HeaderContainer = connect(mapStateToProps, null)(Header);

export default HeaderContainer;