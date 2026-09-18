<template>
<p>{{ updated_at }}</p>
</template>
<script>
  const WEATHER_UPDATES_INTERVAL = 150000;  //TODO 5 minutes
  export default {
    data: function () {
      return {
        timer: ''
      }
    },
    async created() {
      await this.$store.dispatch('httpRequest', {
        url: '/meteo',
        method: 'GET',
        data: null,
        mutation: 'setWeatherData'
      });
    },
    mounted() {
      this.updateWeather();
      this.timer = setInterval(this.updateWeather, 30000);
    },
    beforeDestroy() {
      clearInterval(this.timer);
    },
    methods: {
      async updateWeather() {
        if (Date.now() - this.$store.getters.weatherUpdatedAt > WEATHER_UPDATES_INTERVAL) {
          await this.$store.dispatch('httpRequest', {
            url: '/meteo',
            method: 'GET',
            data: null,
            mutation: 'setWeatherData'
          });
        }
      }
    },
    computed: {
      updated_at () {
        return new Date(this.$store.getters.weatherUpdatedAt).toLocaleTimeString(
          this.$store.getters.currentLocale, {
          hour: '2-digit',
          minute: '2-digit',
          hour12: false
        });
      }
    }
  }
</script>
<style scoped>
    .blur {
      backdrop-filter: blur(10px);
    }
</style>