import api from '../../gateways/api'

const Vouchers = {
	namespaced: true,
	state: {
		items: {},
		request_made: false
	},
	mutations:{
		SET_ITEMS(state, payload){
			state.items = payload;

			state.request_made = true;
		}

	},
	actions:{
		async FETCH_ITEMS(context, payload){
    		context.commit('SET_ITEMS', await api.get('vouchers', payload));
		}
	}
}

export default Vouchers;