// dependencies
import React, { Component } from 'react';
import { connect } from 'react-redux';

// components
import HeaderComponent from '../components/Header';

/**
 * @description Header container contains logic for header component
 *
 * @param {object} props - Application props
 * @param {object} props.isLoggedOut -
 *
 * @returns {<HeaderContainer />}
 */
class Header extends Component {
  render() {
    const { isLoggedOut } = this.props;

    return(
      <HeaderComponent isLoggedOut={isLoggedOut} />
    );
  }
}

const mapStateToProps = (state) => {
  return {
    isLoggedOut: state.authentication.isLoggedOut,
  };
};

const HeaderContainer = connect(mapStateToProps, null)(Header);

export default HeaderContainer;