export default {
	state : {
		searchString: '',
		httpErrors: {},
		loading: false,
		editorMode: false
	},
	mutations : {
		setSearchKey(state, payload) {
			state.searchString = payload;
		},
		setHttpErrors(state, payload) {
			if (typeof payload === 'object') {
				state.httpErrors = payload;
			}
			if (typeof payload === 'string') {
				if (typeof state.httpErrors.generic === 'undefined') {
					state.httpErrors.generic = []
				}
				state.httpErrors.generic.push(payload)
			}			
		},
		setHttpLoadingState(state,payload) {
			state.loading = !!payload;
		},
		setEditorMode(state, payload) {
			state.editorMode = !!payload;
		},
		swapEditorMode(state, payload) {
			state.editorMode = !state.editorMode;
		}
	},
	actions : {
		httpRequest(context, payload) {
			if (typeof payload === 'object') {
				let url = payload.url;
				let method = payload.method;
				let data = payload.data;
				let mutation = payload.mutation;
				if (typeof url === 'string' && url.length && 
					typeof method === 'string' && method.length &&
					typeof method === 'string' && method.length) {
					context.state.httpErrors = {};
					context.commit('setHttpLoadingState', true);	
					return axios({method, url, data})
              		.then(response => {
              			context.commit('setHttpLoadingState', false);
		                if (response.status >= 200 && response.status < 300) {		                			                  
		                        return response;
		                    } else {
		                        let error = new Error(response.statusText);
		                        error.response = response;
		                        throw error
		                    }
		                }).then(response => {	                			                  
		                    if (response.headers['content-type'] !== 'application/json') {
		                        let error = new Error('Некорректный ответ от сервера');
		                        error.response = response;
		                        throw error
		                    }
		                    return response.data;
		                }).then(json => {
			                if (!!mutation) {
			                	context.commit(mutation, json);
			                }		              	
		                }).catch(error => {
		                	context.commit('setHttpLoadingState', false);
        	                if (typeof error.response === 'object') {
			                if (typeof error.response.data === 'object') {
			                  if (typeof error.response.data.errors === 'object') {
			                    context.commit('setHttpErrors', error.response.data.errors);
			                  } else {
			                  	if (typeof error.response.data.message === 'string') {
			                    	context.commit('setHttpErrors', error.response.data.message);
			                  	}	
			                  }
			                }
			               } else {
								if (typeof error.message !== 'undefined') {
									context.commit('setHttpErrors', error.message);
								}
	                    	}		                     		                  
                	});
        		}
			}	
		}
	},
	getters: {
		searchKey(state) {
			return state.searchString;
		},
		httpErrors(state) {
			return state.httpErrors;
		},
		canEdit(state) {
			return state.editorMode;
		}
	}
}