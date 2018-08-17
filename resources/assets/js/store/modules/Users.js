import api from '../../gateways/api'

const Users = {
	namespaced: true,
	state: {
		users: {},
		request_made: false
	},
	mutations:{
		SET_USERS(state, payload){
			state.users = payload;

			state.request_made = true;
		}

	},
	actions:{
		async FETCH_USERS(context, payload){
    		context.commit('SET_USERS', await api.get('users', payload));
		}
	}
}

export default Users;