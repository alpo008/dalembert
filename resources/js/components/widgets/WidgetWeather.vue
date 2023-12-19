<template>
  <v-toolbar-title v-if="weather.is_ready" class="ticker">
    <p>
      {{ weather.city }} &nbsp;
      <i :class="weather.iconClass"></i>
      {{ $t(weather.description) }}, 
      {{ weather.temperature }} &#176;C,
      <i class="wi wi-windy wi-rotate-45"></i> 
      &nbsp; <i class="wi wi-wind-direction" id="wind-arrow" :style="windArrowStyle"></i>
      &nbsp; {{ windRumb  }} {{ weather.windspeed }} m/s,
    </p>
  </v-toolbar-title>
</template>

<script>
export default {
  data() {
    return {
      weather: {
        is_ready: false,
      },
      windArrowStyle: 'transform:rotate(180deg);'
    }
  },
  created() {
    this.weather = this.$store.getters.weather;
  },
   methods: { 
  },
  computed: {
    windRumb() {
      let result = '';
      let dir = this.weather.winddirection;
      if (!isNaN(dir)) {
        this.windArrowStyle = 'transform:rotate(90' + (180 + dir) + 'deg);'
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