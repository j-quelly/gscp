// dependencies
import React from 'react';
import { shallow, mount } from 'enzyme';
import { createMockStore } from 'redux-test-utils';
import { Provider } from 'react-redux';
import { BrowserRouter as Router, Route } from 'react-router-dom'

// components
import App from '../App';
import LoginComponent from '../../containers/LoginContainer';
import Dashboard from '../Dashboard';

// globals
const APP = '<App />';

describe(`${APP}`, () => {
  let state, store, wrapper;

  beforeEach(() => {
    state = {
      authentication: {
        token: false
      }
    },
    store = createMockStore(state),
    wrapper = mount(<App store={store} />);
  });

  it(`should render ${APP}`, () => {
    expect(wrapper.length).toBe(1);
  });

  it(`should render <Provder />`, () => {
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
      it('should render both routes', () => {
        expect(wrapper.find(Route).length).toBe(2)
      })

      it('should have props of type `exact`', () => {
        expect(wrapper.find(Route).at(0).props().exact).toBeTruthy()
      })

      it('should have props of type `path` that equal `/`', () => {
        expect(wrapper.find(Route).at(0).props().path).toEqual('/')
      })

      it('should have props of type `component` that equal `LoginComponent`', () => {
        expect(wrapper.find(Route).at(0).props().component).toEqual(LoginComponent)
      })

      it('should have props of type `path` that equal `/dashboard`', () => {
        expect(wrapper.find(Route).at(1).props().path).toEqual('/dashboard')
      })

      it('should have props of type `component` that equal `Dashboard`', () => {
        expect(wrapper.find(Route).at(1).props().component).toEqual(Dashboard)
      })

      // this is a more succint way of testing the above and makes the above redundant
      it('should render the correct components when the route changes', () => {
        const pathMap = wrapper.find(Route).reduce((pathMap, route) => {
          const routeProps = route.props();
          pathMap[routeProps.path] = routeProps.component;
          return pathMap;
        }, {});
        expect(pathMap['/']).toBe(LoginComponent);
        expect(pathMap['/dashboard']).toBe(Dashboard);
      })
    })

  });

});
