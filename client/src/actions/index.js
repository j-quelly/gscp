/**
 * Action Types
 *
 * NOTE: types should typically be defined as string constants
 *
 */

export const SET_TOKEN = 'SET_TOKEN';
export const SET_LOGIN_STATUS = 'SET_LOGIN_STATUS';

/**
 * Action Creators
 *
 */
export function setToken(token) {
  return {
    type: SET_TOKEN,
    token,
  };
}

// TODO: comment
// TODO: perhaps both of these actions can be combined in the future...
export function setLoginStatus(isLoggedOut) {
  return {
    type: SET_LOGIN_STATUS,
    isLoggedOut,
  };
}
