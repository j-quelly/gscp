// dependencies
import React from 'react';
import { connect } from 'react-redux';
import PropTypes from 'prop-types';

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
const Header = (props) => {
  const { isLoggedOut } = props;

  return (
    <HeaderComponent isLoggedOut={isLoggedOut} />
  );
};

Header.propTypes = {
  isLoggedOut: PropTypes.bool,
};

Header.defaultProps = {
  isLoggedOut: true,
};

const mapStateToProps = state => ({
  isLoggedOut: state.authentication.isLoggedOut,
});

const HeaderContainer = connect(mapStateToProps, null)(Header);

export default HeaderContainer;
