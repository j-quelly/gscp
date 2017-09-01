import React from 'react';
import { Provider } from 'react-redux';
import { mount } from 'enzyme';

import gscpApp from '../../reducers'

import LoginComponent from '../Login/LoginContainer';

describe('App', () => {

  it('should render the <LoginContainer /> component', () => {
    const wrapper = shallow(<App />);
    expect(
      wrapper.contains(
        <div className="App">
          <LoginComponent />
        </div>
      )
    ).toBe(true);
  });

});
