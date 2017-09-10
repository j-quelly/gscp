// dependencies
import React from 'react';
import PropTypes from 'prop-types';

/**
 * @description Wrapper component is used to wrap other components or containers
 *
 * @param {object} props - Component props
 * @param {object} props.children - Child components passed to Wrapper
 *
 * @returns {<Wrapper></Wrapper>}
 */
const Wrapper = (props) => (
  <div className="wrapper">
    {props.children}
  </div>
);

// todo: prop types?

export default Wrapper;