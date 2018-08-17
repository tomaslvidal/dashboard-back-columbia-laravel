//
import api from '../../gateways/api'

const Destinations = {
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
		SET_ITEM(state, payload){
			// let items = state.items.find(item => item.id ==)
		},
		UPDATE_ITEM(state, payload){
			if(state.request_made==true){
				let index = state.items.findIndex(item => item.id == payload.id);

				let keys = Object.keys(payload.data);

				for(var i = 0; i < keys.length; i++){
					state.items[index][keys[i]] = payload.data[keys[i]];
				}
			}
		}
	},
	actions:{
		async FETCH_ITEMS(context, payload){
    		context.commit('SET_ITEMS', await api.get('destinations', payload));
		},
		async UPDATE_ITEM(context, payload){
			let item = await api.update('destinations', payload.id, payload.data);

    		context.commit('UPDATE_ITEM', payload);
		}
	}
}

export default Destinations;