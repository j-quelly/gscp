// TODO: improve this file
function login(userData, onError, cb) {
  return fetch('http://localhost:8888/v1/auth/login', {
    mode: 'no-cors',
    method: 'post',
    body: JSON.stringify(userData),
    headers: {
      'Accept': 'application/json',
      'Content-Type': 'application/json',
    },
  }).then(checkStatus)
    .then(parseJSON)
    .then(cb)
    .catch(onError);
}

function checkStatus(response) {
  if (response.status >= 200 && response.status < 300) {
    return response;
  } else {
    const error = new Error(`HTTP Error ${response.statusText}`);
    error.status = response.statusText;
    error.response = response;
    throw error;
  }
}

function parseJSON(response) {
  return response.json();
}

const Client = {
  login,
};

export default Client;
