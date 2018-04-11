export default function ({ $axios, store }) {
  $axios.onError(error => {
    if (error.response.status === 422) {
      store.dispatch('validation/setErrors', error.response.data.errors);
    }

    if (error.response.status === 500 && error.response.data.error)
    {
      store.dispatch('messages/setError', error.response.data.error);
    }

    return Promise.reject(error)
  });

  $axios.onRequest((request) => {


    store.dispatch('validation/clearErrors')
  });

  $axios.onResponse((response) => {
    if(response.status === 200 || response.status === 201)
    {
      if(response.data.success)
      {
        store.dispatch('messages/setSuccess', response.data.success)
      }
    }
  });
};
