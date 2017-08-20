import { InputForm, InputField, Btn } from '../form/form';
import React from 'react';
import { shallow } from 'enzyme';

describe('Form', () => {

  it('should have a `form` element', () => {
    const wrapper = shallow(
      <InputForm />
    );
    expect(
      wrapper.containsMatchingElement(
        <form></form>
      )
    ).toBe(true);
  });

});

describe('InputField', () => {
  let wrapper;

  beforeEach(() => {
    wrapper = shallow(
      <InputField />
    );
  });

  it('should have an `input` element', () => {
    expect(
      wrapper.containsMatchingElement(
        <input />
      )
    ).toBe(true);
  });

  describe('the user populates the input', () => {
    const username = 'johndoe@example.com';

    beforeEach(() => {
      const input = wrapper.find('input').first();
      input.simulate('change', {
        target: {
          value: username
        }
      })
    });

    // TODO:  ... assertions
    
  });

});

describe('Btn', () => {
  let wrapper;

  beforeEach(() => {
    wrapper = shallow(
      <Btn />
    );
  });

  it('should have a `button` element', () => {
    expect(
      wrapper.containsMatchingElement(
        <button type="button"></button>
      )
    ).toBe(true);
  });

  it('`button` should be of type "button"', () => {
    const button = wrapper.find('button').first();
    expect(
      button.props().type
    ).toBe('button');
  });

});
