// dependencies
import React from 'react';
import { shallow } from 'enzyme';

// components
import { InputForm, InputField, InputError, Btn } from '../Forms';

describe('<InputForm />', () => {
  let wrapper;

  beforeEach(() => {
    wrapper = shallow(<InputForm />);
  });

  it('should have a `form` element', () => {
    expect(
      wrapper.containsMatchingElement(
        <form></form>
      )
    ).toBe(true);
  });

  it('`<form>` element should have className attribute of type `form`', () => {
    expect(
      wrapper.find('form').props().className
    ).toBe('form')
  });

  it('should render child components', () => {
    wrapper = shallow(
      <InputForm>
        <InputField />
      </InputForm>
    );
    expect(
      wrapper.find('InputField').length
    ).toBe(1);
  });

});

describe('<InputField />', () => {
  let wrapper, props;

  beforeEach(() => {
    props = {
      handleClick: () => {},
      glyph: 'potato',
      inputType: 'text',
      defaultText: 'derp',
      name: 'username',
      value: 'johndoe@example.com',
      handleChange: () => {},
    };
    wrapper = shallow(
      <InputField {...props} />
    );
  });

  it('should have a `<div>` element', () => {
    expect(
      wrapper.find('div').length
    ).toBe(1);
  });

  it('`<div>` element className should be form__element', () => {
    expect(
      wrapper.find('div').props().className
    ).toBe('form__element');
  });

  it('`<div>` element should render a glyph when passed as props', () => {
    wrapper = wrapper.find('div');
    expect(
      wrapper.find('i').length
    ).toBe(1);
  });

  it('`<div>` glyph should be `potato`', () => {
    wrapper = wrapper.find('div');
    expect(
      wrapper.find('i').props().className
    ).toBe(`glyphicon glyphicon-${props.glyph}`);
  });

  it('`<div>` should have an `<input>` element', () => {
    expect(
      wrapper.find('input').length
    ).toBe(1);
  });

  it('`<input>` element should have a className attribute of type `form__input`', () => {
    expect(
      wrapper.find('input').props().className
    ).toBe(`form__input form__input--glyph`);
  });

  it('`<input>` element should have a type attribute of type `text` when passed as props', () => {
    expect(
      wrapper.find('input').props().type
    ).toBe(props.inputType);
  });

  it('`<input>` element should have a placeholder attribute of type `derp` when passed as props', () => {
    expect(
      wrapper.find('input').props().placeholder
    ).toBe(props.defaultText);
  });

  it('`<input>` element should have a name attribute of type `username` when passed as props', () => {
    expect(
      wrapper.find('input').props().name
    ).toBe(props.name);
  });

  it('`<input>` element should have a value attribute of type `johndoe@example.com` when passed as props', () => {
    expect(
      wrapper.find('input').props().value
    ).toBe(props.value);
  });

  it('`<input>` element should have an onChange attribute', () => {
    expect(
      wrapper.find('input').props().onChange
    ).toBeDefined();
  });

  it('`<input>` onChange attribute should be of type `function`', () => {
    expect(
      typeof wrapper.find('input').props().onChange === 'function'
    ).toBe(true);
  });

});

describe('<InputError />', () => {
  let wrapper, props;

  beforeEach(() => {
    wrapper = shallow(
      <InputError />
    );
  });

  it('should render nothing when no props passed', () => {
    expect(wrapper.get(0)).toBeFalsy();
  });

  it('should render an error message when props passed', () => {
    props = { errorMessage: 'You fked up' };
    wrapper = shallow(<InputError {...props} />);
    expect(wrapper.find('p').text()).toBe(props.errorMessage);
  });

  it('should contain a `<p>` element', () => {
    props = { errorMessage: 'You fked up' };
    wrapper = shallow(<InputError {...props} />);
    expect(
      wrapper.find('p').length
    ).toBe(1);
  });

  it('`<p>` element should have a className attribute of type `form__error`', () => {
    props = { errorMessage: 'You fked up' };
    wrapper = shallow(<InputError {...props} />);
    expect(
      wrapper.find('p').props().className
    ).toBe('form__error');
  });

});

describe('<Btn />', () => {
  let wrapper, props;

  beforeEach(() => {
    props = {
      handleClick: () => {},
      styles: 'potato'
    };
    wrapper = shallow(
      <Btn {...props}>
        Login
      </Btn>
    );
  });

  it('should have a `button` element', () => {
    expect(
      wrapper.containsMatchingElement(
        <button type="button">Login</button>
      )
    ).toBe(true);
  });

  it('`button` should be of type "button"', () => {
    const button = wrapper.find('button').first();
    expect(
      button.props().type
    ).toBe('button');
  });

  it('`button` should have attribute className of type `function`', () => {
    const button = wrapper.find('button').first();
    const btnClass = `form__button ${props.styles} btn`;
    expect(
      typeof button.props().onClick === 'function'
    ).toBe(true);
  });

  it('`button` should display Login', () => {
    expect(
      wrapper.text()
    ).toBe('Login');
  });

});
