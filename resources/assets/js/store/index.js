import Vue from 'vue';
import Vuex from 'vuex';

import Modals from './modules/Modals';

Vue.use(Vuex);

export default new Vuex.Store({
	modules: {
		Modals
	}
});