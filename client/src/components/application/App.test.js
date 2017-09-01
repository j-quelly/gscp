import React from 'react';
import { Provider } from 'react-redux';
import { mount } from 'enzyme';
import setupIntegrationTest from '../../lib/test-utils.js';

import gscpApp from '../../reducers'

import LoginComponent from '../Login/LoginContainer';

describe('integration tests', () => {
  let store;
  let dispatchSpy;
  let router;

  beforeEach(() => {
    router = {
      params: { myParam: 'any-params-you-have' },
    };
    ({ store, dispatchSpy } = setupIntegrationTest({ myReducer }, router));
  });

  it('should change the text on click', () => {
  const sut = mount(
    <Provider store={store}>
      <LoginComponent />
    </Provider>
  );

  sut.find('div').simulate('click');

  expect(sut.find('div').prop('children')).toEqual('new text');
});
  });

// describe('App', () => {

//   it('should render the <LoginContainer /> component', () => {
//     const wrapper = shallow(<App />);
//     expect(
//       wrapper.contains(
//         <div className="App">
//           <LoginComponent />
//         </div>
//       )
//     ).toBe(true);
//   });

// });
