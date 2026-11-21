import moment from "moment/dist/moment";
export default {
	state : {
    current: null,
    history: null,
    updatedAt: null,
    stats: [],
    units: {
      level: 'CM',
      ice_thickness: 'mm'
    },
    perDay: null,
    perMonth: null,
    perWeek: null,
	},
	mutations : {
    setHydrometry(state, payload) {
      if(payload?.current) {
        state.current = payload.current;
      } else {
        if(payload.history.length) {
          state.current = payload.history.at(-1);
        }
      }
      if (typeof state.current?.updated_at !== 'undefined') {
        state.updatedAt =  moment(state.current.updated_at).format('DD.MM.YYYY HH:mm');
      }
      state.history = payload?.history ?? null;
      state.stats = payload?.stats ?? null;
      state.perDay = payload?.perDay ?? null;
      state.perWeek = payload?.perWeek ?? null;
      state.perMonth = payload?.perMonth ?? null;
      state.nplRelative = payload?.nplRelative ?? null;
      state.units.temp = payload?.tempUnit ?? null;
    }
	},
	actions : {
	},
	getters: {
    currentHydrometry(state) {
      return state.current;
    },
    currentWaterTemperature(state, getters) {
      return getters.findOrFail(state, 'current.temp_local') ?? 
        (getters.findOrFail(state, 'current.temp_ext') ?? null);
    },
    currentWaterLevel(state, getters) {
      return getters.findOrFail(state, 'current.level_headwater_iv') ?? 
        (getters.findOrFail(state, 'current.level_local') ?? 0) / 100;
    },
    currentIceThickness(state, getters) {
      return getters.findOrFail(state, 'current.ice_thickness_local') ?? 
        (getters.findOrFail(state, 'current.ice_thickness_ext') ?? null);
    },
    currentTurbulence(state, getters) {
      return getters.findOrFail(state, 'current.turbulence');
    },
    hydrometryHistory(state) {
      return state.history;
    },
    hydrometryUnit: (state, getters) => (name) => {
      return getters.findOrFail(state.units, name);
    },
    dailyChange: (state, getters) => (parameter) => {
      return getters.findOrFail(state.perDay, parameter);
    },
    weeklyChange: (state, getters) => (parameter) => {
      return getters.findOrFail(state.perWeek, parameter);
    },
    monthlyChange: (state, getters) => (parameter) => {
      return getters.findOrFail(state.perMonth, parameter);
    },
    nplRelative(state) {
      return state.nplRelative;
    },
    hydrometryUpdatedAt(state) {
      return state.updatedAt;
    }
	}
}