// dependencies
import React from 'react';
import ReactDOM from 'react-dom';
import { createStore } from 'redux';

// reducers
import gscpApp from './reducers';

// components
import App from './components/App';

// styles
import './index.css';

const store = createStore(gscpApp);

ReactDOM.render(
  <App store={store} />,
  document.getElementById('root'),
);
