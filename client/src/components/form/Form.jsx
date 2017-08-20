// dependencies
import React from 'react';

// styles
import './Form.css';

const InputForm = function(props) {
  return (
    <form className="form">
      {props.children}    
    </form>
    );
};

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
      />
    </div>
    );
};
InputField.propTypes = {
  glyph: React.PropTypes.string,
  defaultText: React.PropTypes.string,
  inputType: React.PropTypes.string,
};
InputField.defaultProps = {
  glyph: '',
  defaultText: '',
  inputType: 'text',
};

const Btn = function(props) {
  const btnClass = `form__button ${props.styles} btn`;
  return (
      <button type="button" className={btnClass}>
        {props.children}
      </button>  
   );
};
Btn.propTypes = {
  styles: React.PropTypes.string,
};
Btn.defaultProps = {
  styles: '',
};

export { InputForm, InputField, Btn };
