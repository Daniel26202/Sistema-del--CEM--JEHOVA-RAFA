//function generica for execute petiticon ajax
export const executePetition = async (url, method, data = null) => {
  try {
    const options = { method: method };

    if (data instanceof FormData) {
      options.body = data;
    } else if (data && typeof data === "object") {
      options.headers = {
        "Content-Type": "application/json",
      };
      options.body = JSON.stringify(data);
    }

    let response = await fetch(url, options);
    return response.json();
  } catch (error) {
    return error;
  }
};
