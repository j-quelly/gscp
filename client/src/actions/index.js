/**
 * Action Types
 *
 * NOTE: types should typically be defined as string constants
 *
 */

export const SET_TOKEN = 'SET_TOKEN';

/**
 * Action Creators
 *
 */

export function setToken(token) {
  return {
    type: SET_TOKEN,
    token
  };
}
