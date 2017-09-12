// dependencies
import React, { Component } from 'react';

class Wrapper extends Component {
  render() {
    return(
      <div className="wrapper">
        {this.props.children}
      </div>
    );
  }
}
Wrapper.propTypes = {
  children: React.PropTypes.oneOfType([
    React.PropTypes.arrayOf(React.PropTypes.node),
    React.PropTypes.node
  ]),
};

const WrapperContainer = Wrapper;

export default WrapperContainer;