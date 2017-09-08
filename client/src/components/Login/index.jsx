// dependencies
import React from 'react';
import PropTypes from 'prop-types';

// components
import { InputForm, InputField, InputError, Btn } from '../Forms';

// styles
import './Login.css';

const LoginComponent = function(props) {
  return (
    <div className="row row--fullscreen row--blue-bg">
      <div className="login col-xs-10 col-xs-offset-1 col-sm-4 col-sm-offset-4">
        <div className={props.spinner ? "login__spinner login__spinner--active" : "login__spinner login__spinner--inactive"}></div>
        <h1 className="login__title">Login</h1>
        <div className={props.loading ? "login__loading login__loading--active" : "login__loading login__loading--inactive"}>
          <div className="login__body">
            <InputForm>
              <InputField
                glyph="user"
                defaultText="username"
                inputType="email"
                name="username"
                value={props.fields.username}
                handleChange={props.handleChange}
                handleKeyPress={props.handleKeyPress}
              />
              <InputError errorMessage={props.fieldErrors.username} />
              <InputField
                glyph="lock"
                defaultText="password"
                inputType="password"
                name="password"
                value={props.fields.password}
                handleChange={props.handleChange}
                handleKeyPress={props.handleKeyPress}
              />
              <InputError errorMessage={props.fieldErrors.password} />
              <Btn styles="form__button--pull-right" handleClick={props.handleFormSubmit}>
                Login
              </Btn>
            </InputForm>
          </div>
        </div>
        <small className="login__footer login__footer--right">© Copyright 2013-2017 Studio 174 Inc</small>
      </div>
    </div>
  );
}
LoginComponent.PropTypes = {
  spinner: PropTypes.bool,
  loading: PropTypes.bool,
  fields: PropTypes.object,
  handleChange: PropTypes.func,
  handleKeyPress: PropTypes.func,
  fieldErrors: PropTypes.object,
  handleFormSubmit: PropTypes.func,
};
LoginComponent.defaultProps = {
  spinner: false,
  loading: false,
  fields: {},
  fieldErrors: {},
}

export default LoginComponent;
