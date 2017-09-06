// dependencies
import React from 'react';

// components
import { InputForm, InputField, InputError, Btn } from '../Forms';

// styles
import './Login.css';

const Login = function(props) {
  return (
    <div className="row">
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
Login.PropTypes = {
  spinner: React.PropTypes.bool,
  loading: React.PropTypes.bool,
  fields: React.PropTypes.object,
  handleChange: React.PropTypes.func,
  handleKeyPress: React.PropTypes.func,
  fieldErrors: React.PropTypes.object,
  handleFormSubmit: React.PropTypes.func,
};
Login.defaultProps = {
  spinner: false,
  loading: false,
  fields: {},
  fieldErrors: {},
}

export default Login;
