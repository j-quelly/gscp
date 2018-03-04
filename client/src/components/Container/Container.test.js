/* eslint-disable */

// dependencies
import React from 'react';
import { shallow } from 'enzyme';

// components
import ContainerComponent from '../Container';

// containers
import SidebarContainer from '../../containers/SidebarContainer';
import MainContainer from '../../containers/MainContainer';

describe('Container', () => {
  let wrapper;

  beforeEach(() => {
    wrapper = shallow(
      <ContainerComponent><SidebarContainer /><MainContainer /></ContainerComponent>,
    );
  });

  it('should have a `div` element', () => {
    expect(wrapper.find('div').at(0).length).toBe(1);
  });

  describe('<div>', () => {
    it('should have props of type className', () => {
      expect(wrapper.find('div').at(0).hasClass('container-fluid container-fluid--fullscreen')).toBe(true);
    });

    it('should have a `div` element', () => {
      expect(wrapper.find('div').at(1).length).toBe(1);
    });

    it('should have props of type className', () => {
      expect(wrapper.find('div').at(1).hasClass('row row--fullscreen')).toBe(true);
    });
  });

  it('should render children', () => {
    expect(wrapper.find('div.row.row--fullscreen').children().length).toBe(2);
  });
});
