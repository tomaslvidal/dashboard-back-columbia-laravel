//
import api from '../../gateways/api'

const Destinations = {
	namespaced: true,
	state: {
		destinations: {},
		request_made: false
	},
	mutations:{
		SET_DESTINATIONS(state, payload){
			state.destinations = payload;

			state.request_made = true;
		},
		SET_DESTINATION(state, payload){
			// let items = state.destinations.find(item => item.id ==)
		},
		UPDATE_DESTINATION(state, payload){
			if(state.request_made==true){
				let index = state.destinations.findIndex(item => item.id == payload.id);

				let keys = Object.keys(payload.data);

				for(var i = 0; i < keys.length; i++){
					state.destinations[index][keys[i]] = payload.data[keys[i]];
				}
			}
		}
	},
	actions:{
		async FETCH_DESTINATIONS(context, payload){
    		context.commit('SET_DESTINATIONS', await api.get('destinations', payload));
		},
		async UPDATE_DESTINATION(context, payload){
			let item = await api.update('destinations', payload.id, payload.data);

    		context.commit('UPDATE_DESTINATION', payload);
		}
	}
}

export default Destinations;