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
		nav_collapse: false,
		modal_edit_save_state: false,
	},
	mutations:{
		StateLogout: (state, payload) => {
			state.logout = !state.logout;
		},
		StateNavCollapse: (state, payload) => {
			state.nav_collapse = !state.nav_collapse;
		},
		StateModalEditSave: (state, payload) => {
			state.modal_edit_save_state = !state.modal_edit_save_state;
		}
	},
	actions:{
		StateLogout(context, payload){
			context.commit('StateLogout')
		},
		StateNavCollapse(context, payload){
			context.commit('StateNavCollapse')
		},
		StateModalEditSave: (context, payload) => {
			context.commit('StateModalEditSave')
		}
	}
}

export default Modals;