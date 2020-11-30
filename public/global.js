async function post(url, body) {
    let response = await fetch(url, {
        method: 'POST',
        headers: new Headers({
          'Content-Type': 'application/json'
        }),
        body: body
      });
    let json = await response.json();
    return json;
}

async function postMultipartData(url, data) {
  const formData  = new FormData();

  for(const name in data) {
    formData.append(name, data[name]);
  }
  let response = await fetch(url, {
      method: 'POST',
      body: formData
    });
  let json = await response.json();
  return json;
}

async function get(url, params) {
    let response = await fetch(url);
    let json = await response.json();
    return json;
}