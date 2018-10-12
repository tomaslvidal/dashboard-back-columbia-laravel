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
		},
		UPDATE_ITEM(state, payload){
			if(state.request_made==true){
				let index = state.items.findIndex(item => item.id == payload.id);

				let keys = Object.keys(payload);

				for(var i = 0; i < keys.length; i++){
					state.items[index][keys[i]] = payload[keys[i]];
				}
			}
		}
	},
	actions:{
		async FETCH_ITEMS(context, payload){
    		context.commit('SET_ITEMS', await api.get('vouchers', payload));
		},
		async UPDATE_ITEM(context, payload){
			let item = await api.update('vouchers', payload);

			context.commit('UPDATE_ITEM', payload);
		}
	}
}

export default Vouchers;