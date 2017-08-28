// dependencies
import React, { Component } from 'react';

// components
import { InputForm, InputField, InputError, Btn } from '../forms/Forms';

// helpers
import client from '../../lib/Client.js';

// styles
import './Login.css';

class Login extends Component {
  constructor(props) {
    super(props);

    this.onInputChange = this.onInputChange.bind(this);
    this.validateData = this.validateData.bind(this);
    this.onFormSubmit = this.onFormSubmit.bind(this);
    this.processLogin = this.processLogin.bind(this);
    this.loginFailed = this.loginFailed.bind(this);
    this.displayLoader = this.displayLoader.bind(this);

    this.state = {
      fields: {},
      fieldErrors: {},
      token: false,
      spinner: 'login__spinner login__spinner--inactive',
      loading: 'login__loading login__loading--inactive',
    };

  }

  onInputChange(e) {
    const fields = this.state.fields;
    const newFields = {};

    newFields[e.target.name] = e.target.value;

    // NOTE: this is probably not very good for performance...
    this.setState({
      fields: {
        ...fields,
        ...newFields,
      },
    });

    // TODO: impove this, I don't like that I have to event listeners 
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
          token: res.data.token,
        });
      } else {
        // TODO: some fallback here...
        console.log('something went wrong...');
      }
      this.displayLoader(false);
    });
  }

  displayLoader(loading) {
    if (loading) {
      this.setState({
        spinner: 'login__spinner login__spinner--active',
        loading: 'login__loading login__loading--active',
      });
    } else {
      this.setState({
        spinner: 'login__spinner login__spinner--inactive',
        loading: 'login__loading login__loading--inactive',
      });
    }
  }

  loginFailed() {
    // TODO: do not mutate or start using redux...
    this.setState({
      fieldErrors: {
        password: 'The username or password entered does not match an account.'
      },
      fields: {
        username: this.state.fields.username,
        password: '',
      },
    });
    this.displayLoader(false);
  }

  render() {
    return (
      <div className="row">
        <div className="login col-xs-10 col-xs-offset-1 col-sm-4 col-sm-offset-4">
          <div className={this.state.spinner}></div>
          <h1 className="login__title">Login</h1>
          <div className={this.state.loading}>
            <div className="login__body">
              <InputForm>
                <InputField
                  glyph="user"
                  defaultText="username"
                  inputType="email"
                  name="username"
                  value={this.state.fields.username || ''}
                  handleChange={(e) => this.onInputChange(e)}
                />
                <InputError errorMessage={this.state.fieldErrors.username} />
                <InputField
                  glyph="lock"
                  defaultText="password"
                  inputType="password"
                  name="password"
                  value={this.state.fields.password || ''}
                  handleChange={(e) => this.onInputChange(e)}
                />
                <InputError errorMessage={this.state.fieldErrors.password} />
                <Btn styles="form__button--pull-right" handleClick={this.onFormSubmit}>
                  Login
                </Btn>
              </InputForm>
            </div>
          </div>
          <small className="login__footer login__footer--right">© Copyright 2013-2016 Studio 174 Inc</small>
        </div>
      </div>
    );
  }

}

export default Login;
