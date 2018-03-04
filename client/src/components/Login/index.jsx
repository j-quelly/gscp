// dependencies
import React from 'react';
import PropTypes from 'prop-types';
import classnames from 'classnames';

// components
import { InputForm, InputField, InputError, Btn } from '../Forms';

// styles
import './Login.css';

/**
 * @description LoginComponent component represents application login screen
 *
 * @param {object} props - Component props
 * @param {boolean} props.loading - used to display loading
 * @param {object} props.fields - Object of form fields (username|password)
 * @param {object} props.fieldErrors - Object of form field errors (username|password)
 * @param {function} props.handleChange - Method to invoke when input value changes
 * @param {function} props.handleKeyPress - Method to invoke when a key is pressed
 * @param {function} props.handleFormSubmit - Method to invoke when the form is submit
 *
 * @returns {<LoginComponent />}
 */
const LoginComponent = (props) => {
  const {
    loading, fields, handleChange, handleKeyPress, fieldErrors,
  } = props;

  return (
    <div className="row row--fullscreen row--blue-bg">
      <div className="login col-xs-10 col-xs-offset-1 col-sm-4 col-sm-offset-4">
        <div className={classnames('login__spinner', { 'login__spinner--active': loading, 'login__spinner--inactive': !loading })} />
        <h1 className="login__title">Login</h1>
        <div className={classnames('login__loading', { 'login__loading--active': loading, 'login__loading--inactive': !loading })}>
          <div className="login__body">
            <InputForm>
              <InputField
                glyph="user"
                defaultText="username"
                inputType="email"
                name="username"
                value={fields.username}
                handleChange={handleChange}
                handleKeyPress={handleKeyPress}
              />
              <InputError errorMessage={fieldErrors.username} />
              <InputField
                glyph="lock"
                defaultText="password"
                inputType="password"
                name="password"
                value={fields.password}
                handleChange={handleChange}
                handleKeyPress={handleKeyPress}
              />
              <InputError errorMessage={fieldErrors.password} />
              <Btn styles="form__button--pull-right" handleClick={props.handleFormSubmit}>
                Login
              </Btn>
            </InputForm>
          </div>
        </div>
        <small className="login__footer login__footer--right">© Copyright 2017</small>
      </div>
    </div>
  );
};

LoginComponent.propTypes = {
  loading: PropTypes.bool,
  fields: PropTypes.shape({
    username: PropTypes.string,
    password: PropTypes.string,
  }),
  handleChange: PropTypes.func,
  handleKeyPress: PropTypes.func,
  fieldErrors: PropTypes.shape({
    username: PropTypes.string,
    password: PropTypes.string,
  }),
  handleFormSubmit: PropTypes.func,
};

LoginComponent.defaultProps = {
  loading: false,
  fields: {},
  fieldErrors: {},
  handleChange: null,
  handleKeyPress: null,
  handleFormSubmit: null,
};

export default LoginComponent;
