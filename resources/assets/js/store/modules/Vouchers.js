import api from '../../gateways/api';

const Vouchers = {
	namespaced: true,
	state: {
		items: [],
		item: {},
		request_made: false
	},
	mutations:{
		async SET_ITEMS(state, payload){
			state.items = await api.get('vouchers', payload);

			state.request_made = true;
		},
		async UPDATE_ITEM(state, payload){
			if(state.request_made==true){
				let index = state.items.findIndex(item => item.id == payload.id);

				let keys = Object.keys(payload);

				for(var i = 0; i < keys.length; i++){
					state.items[index][keys[i]] = payload[keys[i]];
				}
			}
		},
		async SET_ITEM(state, payload){
			if(state.request_made==true){
				let index = state.items.findIndex(item => item.id == payload.id);

				state.item = state.items[index];
			}
			else{
				let item = await api.get('vouchers', payload.id);
				
				state.item = item;
			}
		},
		async ADD_ITEM(state, payload){
			state.items.push(payload);
		},
		async REMOVE_ITEM(state, payload){
			let index = state.items.findIndex(item => item.id == payload.id);

			state.items.splice(index, 1);
		},
		async CLEAR_ITEM(state){
			state.item = {};
		}
	},
	actions:{
		FETCH_ITEMS(context, payload){
    		context.commit('SET_ITEMS', payload);
		},
		UPDATE_ITEM(context, payload){
			context.commit('UPDATE_ITEM', payload);
		},
		GET_ITEM(context, payload){
			context.commit('SET_ITEM', payload);
		},
		ADD_ITEM(context, payload){
			context.commit('ADD_ITEM', payload);
		},
		REMOVE_ITEM(context, payload){
			context.commit('REMOVE_ITEM', payload);
		},
		CLEAR_ITEM(context){
			context.commit('CLEAR_ITEM');
		}
	}
}

export default Vouchers;