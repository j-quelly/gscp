// dependencies
import React from 'react';

// components
import { InputForm, InputField } from './Form';

// styles
import './css/Login.css';

const Login = function(props) {
  return (
    <div className="row">
      <div className="login col-xs-10 col-xs-offset-1 col-sm-4 col-sm-offset-4">
        <h1 className="login__title">Login</h1>
        <div className="login__body">
          <InputForm>
            <InputField glyph="user" defaultText="username" inputType="text" />
            <InputField glyph="lock" defaultText="password" inputType="password" />
          </InputForm>
        </div>
        <small className="login__footer login__footer--right">© Copyright 2013-2016 Studio 174 Inc</small>
      </div>
    </div>
    );
};

export default Login;
