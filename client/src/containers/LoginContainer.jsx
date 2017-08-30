// dependencies
import React, { Component } from 'react';
import { connect } from 'react-redux'

// actions
import { setToken } from '../actions';

// components
import Login from '../components/login/Login';

// helpers
import client from '../lib/Client.js';

class LoginContainer extends Component {
  constructor(props) {
    super(props);

    this.onInputChange = this.onInputChange.bind(this);
    this.validateData = this.validateData.bind(this);
    this.onFormSubmit = this.onFormSubmit.bind(this);
    this.processLogin = this.processLogin.bind(this);
    this.loginFailed = this.loginFailed.bind(this);
    this.displayLoader = this.displayLoader.bind(this);

    /**
     * NOTE: may not need to use react state for UI state
     */
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

    // TODO: impove this; I don't like that I have two event 
    // listeners on the form presentational components
    if (e.key === 'Enter') {
      this.onFormSubmit();
    }

  }

  validateData(formData) {
    const emailRegex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    const errors = {};

    // validate username
    if (!formData.username || formData.username === '' || formData.username === null) {
      errors.username = 'The username entered does not match an account.';
      return errors;
    }

    // validate email address
    if (!emailRegex.test(formData.username)) {
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
      this.loginFailed();
    }, (res) => {
      if (res.data.token) {
        // TODO: some redirection here
        this.setState({
          fields: {},
          fieldErrors: {},
        });
        this.props.onSuccess(res.data.token);
      } else {
        // TODO: some fallback here...
        console.log('something went wrong...');
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

  loginFailed() {
    this.setState({
      fieldErrors: {
        password: 'The username or password entered does not match an account.'
      },
      fields: {
        ...this.state.fields,
        password: '',
      },
    });
    this.displayLoader(false);
  }

  render() {
    return (
      <Login
        spinner={this.state.spinner}
        loading={this.state.loading}
        fields={this.state.fields}
        handleChange={this.onInputChange}
        fieldErrors={this.state.fieldErrors}
        handleFormSubmit={this.onFormSubmit}
      />
    );
  }

}
LoginContainer.propTypes = {
  onSuccess: React.PropTypes.func,
};

const mapStateToProps = (state) => {
  return {
    token: state.token,
  };
};

const mapDispatchToProps = (dispatch) => {
  return {
    onSuccess: (token) => {
      dispatch(setToken(token));
    }
  };
};

const LoginComponent = connect(mapStateToProps, mapDispatchToProps)(LoginContainer);

export default LoginComponent;
