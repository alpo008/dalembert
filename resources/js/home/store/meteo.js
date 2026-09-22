import moment from "moment/dist/moment";
export default {
	state : {
    current: null,
    history: null,
    ticker: null,
    updatedAt: null,
	},
	mutations : {
    setWeatherTicker(state, payload) {
      state.ticker = payload.description;
    },
    setWeatherData(state, payload) {
      state.current = this.getters.findOrFail(payload, 'all.data');
      state.history = this.getters.findOrFail(payload, 'history.data');
      state.updatedAt = Date.now();
    }
	},
	actions : {
	},
	getters: {
    weatherTicker(state) {
      return state.ticker;
    },
    currentWeather(state) {
      return state.current;
    },
    weatherHistory(state) {
      return state.history;
    },
    weatherUpdatedAt(state) {
      return state.updatedAt;
    },
    temperatureOut(state, getters) {
      return getters.findOrFail(state, 'current.outdoor.temperature.value') ?? null;
    },
    temperatureUnit(state, getters) {
      return getters.temperatureOut !== null ? 
        getters.findOrFail(state, 'current.outdoor.temperature.unit') : 
        '';
    },
    feelsLike(state, getters) {
      return getters.findOrFail(state, 'current.outdoor.feels_like.value') ?? null ;
    },
    feelsLikeUnit(state, getters) {
      return getters.feelsLike !== null ? 
        getters.findOrFail(state, 'current.outdoor.feels_like.unit') : 
        '';
    },
    humidity(state, getters) {
      return getters.findOrFail(state, 'current.outdoor.humidity.value') ?? null;
    },
    humidityUnit(state, getters) {
      return getters.humidity !== null ? 
        getters.findOrFail(state, 'current.outdoor.humidity.unit') : 
        '';
    },
    dewPoint(state, getters) {
      return getters.findOrFail(state, 'current.outdoor.dew_point.value') ?? null;
    },
    dewPointUnit(state, getters) {
      return getters.dewPoint !== null ? 
        getters.findOrFail(state, 'current.outdoor.dew_point.unit') : 
        '';
    },
    pressureAbs(state, getters) {
      return getters.findOrFail(state, 'current.pressure.absolute.value') ?? null;
    },
    pressureRel(state, getters) {
      return getters.findOrFail(state, 'current.pressure.relative.value') ?? null;
    },
    pressureUnit(state, getters) {
      return getters.pressureAbs !== null ? 
        getters.findOrFail(state, 'current.pressure.absolute.unit') : 
        '';
    },
    solar(state, getters) {
      return getters.findOrFail(state, 'current.solar_and_uvi.solar.value') ?? null;
    },
    solarUnit(state, getters) {
      return getters.solar !== null ? 
        getters.findOrFail(state, 'current.solar_and_uvi.solar.unit') : 
        '';
    },
    solarRounded(state, getters) {
      let result = {
        value: getters.solar,
        unit: getters.solarUnit
      };
      if (getters.solar > 5000) {
        result.value = (Math.round(getters.solar / 100) / 10),
        result.unit = 'K' + getters.solarUnit;
      }
      return result;
    },
    uvi(state, getters) {
      return getters.findOrFail(state, 'current.solar_and_uvi.uvi.value') ?? null;
    },
    uviUnit(state, getters) {
      return getters.uvi !== null ? 
        getters.findOrFail(state, 'current.solar_and_uvi.uvi.unit') : 
        '';
    },
    windDirection(state, getters) {
      return getters.findOrFail(state, 'current.wind.wind_direction.value') ?? null;
    },
    windGust(state, getters) {
      return getters.findOrFail(state, 'current.wind.wind_gust.value') ?? null;
    },
    windSpeed(state, getters) {
      return getters.findOrFail(state, 'current.wind.wind_speed.value') ?? null;
    },
    windDirectionUnit(state, getters) {
      return getters.windDirection !== null ? 
        getters.findOrFail(state, 'current.wind.wind_direction.unit') : 
        '';
    },
    windSpeedUnit(state, getters) {
      return getters.windDirection !== null ? 
        getters.findOrFail(state, 'current.wind.wind_speed.unit') : 
        '';
    },
    windArrowStyle(state, getters) {
      if (Boolean(getters.windSpeed * 1) || Boolean(getters.windGust * 1)) {
        return 'transform:rotate(' + getters.windDirection + 'deg)';
      }
      return null;
    },
    windRumb(state, getters) {
      if (isNaN(getters.windDirection)) {
        return "";
      }
      let rumb = (getters.windDirection / 1) + 11.25;
      if (rumb > 360) {
        rumb = rumb - 360;
      }
      let rumbs = {
        0 :'N', 
        1 : 'NNE', 
        2 : 'NE', 
        3 : 'ENE', 
        4 : 'E', 
        5 : 'ESE', 
        6 : 'SE', 
        7 : 'SSE', 
        8 : 'S', 
        9 : 'SSW', 
        10 : 'SW', 
        11 : 'WSW', 
        12 : 'W', 
        13 : 'WNW', 
        14 : 'NW', 
        15 : 'NNW'
      };
      return rumbs[Math.floor(rumb / 22.5)];
    },
    rainHour(state, getters) {
      return getters.findOrFail(state, 'current.rainfall')['1_hour']?.value ?? null;
    },
    rainDay(state, getters) {
      return getters.findOrFail(state, 'current.rainfall.daily.value') ?? null;
    },
    rainEvent(state, getters) {
      return getters.findOrFail(state, 'current.rainfall.event.value') ?? null;
    },
    rainWeek(state, getters) {
      return getters.findOrFail(state, 'current.rainfall.weekly.value') ?? null;
    },
    rainMonth(state, getters) {
      return getters.findOrFail(state, 'current.rainfall.monthly.value') ?? null;
    },
    rainYear(state, getters) {
      return getters.findOrFail(state, 'current.rainfall.yearly.value') ?? null;
    },
    rainUnit(state, getters) {
      return getters.findOrFail(state, 'current.rainfall.daily.unit') ?? '';
    },
    temperatureHistory(state, getters) {
      let temperatureHistory = getters.findOrFail(getters.weatherHistory, 'outdoor.temperature.list');
      let labels = [];
      let temperatureDataset = [];
      Object.keys(temperatureHistory).forEach(key => {
        if (!isNaN(key)) {
          labels.push(moment.unix(key).format("DD.MM HH:mm"));
          temperatureDataset.push(parseFloat(temperatureHistory[key]));
        }
      });
      return {
        'labels':labels,
        'datasets': [
          {
            data:temperatureDataset,
            label: getters.t('Temperature') + ', ' + getters.t('℃'),  
            borderColor: 'rgb(141, 172, 45)', 
            backgroundColor: 'rgba(141, 172, 45, 0.3)',
            pointRadius: 3
          }
        ]
      };
    },
    humidityHistory(state, getters) {
      let humidityHistory = getters.findOrFail(getters.weatherHistory, 'outdoor.humidity.list');
      let labels = [];
      let humidityDataset = [];
      Object.keys(humidityHistory).forEach(key => {
        if (!isNaN(key)) {
          labels.push(moment.unix(key).format("DD.MM HH:mm"));
          humidityDataset.push(parseFloat(humidityHistory[key]));
        }
      });
      return {
        'labels':labels,
        'datasets': [
          {
            data:humidityDataset,
            label: getters.t('Humidity')  + ', ' + getters.t('%'), 
            borderColor: 'rgb(141, 172, 45)', 
            backgroundColor: 'rgba(141, 172, 45, 0.3)',
            pointRadius: 3
          }
        ]
      };
    },
    pressureHistory(state, getters) {
      let pressureHistory = getters.findOrFail(getters.weatherHistory, 'pressure.absolute.list');
      let labels = [];
      let pressureDataset = [];
      Object.keys(pressureHistory).forEach(key => {
        if (!isNaN(key)) {
          labels.push(moment.unix(key).format("DD.MM HH:mm"));
          pressureDataset.push(parseFloat(pressureHistory[key]));
        }
      });
      return {
        'labels':labels,
        'datasets': [
          {
            data:pressureDataset,
            label: getters.t('Pressure') + ', ' + getters.t('mmHg'), 
            borderColor: 'rgb(141, 172, 45)', 
            backgroundColor: 'rgba(141, 172, 45, 0.3)',
            pointRadius: 3
          }
        ]
      };
    },
    windHistory(state, getters) {
      let windHistory = getters.findOrFail(getters.weatherHistory, 'wind.wind_speed.list');
      let labels = [];
      let windDataset = [];
      Object.keys(windHistory).forEach(key => {
        if (!isNaN(key)) {
          labels.push(moment.unix(key).format("DD.MM HH:mm"));
          windDataset.push(parseFloat(windHistory[key]));
        }
      });
      return {
        'labels':labels,
        'datasets': [
          {
            data:windDataset,
            label: getters.t('Wind') + ', ' + getters.t('m/s'), 
            borderColor: 'rgb(141, 172, 45)', 
            backgroundColor: 'rgba(141, 172, 45, 0.3)',
            pointRadius: 3
          }
        ]
      };
    },
    rainfallHistory(state, getters) {
      let rainfallHistory = getters.findOrFail(getters.weatherHistory, 'rainfall.event.list');
      let labels = [];
      let rainfallDataset = [];
      Object.keys(rainfallHistory).forEach(key => {
        if (!isNaN(key)) {
          labels.push(moment.unix(key).format("DD.MM HH:mm"));
          rainfallDataset.push(parseFloat(rainfallHistory[key]));
        }
      });
      return {
        'labels':labels,
        'datasets': [
          {
            data:rainfallDataset,
            label: getters.t('Rain') + ', ' + getters.t('mm'),  
            borderColor: 'rgb(141, 172, 45)', 
            backgroundColor: 'rgba(141, 172, 45, 0.3)',
            pointRadius: 3
          }
        ]
      };
    },
    solarHistory(state, getters) {
      let solarHistory = getters.findOrFail(getters.weatherHistory, 'solar_and_uvi.solar.list');
      let labels = [];
      let solarDataset = [];
      Object.keys(solarHistory).forEach(key => {
        if (!isNaN(key)) {
          if (moment.unix(key).hour() === 15) {
            labels.push(moment.unix(key).format("DD.MM"));
            solarDataset.push(parseFloat(solarHistory[key]));
          }
        }
      });
      return {
        'labels':labels,
        'datasets': [
          {
            data:solarDataset,
            label: getters.t('Illumination') + ', ' + getters.t('lx'), 
            borderColor: 'rgb(141, 172, 45)', 
            backgroundColor: 'rgba(141, 172, 45, 0.3)',
            pointRadius: 3
          }
        ]
      };
    }
  }
}