import App from './App';
import Login from '../login/Login';
import React from 'react';
import { shallow } from 'enzyme';

describe('App', () => {

  it('should render the <Login /> component', () => {
    const wrapper = shallow(<App />);
    expect(
      wrapper.contains(
        <div className="App">
          <Login />
        </div>
      )
    ).toBe(true);
  });

});
