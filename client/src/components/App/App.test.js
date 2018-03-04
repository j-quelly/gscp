/* eslint-disable */

// dependencies
import React from 'react';
import { mount } from 'enzyme';
import { createMockStore } from 'redux-test-utils';

// components
import App from '../App';
import ContainerComponent from '../Container';

// containers
import WrapperContainer from '../../containers/WrapperContainer';
import HeaderContainer from '../../containers/HeaderContainer';
import SidebarContainer from '../../containers/SidebarContainer';
import MainContainer from '../../containers/MainContainer';

describe('<App />', () => {
  let wrapper;
  let state;
  let store;

  beforeEach(() => {
    state = {
      authentication: {
        token: '',
        isLoggedOut: false,
      },
    };
    store = createMockStore(state);
    wrapper = mount(<App store={store} />);
  });

  it('should render <App />', () => {
    expect(wrapper.length).toBe(1);
  });

  it('should render <Provder />', () => {
    expect(wrapper.find('Provider').length).toBe(1);
  });

  describe('<Provider />', () => {
    it('should have props of type `store`', () => {
      expect(wrapper.find('Provider').props().store).toBe(store);
    });

    it('should render <Router />', () => {
      expect(wrapper.find('Router').length).toBe(1);
    });

    describe('<Router />', () => {
      it('should render <WrapperContainer />', () => {
        expect(wrapper.find(WrapperContainer).length).toBe(1);
      });

      describe('<WrapperContainer />', () => {
        it('should render <HeaderContainer />', () => {
          expect(wrapper.find(HeaderContainer).length).toBe(1);
        });

        it('should render <ContainerComponent />', () => {
          expect(wrapper.find(ContainerComponent).length).toBe(1);
        });

        describe('<ContainerComponent />', () => {
          it('should render <SidebarContainer />', () => {
            expect(wrapper.find(SidebarContainer).length).toBe(1);
          });

          it('should render <MainContainer />', () => {
            expect(wrapper.find(MainContainer).length).toBe(1);
          });
        });
      });

      // TODO: move these tests to their new respective component or container
      // it('should render both routes', () => {
      //   expect(wrapper.find('Route').length).toBe(2);
      // });

      // it('should have props of type `exact`', () => {
      //   expect(wrapper.find('Route').at(0).props().exact).toBeTruthy();
      // });

      // this is a more succint way of testing the above and makes the above redundant
      // it('should render the correct components when the route changes', () => {
      //   const pathMap = wrapper.find('Route').reduce((pathMap, route) => {
      //     const routeProps = route.props();
      //     pathMap[routeProps.path] = routeProps.component;
      //     return pathMap;
      //   }, {});
      //   expect(pathMap['/']).toBe(LoginComponent);
      //   expect(pathMap['/dashboard']).toBe(Dashboard);
      // });
    });
  });
});
