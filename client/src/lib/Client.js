import 'whatwg-fetch';

// TODO: rewrite this as a proper es6/7 class
// TODO: comment/document

function serialize(obj) {
  const str = [];
  for (const p in obj) {
    if (obj.hasOwnProperty(p)) {
      str.push(`${encodeURIComponent(p)}=${encodeURIComponent(obj[p])}`);
    }
  }
  return str.join('&');
}

function checkStatus(response) {
  if (response.status >= 200 && response.status < 300) {
    return response;
  }
  const error = new Error(`HTTP Error ${response.statusText}`);
  error.status = response.statusText;
  error.response = response;
  throw error;
}

function login(userData, onError, cb) {
  return fetch('/v1/auth/login', {
    method: 'post',
    body: serialize(userData),
    headers: {
      Accept: 'application/json',
      'Content-Type': 'application/x-www-form-urlencoded',
    },
  }).then(checkStatus)
    .then(parseJSON)
    .then(cb)
    .catch(onError);
}

function getUserDetails(token, onError, cb) {
  return cb(true);
  // return fetch('/v1/auth/user', {
  //   method: 'get',
  //   body: serialize(token),
  //   headers: {
  //     'Accept': 'application/json',
  //     'Content-Type': 'application/x-www-form-urlencoded',
  //   },
  // }).then(checkStatus)
  //   .then(parseJSON)
  //   .then(cb)
  //   .catch(onError);
}


function parseJSON(response) {
  return response.json();
}

const Client = {
  login,
  getUserDetails,
};

export default Client;
