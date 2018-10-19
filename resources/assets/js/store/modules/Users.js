import api from '../../gateways/api'

const Users = {
	namespaced: true,
	state: {
		items: [],
		item: {},
		request_made: false,
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
		},
		SET_ITEM(state, payload){
			state.item = payload;
		},
		ADD_ITEM(state, payload){
			state.items.push(payload);
		},
		REMOVE_ITEM(state, payload){
			let index = state.items.findIndex(item => item.id == payload.id);

			state.items.splice(index, 1);
		},
		CLEAR_ITEM(state){
			state.item = {};
		}
	},
	actions:{
		async FETCH_ITEMS(context, payload){
    		context.commit('SET_ITEMS', await api.get('users', payload));
		},
		async UPDATE_ITEM(context, payload){
    		context.commit('UPDATE_ITEM', payload);
		},
		async GET_ITEM(context, payload){
			let item = await api.get('users', payload.id);

			context.commit('SET_ITEM', item[0]);
		},
		async ADD_ITEM(context, payload){
			context.commit('ADD_ITEM', payload);
		},
		async REMOVE_ITEM(context, payload){
			context.commit('REMOVE_ITEM', payload);
		},
		async CLEAR_ITEM(context){
			context.commit('CLEAR_ITEM');
		}
	}
}

export default Users;