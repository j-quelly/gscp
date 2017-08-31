import App from './App';
import LoginComponent from '../Login/LoginContainer';
import React from 'react';
import { shallow } from 'enzyme';

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
