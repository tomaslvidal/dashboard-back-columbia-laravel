import Vue from 'vue';

import Vuex from 'vuex';

import Modals from './modules/Modals';

import Users from './modules/Users';

import Vouchers from './modules/Vouchers';

import Destinations from './modules/Destinations';

import Accounts from './modules/Accounts';

import Breadcrumb from './modules/Breadcrumb';

Vue.use(Vuex);

export default new Vuex.Store({
	modules: {
		Modals,
		Users,
		Vouchers,
		Destinations,
		Accounts,
		Breadcrumb
	}
});