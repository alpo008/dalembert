export default {
	state : {
	    city: '',
	    temperature: null,
	    time: '',
	    weathercode: null,
	    description: '',
	    winddirection: null,
	    windspeed: null,
	    weathertext: '',
	    sunrise: '',
	    sunset: '',
	    icon: '',
	    iconClass: '',
	    is_ready: false,
	},
	mutations: {
		setWeather(state, payload) {
			let wx = payload.weather;
			const weatherCodes = {
		        0:  'Clear sky',
		        1:  'Mainly clear',
		        2:  'Partly cloudy', 
		        3:  'Overcast',
		        45: 'Fog',
		        48: 'Rime fog',
		        51: 'Light drizzle', 
		        53: 'Moderate drizzle', 
		        55: 'Dense drizzle',
		        56: 'Light freezing drizzle', 
		        57: 'Dense freezing drizzle',
		        61: 'Slight rain', 
		        63: 'Moderate rain',  
		        65: 'Heavy rain', 
		        66: 'Light freezing rain', 
		        67: 'Heavy freezing rain',
		        71: 'Slight snow fall', 
		        73: 'Moderate snow fall', 
		        75: 'Heavy snow fall',
		        77: 'Snow grains',
		        80: 'Slight rain showers', 
		        81: 'Moderate rain showers', 
		        82: 'Violent rain showers',
		        85: 'Slight snow showers', 
		        86: 'Heavy snow showers', 
		        95: 'Thunderstorm',
		        96: 'Thunderstorm with sligh hail', 
		        99: 'Thunderstorm with heavy hail'
			};
			const weatherIcons = {
				0:  {'day': 'wi-day-sunny', 'night': 'wi-night-clear'},
				1:  {'day': 'wi-day-cloudy', 'night': 'wi-night-alt-cloudy'},
				2:  {'day': 'wi-day-cloudy', 'night': 'wi-night-alt-cloudy'},
				3:  {'day': 'wi-cloudy', 'night': 'wi-cloudy'},
				45: {'day': 'wi-day-fog', 'night': 'wi-night-fog'},
				48: {'day': 'wi-snowflake-cold', 'night': 'wi-snowflake-cold'},
				51: {'day': 'wi-day-sprinkle', 'night': 'wi-night-sprinkle'}, 
				53: {'day': 'wi-raindrops', 'night': 'wi-raindrops'},
				55: {'day': 'wi-rain', 'night': 'wi-rain'},
				56: {'day': 'wi-snowflake-cold', 'night': 'wi-snowflake-cold'},
				57: {'day': 'wi-day-snow', 'night': 'wi-night-snow'},
				61: {'day': 'wi-day-showers', 'night': 'wi-night-alt-showers'}, 
				63: {'day': 'wi-day-rain', 'night': 'wi-night-alt-rain'},  
				65: {'day': 'wi-rain', 'night': 'wi-rain'}, 
				66: {'day': 'wi-day-rain-mix', 'night': 'wi-night-alt-rain-mix'}, 
				67: {'day': 'wi-rain-mix', 'night': 'wi-rain-mix'},
				71: {'day': 'wi-day-snow', 'night': 'wi-night-alt-snow'}, 
				73: {'day': 'wi-day-snow-wind', 'night': 'wi-night-alt-snow-wind'}, 
				75: {'day': 'wi-snow-wind', 'night': 'wi-snow-wind'},
				77: {'day': 'wi-rain-mix', 'night': 'wi-rain-mix'},
				80: {'day': 'wi-day-showers', 'night': 'wi-night-alt-showers'}, 
				81: {'day': 'wi-showers', 'night': 'wi-showers'}, 
				82: {'day': 'wi-day-rain-wind', 'night': 'wi-night-rain-wind'},
				85: {'day': 'wi-day-snow-wind', 'night': 'wi-night-alt-snow-wind'}, 
				86: {'day': 'wi-day-thunderstormtorm', 'night': 'wi-night-thunderstorm'}, 
				95: {'day': 'wi-day-sleet-storm', 'night': 'wi-night-sleet-storm'}, 
				99: {'day': 'wi-storm-showers', 'night': 'wi-storm-showers'}
			};  
			if(typeof(wx.current_weather) === 'object' && !_.isEmpty(wx.current_weather)) {
				state.temperature = wx.current_weather.temperature;
				state.windspeed = wx.current_weather.windspeed;
				state.winddirection = wx.current_weather.winddirection;
				state.weathercode = wx.current_weather.weathercode;
				state.time = wx.current_weather.time;
				state.description = weatherCodes[wx.current_weather.weathercode];
				state.icon = weatherIcons[wx.current_weather.weathercode];
				state.city = wx.city;
			}
			if(typeof(wx.daily) === 'object' && !_.isEmpty(wx.daily)) {
				if(typeof(wx.daily.sunrise) === 'object' && typeof(wx.daily.sunrise[0]) === 'string') {
					state.sunrise = wx.daily.sunrise[0];
				}
				if(typeof(wx.daily.sunset) === 'object' && typeof(wx.daily.sunset[0]) === 'string') {
					state.sunset = wx.daily.sunset[0];
				}
			}

			if(typeof(state.sunrise) === 'string' && typeof(state.sunset) === 'string') {
				let dayTime = true;
				let sunrise = new Date(state.sunrise);
				let sunset = new Date(state.sunset);
				let now = new Date();
				dayTime = (now > sunrise) && (now < sunset);
				let key, iconClass;
				key = dayTime ? 'day' : 'night';
				iconClass = weatherIcons[state.weathercode][key];
				state.iconClass = 'wi ' + iconClass;

				state.is_ready = true;
			}
		}
	},
	actions: {
		async updateWeather(context, payload) {
			let currentPosition = await context.dispatch('getCoords', 0);
			let timeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;
        	return context.dispatch('httpRequest', {
              url: '/home',
              method: 'POST',
              data: {
				'lat': currentPosition.coords.latitude, 
				'lng': currentPosition.coords.longitude,
				'timezone': timeZone 
				},
              mutation: 'setWeather'
            });
/*			let response = await axios.post('/home', {
				'lat': currentPosition.coords.latitude, 
				'lng': currentPosition.coords.longitude,
				'timezone': timeZone 
			});
			context.commit('setWeather', response.data.weather);*/
		},
		async getCoords() {
			return new Promise((resolve, reject) => {
				navigator.geolocation.getCurrentPosition(resolve, reject);
			});
		}
	},
	getters: {
		weather(state) {
			return state;
		}
	}	
}