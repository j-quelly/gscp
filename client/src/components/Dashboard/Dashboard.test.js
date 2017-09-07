// dependencies
import React from 'react';
import { shallow } from 'enzyme';

// components
import Dashboard from '../Dashboard';
import ListContainer from '../../containers/ListContainer'

describe('Dashboard', () => {

  it('should render the `<ListContainer />`', () => {
    const wrapper = shallow(<Dashboard />);
    expect(wrapper.contains(<ListContainer />)).toBe(true);
  });

});
