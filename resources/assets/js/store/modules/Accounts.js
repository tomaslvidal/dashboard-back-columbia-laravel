import router from '../../routes';

const Accounts = {
    namespaced: true,
    state: {
        currentUser: {
            name: null,
            last_name: null,
            email: null,
            id: null
        },
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

    }
};

export default Accounts;