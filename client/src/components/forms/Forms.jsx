// dependencies
import React from 'react';

// styles
import './Forms.css';

const InputForm = (props) => (
  <form className="form">
    {props.children}
  </form>
);

const InputField = function(props) {
  const glyphClass = `glyphicon glyphicon-${props.glyph}`;
  const glyph = (props.glyph ? <i className={glyphClass}></i> : '');
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
        onChange={(e) => props.handleChange(e)}
        onKeyPress={(e) => props.handleKeyPress(e)}
      />
    </div>
  );
};
InputField.propTypes = {
  glyph: React.PropTypes.string,
  defaultText: React.PropTypes.string,
  inputType: React.PropTypes.string,
  value: React.PropTypes.string,
};
InputField.defaultProps = {
  glyph: '',
  defaultText: '',
  inputType: 'text',
  value: '',
};

const InputError = function(props) {
  if (props.errorMessage) {
    return (
      <p className="form__error">
        {props.errorMessage}
      </p>
    );
  } else {
    return null;
  }
};
InputError.propTypes = {
  errorMessage: React.PropTypes.string,
};
InputError.defaultProps = {
  errorMessage: '',
};

const Btn = function(props) {
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
  styles: React.PropTypes.string,
  handleClick: React.PropTypes.func.isRequired,
};
Btn.defaultProps = {
  styles: '',
};

export { InputForm, InputField, InputError, Btn };
