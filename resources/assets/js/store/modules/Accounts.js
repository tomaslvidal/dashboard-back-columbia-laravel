import createPersistedState from 'vuex-persistedstate'

import router from '../../routes';

const Accounts = {
    plugins: [createPersistedState()],
    namespaced: true,
    state: {
        tokens: {
            access_token: null,
            expires_in: null,
            refresh_token: null,
            token_type: null,
        },
        currentUser: {
            name: null,
            last_name: null,
            email: null,
            id: null
        },
        isAuthenticated: null,
    },
    mutations:{
        UPDATE_TOKENS(state, payload){
            state.tokens = payload;
        },
        AUTHENTICATED_TRUE(state, payload){
            state.isAuthenticated = true;
        },
        AUTHENTICATED_FALSE(state, payload){
            state.isAuthenticated = null;
        },
        SET_USER(state, payload){
            state.currentUser = payload;
        }
    },
    actions:{
        async ENTER_ACCOUNT(context, user){
                let data = {
                    client_id: 2,
                    client_secret: 'YdDDU3QNKu290Uf4qoat5FQcBiseLXrI4fJD33aw',
                    grant_type: 'password',
                    username: user.email,
                    password: user.password,
                };

                axios.post('/oauth/token', data)
                    .then(response => {
                        let responseData = response.data;
                        
                        let now = Date.now();

                        responseData.expires_in = responseData.expires_in + now;

                        context.commit('UPDATE_TOKENS', responseData);

                        axios.defaults.headers.common['Authorization'] = 'Bearer '+context.state.tokens.access_token;

                        localStorage.setItem('user-token', context.state.tokens.access_token);

                        axios.get('/api/users/2')
                            .then(response => {
                                response = response.data[0];

                                let data = {
                                    "name" : response.name,
                                    "last_name" : response.last_name,
                                    "email" : response.email,
                                    "id" : response.id
                                }

                                context.commit('SET_USER', data);

                                context.commit('AUTHENTICATED_TRUE');

                                router.push({ name: "home"})
                            });
                        
                    });
        }
    }
}

export default Accounts;