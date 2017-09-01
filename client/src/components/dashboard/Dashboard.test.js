import Dashboard from '../Dashboard';
import React from 'react';
import { shallow } from 'enzyme';

describe('Dashboard', () => {

  it('should render the `HIMELOW WARLD`', () => {
    const wrapper = shallow(<Dashboard />);
    expect(
      wrapper.contains(
          <div>
            <h1>HIMELOW WARLD</h1>
          </div>
      )
    ).toBe(true);
  });

});
