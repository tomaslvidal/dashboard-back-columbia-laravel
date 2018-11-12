import Vue from 'vue';

import Vuex from 'vuex';

import Modals from './modules/Modals';

import Alerts from './modules/Alerts';

import Users from './modules/Users';

import Surveys from './modules/Surveys';

import Vouchers from './modules/Vouchers';

import Destinations from './modules/Destinations';

import Accounts from './modules/Accounts';

import Breadcrumb from './modules/Breadcrumb';

Vue.use(Vuex);

export default new Vuex.Store({
	modules: {
		Modals,
		Alerts,
		Surveys,
		Users,
		Vouchers,
		Destinations,
		Accounts,
		Breadcrumb
	}
});