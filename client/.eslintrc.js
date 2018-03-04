module.exports = {
  extends: 'airbnb',
  env: {
    'browser': true
  },
  rules: {
    'react/jsx-filename-extension': [ 1, {extensions: [ '.js', '.jsx' ]} ],
    'no-unused-vars': [1],
    'import/prefer-default-export': [1],
    'no-mixed-operators': [0, { 'allowSamePrecedence': true } ],
    'max-len': [0],
  }
};
