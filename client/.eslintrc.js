module.exports = {
  "extends": "airbnb",
  "plugins": [
    "jest"
  ],
  "env": {
    "jest/globals": true
  },
  "rules": {
    "react/jsx-filename-extension": [1, { "extensions": [".js", ".jsx"] }]
  }
}