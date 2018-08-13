//ACTIONS:
/*
	* context.state
	* context.commit('mutation')
	* context.rootState
*/

const Modals = {
	namespaced: true,
	state: {
		logout: false
	},
	mutations:{
		StateLogout: (state, payload) => {
			state.logout = !state.logout;
		}
	},
	actions:{
		StateLogout(context, payload){
			context.commit('StateLogout')
		}
	}
}

export default Modals;