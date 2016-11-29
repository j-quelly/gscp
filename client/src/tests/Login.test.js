import Login from '../Login';
import React from 'react';
import { shallow } from 'enzyme';

describe('Login', () => {
  let wrapper;

  beforeEach(() => {
    wrapper = shallow(
      <Login />
    );
  });

  it('should have a `h1` element for title', () => {
    expect(
      wrapper.containsMatchingElement(
        <h1>Login</h1>
      )
    ).toBe(true);
  });

  // TODO: more assertions
  // remember me
  // forgot password
  // user field
  // pass field
  // login button
  // errors

  it('should have a `small` element for copyright', () => {
    expect(
      wrapper.containsMatchingElement(
        <small>© Copyright 2013-2016 Studio 174 Inc</small>
      )
    ).toBe(true);
  });

});
