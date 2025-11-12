<template>
<!--  <div>
     <v-img
      style="height:82vh;top:-20px;"
      aspect-ratio="16/9"
      cover
      src="./img/bg-energy.jpg"
    ></v-img>
  </div> -->

  <v-parallax
    src="./img/bg-energy.jpg"
    class="mt-n10"
  >
    <div class="d-flex flex-column fill-height justify-start align-center text-white mt-10">
      <h1 class="text-h4 font-weight-thin mb-4">
        Vuetify
      </h1>
      <h4 class="subheading">
        <v-list class="text-h5 bg-transparent">
            <v-list-item
              v-for="(item, i) in itemsAvailable"
              :key="i"
            >
              {{ item.label }}  {{ item.value }}  {{ item.unit }}
            </v-list-item>
        </v-list>
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