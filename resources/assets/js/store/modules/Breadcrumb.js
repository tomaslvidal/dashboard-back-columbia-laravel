const Breadcrumb = {
	namespaced: true,
	state: {
		items: [],
	},
	mutations:{
		SET_ITEMS(state, payload){
			state.items = payload;
		}

	},
	actions:{
		async SET_ITEMS(context, payload){
    		context.commit('SET_ITEMS', payload);
		}
	}
}

export default Breadcrumb;