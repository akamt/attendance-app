import axios from 'axios'

export default {
    request(method, url, data, successCb = null, errorCb = null) {
        axios.request({
            url,
            data,
            method: method.toLowerCase()
        }).then(successCb).catch(errorCb)
    },

    get(url, successCb = null, errorCb = null) {
        return this.request('get', url, {}, successCb, errorCb)
    },

    post(url, data, successCb = null, errorCb = null) {
        return this.request('post', url, data, successCb, errorCb)
    },

    put(url, data, successCb = null, errorCb = null) {
        return this.request('put', url, data, successCb, errorCb)
    },

    delete(url, data = {}, successCb = null, errorCb = null) {
        return this.request('delete', url, data, successCb, errorCb)
    },

    /**
     * Init the service.
     */
    init() {
        axios.defaults.baseURL = '/api';

        // Intercept the request to make sure the token is injected into the header.
        axios.interceptors.request.use(config => {
            config.headers['X-CSRF-TOKEN'] = window.Laravel.csrfToken;
            config.headers['X-Requested-With'] = 'XMLHttpRequest';
            config.headers['Authorization'] = `Bearer ${localStorage.getItem('token')}`;
            return config
        });

        // Intercept the response and ...
        axios.interceptors.response.use(response => {
            // ...get the token from the header or response data if exists, and save it.
            const token = response.headers['Authorization'] || response.data['access_token'];
            if (token) {
                localStorage.setItem('token', token)
            }

            return response
        }, error => {
            // Also, if we receive a Bad Request / Unauthorized error
            let statusCode = error.response.status;

            if (statusCode === 405 || statusCode === 403 || statusCode === 404) {
                window.location.href = '/';
            }
            return Promise.reject(error)
        })
    }
}