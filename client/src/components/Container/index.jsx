// dependencies
import React from 'react';
import PropTypes from 'prop-types';

/**
 * @description Container component to wrap other components or containers
 *
 * @param {object} props - Component props
 * @param {object} props.children - Child components passed to Container
 *
 * @returns {<Container></Container>}
 */
const Container = (props) => (
  <div className="wrapper">
    {props.children}
  </div>
);

// todo: prop types?

export default Container;