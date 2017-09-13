// dependencies
import React from 'react';
import PropTypes from 'prop-types';

const Wrapper = props => (
  <div className="wrapper">
    {props.children}
  </div>
);
Wrapper.propTypes = {
  children: PropTypes.node,
};
Wrapper.defaultProps = {
  children: null,
};

const WrapperContainer = Wrapper;

export default WrapperContainer;
