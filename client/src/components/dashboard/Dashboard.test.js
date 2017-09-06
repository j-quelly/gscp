// dependencies
import React from 'react';
import { shallow } from 'enzyme';

// components
import Dashboard from 'index';

describe('Dashboard', () => {

  it('should render the `Dashboard`', () => {
    const wrapper = shallow(<Dashboard />);
    expect(
      wrapper.contains(
          <div>
            <h1>Dashboard</h1>
          </div>
      )
    ).toBe(true);
  });

});
