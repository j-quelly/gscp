// dependencies
import React, { Component } from 'react';
import { connect } from 'react-redux';

// components
import SidebarComponent from '../components/Sidebar';

class Sidebar extends Component {
  constructor(props) {
    super(props);

    this.getUserDetails = this.getUserDetails.bind(this);
  }

  componentWillMount() {
    // console.log('before component mounts, get user details...');
    this.getUserDetails();
  }

  getUserDetails() {
    // const { token } = this.props;

    // client.getUserDetails(token, (err) => {
    //   console.log('something bad happened');
    // }, (res) => {
    //   console.log('something good might have happened');
    // });
  }

  render() {
    // console.log(this.props);
    return(
      <SidebarComponent />
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