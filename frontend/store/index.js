export const state = () => ({
	user: null,
	configs: null,
	packages: [],
	isAuth: false,
});

export const mutations = {
	login(state, { user }) {
		state.isAuth = true;
		state.user = user;
	},
	logout(state) {
		state.isAuth = false;
		state.user = null;
	},
	configs(state, {configs}) {
		state.configs = configs;
	},
	packages(state, {packages}) {
		state.packages = packages;
	},
};

export const getters = {
	isAuthenticated(state) {
		return state.isAuth;
	},
	getUser(state) {
		return state.user;
	},
	getConfigs(state) {
		return state.configs;
	},
	getPackages(state) {
		return state.packages;
	},
};
