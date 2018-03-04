import http from '../services/http'

export default {
    debug: true,
    state: {
        user: {},
        authenticated: false,
    },

    login(email, password, successCb = null, errorCb = null) {
        var login_param = {email: email, password: password};
        http.post('login', login_param, res => {
            this.state.user = res.data.user;
            this.state.authenticated = true;
            successCb()
        }, error => {
            errorCb()
        })
    },

    setCurrentUser(toLogin = null) {
        http.get('me', res => {
                this.state.user = res.data;
                this.state.authenticated = true;
            }, error => {
                this.state.user = {};
                this.state.authenticated = false;
                // to login
                toLogin()
            }
        )
    },

    logout(successCb = null, errorCb = null) {
        http.get('logout', () => {
            localStorage.removeItem('token');
            this.state.authenticated = false;
            successCb()
        }, errorCb)
    },

    /**
     * Init the store.
     */
    init(toLogin) {
        this.setCurrentUser(toLogin)
    }
}