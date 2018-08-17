//ACTIONS:
/*
	* context.state
	* context.commit('mutation')
	* context.rootState
*/

const Modals = {
	namespaced: true,
	state: {
		logout: false,
		nav_collapse: false
	},
	mutations:{
		StateLogout: (state, payload) => {
			state.logout = !state.logout;
		},
		StateNavCollapse: (state, payload) => {
			state.nav_collapse = !state.nav_collapse;
		}
	},
	actions:{
		StateLogout(context, payload){
			context.commit('StateLogout')
		},
		StateNavCollapse(context, payload){
			context.commit('StateNavCollapse')
		}
	}
}

export default Modals;