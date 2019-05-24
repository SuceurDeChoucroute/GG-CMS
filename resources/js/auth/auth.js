class Auth {
    constructor() {
        this.token = null;
    }
    
    login(token) {
        window.localStorage.token = token;

        axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;

        this.token = token;
    }

    logout() {
        window.localStorage.removeItem('token');
        this.token = null;
    }

    check() {
        if (window.localStorage.token) {
            this.login(window.localStorage.token);
            return true
        }
        else {
            return !!this.token;
        }
    }
}

export default new Auth();