// dependencies
import React from 'react';
import PropTypes from 'prop-types';

// styles
import './Forms.css';

/**
 * @description InputForm component represents a dynamic HTML form element
 *
 * @param {object} props - Component props
 * @param {object} props.children - Child components passed to InputForm
 *
 * @returns {<InputForm></InputForm>}
 */
const InputForm = props => (
  <form className="form">
    {props.children}
  </form>
);
InputForm.propTypes = {
  children: PropTypes.node,
};
InputForm.defaultProps = {
  children: null,
};

/**
 * @description InputField component represents any <input /> element
 *
 * @param {object} props - Component props
 * @param {string} props.glyph - Desired bootstrap glyph https://getbootstrap.com/docs/3.3/components/
 * @param {string} props.defaultText - Input placeholder text
 * @param {string} props.inputType - Input type: (text|email|password)
 * @param {string} props.value - Value of input field
 * @param {name} props.name - Input name
 * @param {function} props.handleChange - Method to invoke when input value changes
 * @param {function} props.handleKeyPress - Method to invoke when a key is pressed
 *
 * @returns {<InputField />}
 */
const InputField = (props) => {
  const glyphClass = `glyphicon glyphicon-${props.glyph}`;
  const glyph = (props.glyph ? <i className={glyphClass} /> : null);
  const inputModifier = (glyph ? 'form__input--glyph' : '');
  const inputClass = `form__input ${inputModifier}`;

  return (
    <div className="form__element">
      {glyph}
      <input
        className={inputClass}
        type={props.inputType}
        placeholder={props.defaultText}
        name={props.name}
        value={props.value}
        onChange={e => props.handleChange(e)}
        onKeyPress={e => props.handleKeyPress(e)}
      />
    </div>
  );
};
InputField.propTypes = {
  glyph: PropTypes.string,
  defaultText: PropTypes.string,
  inputType: PropTypes.string.isRequired,
  value: PropTypes.string,
  name: PropTypes.string.isRequired,
  handleChange: PropTypes.func,
  handleKeyPress: PropTypes.func,
};
InputField.defaultProps = {
  glyph: null,
  defaultText: null,
  inputType: 'text',
  value: null,
  name: null,
  handleChange: null,
  handleKeyPress: null,
};

/**
 * @description InputError component for displaying error messages
 *
 * @param {object} props - Component props
 * @param {string} props.errorMessage - Friendly error message describing what went wrong
 *
 * @returns {<InputError />}
 */
const InputError = (props) => {
  if (props.errorMessage) {
    return (
      <p className="form__error">
        {props.errorMessage}
      </p>
    );
  }

  return null;
};
InputError.propTypes = {
  errorMessage: PropTypes.string,
};
InputError.defaultProps = {
  errorMessage: null,
};

/**
 * @description Btn component represents a button typically displayed inside a form
 *              but can be used elsewhere too.
 *
 * @param {object} props - Component props
 * @param {string} props.styles - For aesthetic purposes
 * @param {function} props.handleClick - Method to invoke when button is clicked
 *
 * @returns {<Btn></Btn>}
 */
const Btn = (props) => {
  const btnClass = `form__button ${props.styles} btn`;

  return (
    <button
      type="button"
      className={btnClass}
      onClick={() => props.handleClick()}
    >
      {props.children}
    </button>
  );
};
Btn.propTypes = {
  styles: PropTypes.string,
  handleClick: PropTypes.func.isRequired,
  children: PropTypes.node,
};
Btn.defaultProps = {
  styles: '',
  handleClick: null,
  children: null,
};

export { InputForm, InputField, InputError, Btn };
