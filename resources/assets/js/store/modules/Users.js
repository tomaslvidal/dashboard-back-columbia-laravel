import api from '../../gateways/api'

const Users = {
	namespaced: true,
	state: {
		items: {},
		request_made: false,
		save_made: false
	},
	mutations:{
		SET_ITEMS(state, payload){
			state.items = payload;

			state.request_made = true;
		},
		UPDATE_ITEM(state, payload){
			if(state.save_made==false){
				if(state.request_made==true){
					let index = state.items.findIndex(item => item.id == payload.id);

					let keys = Object.keys(payload);

					for(var i = 0; i < keys.length; i++){
						state.items[index][keys[i]] = payload[keys[i]];
					}

					state.save_made = true;
				}
			}
		},
		SET_SAVE_MADE_TO_FALSE(state, payload){
			state.save_made = false;
		}
	},
	actions:{
		async FETCH_ITEMS(context, payload){
    		context.commit('SET_ITEMS', await api.get('users', payload));
		},
		async ONLY_INTERN_UPDATE_ITEM(context, payload){
			context.commit('UPDATE_ITEM', payload);
		},
		async SET_SAVE_MADE_TO_FALSE(context, payload){
			context.commit('SET_SAVE_MADE_TO_FALSE', payload);
		},
		async UPDATE_ITEM(context, payload){
			let item = await api.update('users', payload);

    		context.commit('Alerts/save_user_false', null, { root: true });

    		context.commit('UPDATE_ITEM', payload);

    		setTimeout(() => {
    			context.commit('Alerts/save_user_true', null, { root: true });
    		}, 1)
		}
	}
}

export default Users;