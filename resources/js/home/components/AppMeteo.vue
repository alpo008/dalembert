<template>
  {{ $store.getters.t('Updated at') }} {{ updated_at }}
  <div class="wrapper_meteo" v-if="!!$store.getters.currentWeather && !chartMode">
    <div class="params_block_wrapper">
      <div class="params_block">
        <div class="temp-box">
          <div class="link-icon-left chart-link" 
            @click="showChart('temperature')" 
            :title="$store.getters.t('Show chart')"
          >
          </div>
          <div class="text-small text-white-blue text-bolder">
            {{ $store.getters.t('Temperature') }}
          </div>
          <div class="wx_parameter">
            {{ $store.getters.temperatureOut }} 
            <span class="text-unit">
              {{ $store.getters.t($store.getters.temperatureUnit) }}
            </span>
          </div>
          <div class="text-small">
            {{ $store.getters.t('Feels like') }}
            <span class="text-green">
              {{ $store.getters.feelsLike }} {{ $store.getters.t($store.getters.feelsLikeUnit) }}
            </span>
          </div>
        </div>
        <div class="temp-box">
          <div class="link-icon-right chart-link" 
            @click="showChart('humidity')" 
            :title="$store.getters.t('Show chart')"
          >
          </div>
          <div class="text-small text-white-blue text-bolder">
            {{ $store.getters.t('Humidity') }}
          </div>
          <div class="wx_parameter">
            {{ $store.getters.humidity }} 
            <span class="text-unit">
              {{ $store.getters.t($store.getters.humidityUnit) }}
            </span>
          </div>
          <div class="text-small">
            {{ $store.getters.t('Dew point') }}
            <span class="text-green">
              {{ $store.getters.dewPoint }} {{ $store.getters.t($store.getters.dewPointUnit) }}
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="params_block_wrapper">
      <div class="link-icon-left chart-link pt-l-4" 
        @click="showChart('pressure')" 
        :title="$store.getters.t('Show chart')"
      >
    </div>
      <div class="text-small text-white-blue text-bolder">
        {{ $store.getters.t('Pressure') }} 
      </div>
      <div class="params_block">
        <div class="temp-box">
          <div class="text-small">
            {{ $store.getters.t('Absolute') }}
          </div>
          <div class="wx_parameter">
            {{ $store.getters.pressureAbs }}
            <span class="text-unit">
              {{ $store.getters.t($store.getters.pressureUnit) }}
            </span>
          </div>
        </div>
        <div class="temp-box">
          <div class="text-small">
            {{ $store.getters.t('Relative') }}
          </div>
          <div class="wx_parameter">
            {{ $store.getters.pressureRel }}
            <span class="text-unit">
              {{ $store.getters.t($store.getters.pressureUnit) }}
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="params_block_wrapper">
      <div class="link-icon-left chart-link pt-l-4" 
        @click="showChart('solar')" 
        :title="$store.getters.t('Show chart')"
      >
      </div>
      <div class="text-small text-white-blue text-bolder">
        {{ $store.getters.t('Solar and UVI') }}
      </div>
      <div class="params_block">
        <div class="temp-box">
          <div class="text-small">
            {{ $store.getters.t('Illumination') }}
          </div>
          <div class="wx_parameter">
            {{ $store.getters.solarRounded.value }}
            <span class="text-unit">
              {{ $store.getters.t($store.getters.solarRounded.unit) }}
            </span>
          </div>
        </div>
        <div class="temp-box">
          <div class="text-small">
            {{ $store.getters.t('UVI') }}
          </div>
          <div class="wx_parameter">
            {{ $store.getters.uvi }}
            <span class="text-unit">
              {{ $store.getters.t($store.getters.uviUnit) }}
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="params_block_wrapper">
        <div class="link-icon-left chart-link pt-l-4" 
          @click="showChart('wind')" 
          :title="$store.getters.t('Show chart')"
        >
        </div>
      <div class="text-small text-white-blue text-bolder">
        {{ $store.getters.t('Wind') }}
      </div>
      <div class="params_block">
        <div class="temp-box">
          <div class="text-small">
            {{ $store.getters.t('Speed') }}
          </div>
          <div class="wx_parameter">
            {{ $store.getters.windSpeed }}
            <span class="text-unit">
              {{ $store.getters.t($store.getters.windSpeedUnit) }}
            </span>
          </div>
        </div>
        <div class="temp-box height130" v-if="!!$store.getters.windArrowStyle">
          <div class="wind-arrow" :style="$store.getters.windArrowStyle"></div>
          <div class="wx_parameter" style="position:relative;top:-100px;">
            {{ $store.getters.windDirection }}
            <span class="text-unit">
              {{ $store.getters.t($store.getters.windDirectionUnit) }}
            </span>
            <p class="wind-rumb">{{ $store.getters.windRumb }}</p>
          </div>
        </div>
        <div class="temp-box">
          <div class="text-small">
            {{ $store.getters.t('Gust') }}
          </div>
          <div class="wx_parameter">
            {{ $store.getters.windGust }}
            <span class="text-unit">
              {{ $store.getters.t($store.getters.windSpeedUnit) }}
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="params_block_wrapper">
      <div class="link-icon-left chart-link pt-l-4" 
        @click="showChart('rainfall')" 
        :title="$store.getters.t('Show chart')"
      >
      </div>
      <div class="text-small text-white-blue text-bolder">
        {{ $store.getters.t('Rain') }}
      </div>
      <div class="params_block">
        <div class="temp-box">
          <div class="text-small">
            {{ $store.getters.t('Per hour') }}
          </div>
          <div class="wx_parameter">
            {{ $store.getters.rainHour }} 
            <span class="text-unit">
              {{ $store.getters.t($store.getters.rainUnit) }}
            </span>
          </div>
          <div class="text-small">
            {{ $store.getters.t('Per day') }}
          </div>
          <div class="wx_parameter">
            {{ $store.getters.rainDay }} 
            <span class="text-unit">
              {{ $store.getters.t($store.getters.rainUnit) }}
            </span>
          </div>
        </div>
        <div class="temp-box align-center">
          <div class="text-small space-between" style="height:2em;">
            {{ $store.getters.t('Weekly') }} <span class="text-green">
              {{ $store.getters.rainWeek }} {{ $store.getters.t($store.getters.rainUnit) }}
            </span>
          </div>
          <div class="text-small space-between" style="height:2em;">
            {{ $store.getters.t('Monthly') }} <span class="text-green">
              {{ $store.getters.rainMonth }} {{ $store.getters.t($store.getters.rainUnit) }}
            </span>
          </div>
          <div class="text-small space-between" style="height:2em;">
            {{ $store.getters.t('Yearly') }} <span class="text-green">
              {{ $store.getters.rainYear }} {{ $store.getters.t($store.getters.rainUnit) }}
            </span>
          </div>
        </div>
      </div>
    </div>

    <div class="params_block_wrapper" v-if="showHydrometry">
      <div class="text-small text-white-blue text-bolder">
        {{ $store.getters.t('Water') }} 
      </div>
      <div class="params_block">
        <div class="temp-box" v-if="$store.getters.currentWaterTemperature !== null">
          <div class="link-icon-left chart-link pt-l-4"
            style="top:-25px; left: 0;" 
            @click="showChart('water_temperature')" 
            :title="$store.getters.t('Show chart')"
          >
          </div>
          <div class="text-small">
            {{ $store.getters.t('Temperature') }}
          </div>
          <div class="wx_parameter">
            {{ $store.getters.currentWaterTemperature }}
            <span class="text-unit">
              {{ $store.getters.t($store.getters.hydrometryUnit('temp')) }}
            </span>
          </div>
          <div class="text-small" v-if="$store.getters.dailyChange('temp') !== null">
            {{ $store.getters.t('Per day') }}
            <span class="text-green">
              {{ signVal($store.getters.dailyChange('temp')) }} {{ $store.getters.t($store.getters.hydrometryUnit('temp')) }}
            </span>
          </div>
          <div class="text-small" v-if="$store.getters.weeklyChange('temp') !== null">
            {{ $store.getters.t('Per week') }}
            <span class="text-green">
              {{ signVal($store.getters.weeklyChange('temp')) }} {{ $store.getters.t($store.getters.hydrometryUnit('temp')) }}
            </span>
          </div>
          <div class="text-small" v-if="$store.getters.monthlyChange('temp') !== null">
            {{ $store.getters.t('Per month') }}
            <span class="text-green">
              {{ signVal($store.getters.monthlyChange('temp')) }} {{ $store.getters.t($store.getters.hydrometryUnit('temp')) }}
            </span>
          </div>
        </div>

        <div class="temp-box" v-else>
          <div class="link-icon-left chart-link pt-l-4" 
            style="top:-25px; left:0;" 
            @click="showChart('ice_thickness')" 
            :title="$store.getters.t('Show chart')"
          >
          </div>
          <div class="text-small">
            {{ $store.getters.t('Ice thickness') }}
          </div>
          <div class="wx_parameter">
            {{ $store.getters.currentIceThickness }}
            <span class="text-unit">
              {{ $store.getters.t($store.getters.hydrometryUnit('ice_thickness')) }}
            </span>
          </div>
          <div class="text-small" v-if="$store.getters.dailyChange('ice_thickness') !== null">
            {{ $store.getters.t('Per day') }}
            <span class="text-green">
              {{ signVal($store.getters.dailyChange('ice_thickness')) }} {{ $store.getters.t($store.getters.hydrometryUnit('ice_thickness')) }}
            </span>
          </div>
          <div class="text-small" v-if="$store.getters.weeklyChange('ice_thickness') !== null">
            {{ $store.getters.t('Per week') }}
            <span class="text-green">
              {{ signVal($store.getters.weeklyChange('ice_thickness')) }} {{ $store.getters.t($store.getters.hydrometryUnit('ice_thickness')) }}
            </span>
          </div>
          <div class="text-small" v-if="$store.getters.monthlyChange('ice_thickness') !== null">
            {{ $store.getters.t('Per month') }}
            <span class="text-green">
              {{ signVal($store.getters.monthlyChange('ice_thickness')) }} 
              {{ $store.getters.t($store.getters.hydrometryUnit('ice_thickness')) }}
            </span>
          </div>
        </div>
        <div class="temp-box">
          <div class="link-icon-right chart-link pt-l-4"
            style="top:-25px;"  
            @click="showChart('water_level')" 
            :title="$store.getters.t('Show chart')"
          >
          </div>
          <div class="text-small">
            {{ $store.getters.t('Level') }}
          </div>
          <div class="wx_parameter">
            {{ signVal($store.getters.nplRelative) }}
            <span class="text-unit">
              {{ $store.getters.t($store.getters.hydrometryUnit('level')) }}
            </span>
          </div>
          <div class="text-small" v-if="$store.getters.dailyChange('level') !== null">
            {{ $store.getters.t('Abs headwater') }}
            <span class="text-green">
              {{ $store.getters.t($store.getters.currentWaterLevel) }}
              {{ $store.getters.t($store.getters.hydrometryUnit('level')) }}
            </span>
          </div>
          <div class="text-small" v-if="$store.getters.dailyChange('level') !== null">
            {{ $store.getters.t('Per day') }}
            <span class="text-green">
              {{ signVal($store.getters.dailyChange('level')) }} {{ $store.getters.t($store.getters.hydrometryUnit('level')) }}
            </span>
          </div>
          <div class="text-small" v-if="$store.getters.weeklyChange('level') !== null">
            {{ $store.getters.t('Per week') }}
            <span class="text-green">
              {{ signVal($store.getters.weeklyChange('level')) }} {{ $store.getters.t($store.getters.hydrometryUnit('level')) }}
            </span>
          </div>
          <div class="text-small" v-if="$store.getters.monthlyChange('level') !== null">
            {{ $store.getters.t('Per month') }}
            <span class="text-green">
              {{ signVal($store.getters.monthlyChange('level')) }} {{ $store.getters.t($store.getters.hydrometryUnit('level')) }}
            </span>
          </div>
        </div>
      </div>
      <div class="text-small text-white-blue text-bolder">
        {{ $store.getters.t('Updated') }} : {{ $store.getters.hydrometryUpdatedAt }}
      </div>
    </div>
  </div>

  <div class="wrapper" v-if="chartMode">
    <div class="params_block">
      <div class="close-button-right" @click="showChart(null)" :title="$store.getters.t('Close')">
          <!-- &#65794; --> {{ $store.getters.t('Close') }}
      </div>
      <LineChart :history="historyDataset" style="" />
    </div>
  </div>

</template>
<script>
  const WEATHER_UPDATES_INTERVAL = 150000;  //TODO 5 minutes
  import LineChart from "./LineChart.vue"
  export default {
    name: "GlobusMeteo",
    components: { LineChart },
    data: function () {
      return {
        timer: '',
        chartMode: false,
        historyDataset: null,
      }
    },
    async created() {
/*      await this.$store.dispatch('httpRequest', {
        url: '/meteo',
        method: 'GET',
        data: null,
        mutation: 'setWeatherData'
      });*/
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
      },
      showChart(param) {
        if (param === null) {
          this.chartMode = false;
        } else {
          switch (param) {
            case 'temperature' :
              this.historyDataset = this.$store.getters.temperatureHistory;
              break;
            case "humidity":
              this.historyDataset = this.$store.getters.humidityHistory;
              break;
            case "pressure":
              this.historyDataset = this.$store.getters.pressureHistory;
              break;
            case "solar":
              this.historyDataset = this.$store.getters.solarHistory;
              break;
            case "wind":
              this.historyDataset = this.$store.getters.windHistory;
              break;
            case "rainfall":
              this.historyDataset = this.$store.getters.rainfallHistory;
              break;
            case "water_temperature":
              this.historyDataset = this.$store.getters.waterTemperatureHistory;
              break;
            case "water_level":
              this.historyDataset = this.$store.getters.waterLevelHistory;
              break;
            case "ice_thickness":
              this.historyDataset = this.$store.getters.iceThicknessHistory;
              break;
            default:
              this.historyDataset = this.$store.getters.temperatureHistory;
          }
          this.chartMode = true;
        }
      },
      signVal(val) {
        return val > 0 ? '+' + val : val;
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
      },
      showHydrometry() {
        return this.$store.getters.currentWaterTemperature ||
          this.$store.getters.currentWaterLevel ||
          this.$store.getters.currentIceThickness;
      }
    }
  }
</script>

<style scoped>
/*  html, body {
      margin: 0;
      padding: 0;
  }

  body {
      font-family: 'Roboto', sans-serif;
      background-color: #f8fafa;
      color: #333;
  }

  .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 2rem;
  }

  .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 2rem;
  }

  .header h1 {
      font-family: 'Orbitron', sans-serif;
      font-size: 2.5rem;
      color: #2b6cb0;
      margin: 0;
  }
*/
  .weather {
      text-align: center;
      margin: 2px;
      width: 100%;
      color: #fff;
      background-color: rgb(43, 46, 53);
      border-radius: 1rem;
      box-shadow: 0px 0px 15px 0px rgba(0, 0, 0, 0.1);
      transition: width 0.5s linear;
      padding: 2px 0;
  }

  .weather h2 {
      font-size: 2rem;
      margin-bottom: 0.3rem;
      margin-block-start: 0.3rem;
      cursor: pointer;
      min-height:32px;
  }

  .wrapper_meteo {
      display: flex;
      flex-wrap: wrap;
      padding: 1px;
      background-image: radial-gradient(circle, #4A4A4A 0%, #414151 70%, #0D0D0D 100%);
  }

  .params_block_wrapper {
      border: 2px solid rgba(141, 172, 45, 0.2);
      flex-grow: 1;
      text-align: center;
   }

  .params_block {
      display: flex;
      flex-wrap: wrap;
      padding: 4px;
      margin: 0 1px;
      justify-content: space-between;
      flex-grow: 1;
  }

  .temp-box {
      width: 170px;
      text-align: center;
      flex-grow: 1;
  }

  .wx_parameter {
      font-size: 35px;
      font-weight: 700;
      height: auto;
      line-height: 52.5px;
      color: lightsteelblue;
  }

  .text-small {
      color: rgb(159, 160, 163);
  }

  .text-bolder {
      font-weight: 500;
  }

  .text-green {
      color: rgb(141, 172, 45);
      margin-right: 1px;
  }

  .text-white-blue {
      color: lightblue;
  }

  .wind-rumb {
      font-size: 1rem;
      position:relative;
      top:-28px;
  }

  .align-center {
      align-content: center;
  }

  .justify-start {
      justify-self: start;
  }

  .space-between {
      display: flex;
      justify-content: space-between;
  }

  .ml20 {
      margin-left: 20px;
  }

  .pt-l-4 {
      top: 4px;
      left: 4px;
  }

  .height130 {
      height: 130px;
  }

  .text-unit {
      font-size: 14px;
      line-height: 28px;
      color: rgb(159, 160, 163);
      vertical-align: text-top;
  }

  .time {
      font-size: 1.2rem;
      color: #4a90e2;
      margin-bottom: 0.5rem;
  }

  .temp-max,
  .temp-min {
      font-size: 1.2rem;
      margin-bottom: 0.5rem;
  }

  .desc {
      color: #555;
  }

  .test {
      min-width: 100%;
  }

  .wind-arrow {
      position: relative;
      background-attachment: scroll;
      background-clip: border-box;
      background-color: rgba(0, 0, 0, 0);
      background-image: url('../assets/wind_arrow.png');
      background-origin:padding-box;
      background-position-x: 0%;
      background-position-y: 0%;
      background-repeat:no-repeat;
      background-size:100%;
      box-sizing:border-box;
      color:rgb(159, 160, 163);
      display: inline-flex;
      font-size:14px;
      height: 120px;
      line-height: 21px;
      margin: 0px;
      padding: 0px;

      text-size-adjust: 100%;
      width: 120px;
      -webkit-font-smoothing: antialiased;
      -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
  }

  .link-icon-left {
      width: 20px;
      height: 20px;
      position: relative;
      justify-self: flex-start;
      cursor: pointer;
  }

  .link-icon-right {
      width: 20px;
      height: 20px;
      position: relative;
      justify-self: flex-end;
      cursor: pointer;
  }

  .chart-link {
      background-image: url(../assets/chart.png);
      background-repeat: no-repeat;
  }

  .close-icon-right {
      position: absolute;
      right: 7px;
      cursor: pointer;
      border: 1px solid grey;
      border-radius: 50%;
      width: 22px;
      height: 22px;
  }
  .close-button-right {
      position: absolute;
      right: 5px;
      cursor: pointer;
      border: 1px solid transparent;
      border-radius: 20px;
      padding: 0 6px;
      color: yellowgreen;
      opacity: 0.6;
      margin: 3px;
  }

  .link-icon-left:hover, .link-icon-right:hover, .close-icon-right:hover, .close-button-right:hover {
      border: 1px solid yellowgreen;
  }
    .blur {
      backdrop-filter: blur(10px);
    }
</style>