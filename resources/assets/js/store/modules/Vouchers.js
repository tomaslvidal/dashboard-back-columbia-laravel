import api from '../../gateways/api'

const Vouchers = {
	namespaced: true,
	state: {
		vouchers: {},
		request_made: false
	},
	mutations:{
		SET_VOUCHERS(state, payload){
			state.vouchers = payload;

			state.request_made = true;
		}

	},
	actions:{
		async FETCH_VOUCHERS(context, payload){
    		context.commit('SET_VOUCHERS', await api.get('vouchers', payload));
		}
	}
}

export default Vouchers;