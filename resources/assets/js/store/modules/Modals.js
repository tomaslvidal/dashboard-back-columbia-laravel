//ACTIONS:
/*
	* context.state
	* context.commit('mutation')
	* context.rootState
*/

const Modals = {
	state: {
		login: false
	},
	mutations:{
		changeStateLogin: (state, payload) => {
			state.login = !state.login;
		}
	},
	actions:{
		changeStateLogin(context, payload){
			context.commit('changeStateLogin')
		}
	}
}

export default Modals;