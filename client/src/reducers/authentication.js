import { SET_TOKEN } from '../actions';

/**
 * Reducers
 *
 * NOTE: state should have a property for each component
 *       ie; state.login.componentState
 *       
 * NOTE: You'll often find that you need to store some data, 
 *       as well as some UI state, in the state tree. This is fine, 
 *       but try to keep the data separate from the UI state.
 * 
 */

// TODO: comment/doc this
// TODO: delete token?
// (previousState, action) => newState
const authentication = (state = {
    token: false
  }, action) => {
  switch (action.type) {
    case SET_TOKEN:
      return {
        ...state,
        token: action.token,
      };
    default:
      return state;
  }
};

export default authentication;
