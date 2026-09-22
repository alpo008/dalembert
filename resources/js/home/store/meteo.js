
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
      return state.current;
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
      return this.wxData?.outdoor?.feels_like?.value ?? null;
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
  }
}