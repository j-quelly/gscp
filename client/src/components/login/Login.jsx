// dependencies
import React, { Component } from 'react';

// components
import { InputForm, InputField, InputError, Btn } from '../form/Form';

// styles
import './Login.css';

class Login extends Component {
  constructor(props) {
    super(props);

    this.onInputChange = this.onInputChange.bind(this);
    this.validateData = this.validateData.bind(this);
    this.onFormSubmit = this.onFormSubmit.bind(this);

    this.state = {
      fields: {},
      fieldErrors: {},
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
        ...newFields
      },
    });

  }

  validateData(formData) {
    const errors = {};

    // validate username
    if (!formData.username || formData.username === '' || formData.username === null) {
      errors.username = 'The username you\'ve entered does not match an account.';
      return errors;
    }

    // validate password
    if (!formData.password || formData.password === '' || formData.password === null) {
      errors.password = 'The password you\'ve entered is incorrect.';
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

    // TODO: need actual validation from api 
    console.log('need actual validation from api ');

    // TODO: update form data
    const username = this.state.fields.username;
    const password = this.state.fields.password;

    // TODO: invoke some function passed as props to log into the applicaiton?
    //       or just a method as part of this class...
    console.log('invoke some function passed as props to log into the applicaiton?');    

    this.setState({
      fields: {},
      fieldErrors: {},
    });

  }

  render() {
    return (
      <div className="row">
        <div className="login col-xs-10 col-xs-offset-1 col-sm-4 col-sm-offset-4">
          <h1 className="login__title">Login</h1>
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
          <small className="login__footer login__footer--right">© Copyright 2013-2016 Studio 174 Inc</small>
        </div>
      </div>
    );
  }

}

export default Login;