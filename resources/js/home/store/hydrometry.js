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
    },
    waterTemperatureHistory(state, getters) {
      let wth = state.history;
      let labels = [];
      let waterTemperatureDataset = [];
      Object.keys(wth).forEach(key => {
        if (!isNaN(key)) {
          let dateTime = getters.findOrFail(wth, key + '.updated_at');
          let value = getters.findOrFail(wth, key + '.temp_local');
          labels.push(moment(dateTime).format("DD.MM HH:mm"));
          waterTemperatureDataset.push(parseFloat(value));
        }
      });
      return {
        'labels':labels,
        'datasets': [
          {
            data: waterTemperatureDataset,
            label: getters.t('Water temperature') + ', ' + getters.t('℃'),  
            borderColor: 'rgb(141, 172, 45)', 
            backgroundColor: 'rgba(141, 172, 45, 0.3)',
            pointRadius: 3,
            spanGaps: true
          }
        ]
      };
    },
    waterLevelHistory(state, getters) {
      let wlh = state.history;
      let labels = [];
      let kimLevelDataset = [];
      let localLevelDataset = [];
      Object.keys(wlh).forEach(key => {
        if (!isNaN(key)) {
          let dateTime = getters.findOrFail(wlh, key + '.created_at');
          let valueIv = getters.findOrFail(wlh, key + '.level_headwater_iv');
          let valueLocal = getters.findOrFail(wlh, key + '.level_local');
          labels.push(moment(dateTime).format("DD.MM HH:mm"));
          kimLevelDataset.push(valueIv);
          localLevelDataset.push(valueLocal);
        }
      });
      return {
        'labels':labels,
        'datasets': [
          {
            data: kimLevelDataset,
            label: getters.t('Waterworks headwater level') + ', ' + getters.t('CM'),  
            borderColor: 'rgb(141, 172, 45)', 
            backgroundColor: 'rgba(141, 172, 45, 0.3)',
            pointRadius: 3,
            spanGaps: true
          },
          {
            data: localLevelDataset,
            label: getters.t('Measured level') + ', ' + getters.t('CM'),  
            borderColor: 'rgba(250, 235, 215, 0.3)', 
            backgroundColor: 'rgba(250, 235, 215, 0.2)',
            pointRadius: 3,
            spanGaps: true
          }
        ]
      };
    },
	}
}