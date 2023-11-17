export default {
	state : {
			searchString: ''
		},
	mutations : {
		setSearchKey(state, payload) {
			state.searchString = payload;
		}
	},
	getters: {
		searchKey(state) {
			return state.searchString;
		}
	}
}