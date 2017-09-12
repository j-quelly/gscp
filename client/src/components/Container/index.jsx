// dependencies
import React from 'react';
import PropTypes from 'prop-types';

/**
 * @description ContainerComponent wraps other components or containers
 *
 * @param {object} props - Component props
 * @param {object} props.children - Child components passed to ContainerComponent
 *
 * @returns {<ContainerComponent></ContainerComponent>}
 */
const ContainerComponent = (props) => (
  <div className="container-fluid container-fluid--fullscreen">
    <div className="row row--fullscreen">
      {props.children}
    </div>
  </div>
);
ContainerComponent.propTypes = {
  children: PropTypes.node,
};

export default ContainerComponent;