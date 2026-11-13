const isEmpty = obj => [Object, Array].includes((obj || {}).constructor) && !Object.entries((obj || {})).length;
import moment from "moment/dist/moment";
export default {
	state : {
		    all: [],
		    current: {
	    		id: '',
	    		level_headwater_iv: null,
	    		level_local: null,
	    		temp_ext: null,
	    		temp_local: null,
	    		ice_thickness_ext: null,
	    		ice_thickness_local: null,
	    		turbulence: null
		    }
		},
	mutations : {
		setHydrometry(state, payload) {
			let currentDate = moment().format('YYYY-MM-DD');
			state.current.created_at = moment().format('YYYY-MM-DD HH:mm:ss');
			if(typeof(payload.hydrometries) === 'object' && !isEmpty(payload.hydrometries)) {
				state.all = payload.hydrometries;
				let current = state.all.find(el => el.created_at?.indexOf(currentDate) === 0);
				if (!isNaN(current?.id)) {
					state.current = current;
				}
			}
		},
		afterDeleteHydrometry(state, payload) {
			state.all = state.all.filter(el => el.id !== payload.deleted);
		},
	},
	actions: {
		newAction(context, payload) {
        	//
		},
	},
	getters: {
		allHydrometry(state) {
			return state.all;
		},
		currentHydrometry(state) {
			return state.current;
		},
	    hydrometryByDate: (state) => (id) => {
	    }
	}
}