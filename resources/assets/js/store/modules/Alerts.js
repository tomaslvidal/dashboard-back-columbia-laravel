const Alerts = {
	namespaced: true,
	state: {
		save_user: false,
	},
	mutations:{
		save_user_false: (state, payload) => {
			state.save_user = false;
		},
		save_user_true: (state, payload) => {
			state.save_user = true;
		},
	},
	actions:{
		save_user_true: (context, payload) => {
			context.commit('save_user_true')
		},
		save_user_false: (context, payload) => {
			context.commit('save_user_false')
		},
	}
}

export default Alerts;