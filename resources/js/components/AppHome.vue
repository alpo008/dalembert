<template>
  <v-parallax
    src="./img/bg-gl.jpg"
    class="mt-n10"
  >
    <div class="d-flex flex-column fill-height justify-start align-center text-white mt-10">

      <h4 class="subheading">
      </h4>
    </div>
  </v-parallax>

</template>
<script>
  const isEmpty = obj => [Object, Array].includes((obj || {}).constructor) && !Object.entries((obj || {})).length;
  export default {
    data: function () {
      return {
        wx : {},
        wxItems : [],
        wxItemsKeys : [
          'outdoor.temperature',
          'outdoor.feels_like',
          'outdoor.dew_point',
          'outdoor.humidity',
          'solar_and_uvi.uvi',
          'rainfall.rain_rate',
          'wind.wind_speed',
          'wind.wind_gust',
          'wind.wind_direction',
          'pressure.absolute'
        ]
      }
    },
    async created() {
      let result = await axios('/meteo');
      if (typeof result.data === 'object') {
        this.wx = result.data;
        this.wxItemsKeys.forEach(key => {console.log(this.getLabel(key))});
      }
    },
    methods: {
      getLabel(key) {
        let result = '';
        if (typeof key === 'string') {
          result = key.replace('outdoor.', '')
                      .replace('solar_and_uvi.', '')
                      .replace('rainfall.', '')
                      .replace('wind.', '')
                      .replace('pressure.', '')
                      .replace('_', ' ');
        }
        return result.charAt(0).toUpperCase() + result.slice(1);
      }
    },
    computed: {
      itemsAvailable() {
        let result = [];
        let tempObject = {};
         if (!isEmpty(this.wx.all?.data?.outdoor?.temperature)) {
          tempObject.label = this.$t('Temperature');
          tempObject.value = this.wx.all?.data?.outdoor?.temperature?.value;
          tempObject.unit = this.wx.all?.data?.outdoor?.temperature?.unit;
          result.push(tempObject);
          tempObject = {};
         }
         return result;
      },
    }
  }
</script>
<style scoped>
    .blur {
      backdrop-filter: blur(10px);
    }
</style>