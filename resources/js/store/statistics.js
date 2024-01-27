const isEmpty = obj => [Object, Array].includes((obj || {}).constructor) && !Object.entries((obj || {})).length;
export default {
	state : {
		    statData: {}
		},
	mutations : {
		setStatistics(state, payload) {
			if(typeof(payload.statistics) === 'object' && !isEmpty(payload.statistics)) {
				for (const [key, value] of Object.entries(payload.statistics)) {
					state.statData[key] = value;
				}
			}		
		}
	},
	actions: {
		clientDocuments(context, payload) {
        	//
		},
	},
	getters: {
		airmaxStatistics(state) {
			return state.statData?.airmax;
		},
	}
}