// dependencies
import React from 'react';

// styles
import './css/Login.css';

const Login = function(props) {
  return (
    <div className="row">
      <div className="login col-xs-10 col-xs-offset-1 col-sm-4 col-sm-offset-4">
        <h1 className="login__title">Login</h1>
        <div className="login__body">
          <form className="login-form">
          	<i className="glyphicon glyphicon-user"></i>
            <input
              className="login-form__input"
              type="text"
              placeholder="username"
            />
            <input
              className="login-form__input"
              type="password"
              placeholder="password"
            />
            <button type="button" className="login-form__button btn btn-warning">
              Login
            </button>
          </form>
        </div>
        <small className="login__footer login__footer--right">&copy; Copyright 2013-2016 Studio 174 Inc</small>
      </div>
    </div>
    );
};

export default Login;
