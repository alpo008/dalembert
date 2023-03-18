<template>
  <v-card>
    <v-layout>
      <!-- <v-system-bar color="deep-purple darken-3"></v-system-bar> -->

      <v-app-bar
        color="primary"
        prominent
      >
        <v-app-bar-nav-icon variant="text" @click.stop="drawer = !drawer"></v-app-bar-nav-icon>

        <v-toolbar-title v-if="weather.is_ready" class="ticker">
          <p>
            {{ weather.city }} &nbsp;
            <i :class="weatherIconClass"></i>
            {{ weather.description }}, 
            {{ weather.temperature }} &#176;C,
            <i class="wi wi-windy wi-rotate-45"></i> {{ windRumb  }} {{ weather.windspeed }} m/s,
          </p>
        </v-toolbar-title>

        <v-spacer></v-spacer>

        <v-btn variant="text" icon="mdi-magnify"></v-btn>

        <v-btn variant="text" icon="mdi-filter"></v-btn>

        <v-btn variant="text" icon="mdi-dots-vertical"></v-btn>
      </v-app-bar>

      <v-navigation-drawer
        v-model="drawer"
        location="start"
        temporary
      >
        <v-list
          :items="items"
        ></v-list>
      </v-navigation-drawer>

      <v-main style="height: 100vh;">
        <v-card-text>
          <router-view></router-view>
        </v-card-text>
      </v-main>
    </v-layout>
  </v-card>  
</template>

<script>
export default {
  data: function () {
    return {
      drawer: false,
      group: null,
      items: [
        {
          title: 'Foo',
          value: 'foo',
        },
        {
          title: 'Bar',
          value: 'bar',
        },
        {
          title: 'Fizz',
          value: 'fizz',
        },
        {
          title: 'Buzz',
          value: 'buzz',
        }
      ],
      locationName: null,
      weather: {
        city: '',
        temperature: null,
        time: null,
        weathercode: null,
        description: '',
        winddirection: null,
        windspeed: null,
        weathertext: '',
        sunrise: '',
        sunset: '',
        is_ready: false
      },
      weathercodes: {
        0: 'Clear sky',
        1: 'Mainly clear',
        2: 'Partly cloudy', 
        3: 'Overcast',
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
      },
      weathericons: {
        0: {'day': 'wi-day-sunny', 'night': 'wi-night-clear'},
        1: {'day': 'wi-day-cloudy', 'night': 'wi-night-alt-cloudy'},
        2: {'day': 'wi-day-cloudy', 'night': 'wi-night-alt-cloudy'},
        3: {'day': 'wi-cloudy', 'night': 'wi-cloudy'},
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
      }
    }
  },
  mounted() {

    this.getLocation();

    axios.get('/home')
      .then(response => {
        let result = response.data;
        if(typeof(result === 'object') && !_.isEmpty(result)) {
          if(typeof(result.weather === 'object') && !_.isEmpty(result.weather)) {
            this.weather.city = result.weather.city;
            if(typeof(result.weather.current_weather) === 'object' && !_.isEmpty(result.weather.current_weather)) {
              this.weather.temperature = result.weather.current_weather.temperature;
              this.weather.windspeed = result.weather.current_weather.windspeed;
              this.weather.winddirection = result.weather.current_weather.winddirection;
              this.weather.weathercode = result.weather.current_weather.weathercode;
              this.weather.time = result.weather.current_weather.time;
              this.weather.description = this.$t(this.weathercodes[this.weather.weathercode]);
            }
            let daily = result.weather.daily;
            if(typeof(daily) === 'object' && !_.isEmpty(daily)) {
              if(typeof(daily.sunrise) === 'object' && typeof(daily.sunrise[0]) === 'string') {
                this.weather.sunrise = result.weather.daily.sunrise[0];
              }
              if(typeof(daily.sunset) === 'object' && typeof(daily.sunset[0]) === 'string') {
                this.weather.sunset = result.weather.daily.sunset[0];
              }
            }
            this.weather.is_ready = true;
          }
        }
    });
  },
  methods: {
    getLocation() {
      let location;
      navigator.geolocation.getCurrentPosition(
        pos => {
          location = pos.coords;
          let param = JSON.stringify(location)
          axios.get('/home/' + param)
          .then(function (response) {
            console.log(response);
          })
          .catch(function (error) {
            console.log(error);
          })
          .finally(function () {
            // always executed
          });
        }, 
        err => {
            location = {
            lattitude: 55.75231282700813, 
            longitude:37.61737361013978,
            accuracy: null,
            altitude: null,
            altitudeAccuracy: null,
            heading: null,
            speed: null,
            city: 'Moscow'
          };
          console.warn(`ERROR(${err.code}): ${err.message}`);
        }, 
        { 
          enableHighAccuracy: true,
          timeout: 5000,
          maximumAge: 0,
        }
      ); 
    }
  },
  computed: {
    dayTime() {
      let result = true;
      if(typeof(this.weather.sunrise) === 'string' && typeof(this.weather.sunset) === 'string') {
        let sunrise = new Date(this.weather.sunrise);
        let sunset = new Date(this.weather.sunset);
        let now = new Date();
        result = (now > sunrise) && (now < sunset);
      }
      return result;  
    },
    weatherIconClass() {
      let key, iconClass;
      key = this.dayTime ? 'day' : 'night';
      iconClass = this.weathericons[this.weather.weathercode][key];
      return 'wi ' + iconClass;
    },
    windRumb() {
      let result = '';
      let dir = this.weather.winddirection;
      if (!isNaN(dir)) {
        if ((dir > 354.375 || dir > 0) && dir <= 5.625) {
          result = 'N';
        }
        if (dir > 5.625 && dir <= 16.875) {
          result = 'NtE';
        }
        if (dir > 16.875 && dir <= 28.125) {
          result = 'NNE';
        }
        if (dir > 28.125 && dir <= 39.375) {
          result = 'NEtN';
        }
        if (dir > 39.375 && dir <= 50.625) {
          result = 'NE';
        }
        if (dir > 50.625 && dir <= 61.875) {
          result = 'NEtE';
        }
        if (dir > 61.875 && dir <= 73.125) {
          result = 'ENE';
        }
        if (dir > 73.125 && dir <= 84.375) {
          result = 'EtN';
        }
        if (dir > 84.375 && dir <= 95.625) {
          result = 'E';
        }
        if (dir > 95.625 && dir <= 106.875) {
          result = 'EtS';
        }
        if (dir > 106.875 && dir <= 118.125) {
          result = 'ESE';
        }
        if (dir > 118.125 && dir <= 129.375) {
          result = 'SEtE';
        }
        if (dir > 129.375 && dir <= 140.625) {
          result = 'SE';
        }
        if (dir > 140.625 && dir <= 151.875) {
          result = 'SEtS';
        }
        if (dir > 151.875 && dir <= 163.125) {
          result = 'SSE';
        }
        if (dir > 163.125 && dir <= 174.375) {
          result = 'StE';
        }
        if (dir > 174.375 && dir <= 185.625) {
          result = 'S';
        }
        if (dir > 185.625 && dir <= 196.875) {
          result = 'StW';
        }
        if (dir > 196.875 && dir <= 208.125) {
          result = 'SSW';
        }
        if (dir > 208.125 && dir <= 219.375) {
          result = 'SWtS';
        }
        if (dir > 219.375 && dir <= 230.625) {
          result = 'SW';
        }
        if (dir > 230.625 && dir <= 241.875) {
          result = 'SWtW';
        }
        if (dir > 241.875 && dir <= 253.125) {
          result = 'WSW';
        }
        if (dir > 253.125 && dir <= 264.375) {
          result = 'WtS';
        }
        if (dir > 264.375 && dir <= 275.625) {
          result = 'W';
        }
        if (dir > 275.625 && dir <= 286.875) {
          result = 'WtN';
        }
        if (dir > 286.875 && dir <= 298.125) {
          result = 'WNW';
        }
        if (dir > 298.125 && dir <= 309.375) {
          result = 'NWtW';
        }
        if (dir > 309.375 && dir <= 320.625) {
          result = 'NW';
        }
        if (dir > 320.625 && dir <= 331.875) {
          result = 'NWtN';
        }
        if (dir > 331.875 && dir <= 343.125) {
          result = 'NNW';
        }
        if (dir > 343.125 && dir <= 354.375) {
          result = 'NtW';
        }
      }
      return result;
    }
  }
}
</script>