// dependencies
import React, { Component } from 'react';
import { connect } from 'react-redux';
import { Redirect } from 'react-router-dom';
import Isemail from 'isemail';
import PropTypes from 'prop-types';

// actions
import { setToken } from '../actions';

// components
import LoginComponent from '../components/Login';

// helpers
import client from '../lib/Client.js';

class Login extends Component {
  constructor(props) {
    super(props);

    this.onInputChange = this.onInputChange.bind(this);
    this.onKeyPress = this.onKeyPress.bind(this);
    this.validateData = this.validateData.bind(this);
    this.onFormSubmit = this.onFormSubmit.bind(this);
    this.processLogin = this.processLogin.bind(this);
    this.loginFailed = this.loginFailed.bind(this);
    this.displayLoader = this.displayLoader.bind(this);

    this.state = {
      fields: {},
      fieldErrors: {},
      spinner: false,
      loading: false,
    };

  }

  onInputChange(e) {
    const fields = this.state.fields;
    const newFields = {};

    newFields[e.target.name] = e.target.value;

    /**
     * NOTE: this is probably not very good for performance
     *       considering this is only UI state there may be no
     *       reason to use spread operator, but mutation is bad
     */
    this.setState({
      fields: {
        ...fields,
        ...newFields,
      },
    });

  }

  onKeyPress(e) {
    if (e.key === 'Enter') {
      this.onFormSubmit();
    }
  }

  validateData(formData) {
    const errors = {};

    // validate username
    if (!formData.username || formData.username === '' || formData.username === null) {
      errors.username = 'The username entered does not match an account.';
      return errors;
    }

    // validate email address
    if (!Isemail.validate(formData.username)) {
      errors.username = 'Please enter a valid email address.';
      return errors;
    }

    // validate password
    if (!formData.password || formData.password === '' || formData.password === null) {
      errors.password = 'The password entered is incorrect.';
      return errors;
    }

    return errors;

  }

  onFormSubmit() {
    const formData = this.state.fields;
    const fieldErrors = this.validateData(formData);

    this.setState({
      fieldErrors
    });

    // if any field errors then return
    if (Object.keys(fieldErrors).length) return;

    const userData = {
      email: this.state.fields.username,
      password: this.state.fields.password,
    };

    this.processLogin(userData);
  }

  processLogin(userData) {
    this.displayLoader(true);
    client.login(userData, (err) => {
      this.loginFailed('The username or password entered does not match an account.');
    }, (res) => {
      if (res.data.token) {
        this.setState({
          fields: {},
          fieldErrors: {},
        });
        this.props.onSuccess(res.data.token);
      } else {
        this.loginFailed('Something went wrong, please try again.');
      }
      this.displayLoader(false);
    });
  }

  displayLoader(loading) {
    this.setState({
      spinner: loading,
      loading: loading,
    });
  }

  loginFailed(msg) {
    this.setState({
      fieldErrors: {
        password: msg,
      },
      fields: {
        ...this.state.fields,
        password: '',
      },
    });
    this.displayLoader(false);
  }

  render() {
    const { token } = this.props;
    console.log(this.props)

    if (token) {
      return (<Redirect to="/" />);
    }

    return (
      <LoginComponent
        spinner={this.state.spinner}
        loading={this.state.loading}
        fields={this.state.fields}
        handleChange={this.onInputChange}
        handleKeyPress={this.onKeyPress}
        fieldErrors={this.state.fieldErrors}
        handleFormSubmit={this.onFormSubmit}
      />
    );
  }

}
Login.propTypes = {
  onSuccess: PropTypes.func,
};

const mapStateToProps = (state) => {
  return {
    token: state.authentication.token,
  };
};

const mapDispatchToProps = (dispatch) => {
  return {
    onSuccess: (token) => {
      dispatch(setToken(token));
    }
  };
};

const LoginContainer = connect(mapStateToProps, mapDispatchToProps)(Login);

export default LoginContainer;
