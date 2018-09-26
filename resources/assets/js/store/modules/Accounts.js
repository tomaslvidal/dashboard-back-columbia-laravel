import createPersistedState from 'vuex-persistedstate'

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
            email: null,
        },
    },
    mutations:{
        SET_ITEMS(state, payload){
            state.items = payload;

            state.request_made = true;
        }

    },
    actions:{
        async ENTER_ACCOUNT(context, user){
                console.log('user', user)

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

                    context.commit('updateTokens', responseData);
                });
        }
    }
}

export default Accounts;