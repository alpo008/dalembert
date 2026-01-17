<template>
  <main class="main-section">
    <div class="weather" :style="toggler_style">
      <h2 @click="start">{{ _t('Our meteostation') }}</h2>
      <div v-if="show"> 
        {{ _t('Updated at') }} {{ updated_at }}
        <div class="wrapper" v-if="!chartMode">
          <div class="params_block_wrapper">
            <div class="params_block">
              <div class="temp-box">
                <div class="link-icon-left chart-link" 
                  @click="showChart('temperature')" 
                  :title="_t('Show chart')"
                >
                </div>
                <div class="text-small text-white text-bolder">
                  {{ _t('Temperature') }}
                </div>
                <div class="wx_parameter">
                  {{ temperature_out }} 
                  <span class="text-unit">
                    {{ temperature_unit }}
                  </span>
                </div>
                <div class="text-small">
                  {{ _t('Feels like') }}
                  <span class="text-green">
                    {{ feels_like }} {{ feels_like_unit }}
                  </span>
                </div>
              </div>
              <div class="temp-box">
                <div class="link-icon-right chart-link" 
                  @click="showChart('humidity')" 
                  :title="_t('Show chart')"
                >
                </div>
                <div class="text-small text-white text-bolder">
                  {{ _t('Humidity') }}
                </div>
                <div class="wx_parameter">
                  {{ humidity }} 
                  <span class="text-unit">
                    {{ humidity_unit }}
                  </span>
                </div>
                <div class="text-small">
                  {{ _t('Dew point') }}
                  <span class="text-green">
                    {{ dew_point }} {{ dew_point_unit }}
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div class="params_block_wrapper">
                <div class="link-icon-left chart-link pt-l-4" 
                  @click="showChart('pressure')" 
                  :title="_t('Show chart')"
                >
                </div>
            <div class="text-small text-white text-bolder">
              {{ _t('Pressure') }} 
            </div>
            <div class="params_block">
              <div class="temp-box">
                <div class="text-small">
                  {{ _t('Absolute') }}
                </div>
                <div class="wx_parameter">
                  {{ pressure_abs }}
                  <span class="text-unit">
                    {{ pressure_unit }}
                  </span>
                </div>
              </div>
              <div class="temp-box">
                <div class="text-small">
                  {{ _t('Relative') }}
                </div>
                <div class="wx_parameter">
                  {{ pressure_rel }}
                  <span class="text-unit">
                    {{ pressure_unit }}
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div class="params_block_wrapper">
                <div class="link-icon-left chart-link pt-l-4" 
                  @click="showChart('solar')" 
                  :title="_t('Show chart')"
                >
                </div>
            <div class="text-small text-white text-bolder">
              {{ _t('Solar and UVI') }}
            </div>
            <div class="params_block">
              <div class="temp-box">
                <div class="text-small">
                  {{ _t('Illumination') }}
                </div>
                <div class="wx_parameter">
                  {{ solar_rounded.value }}
                  <span class="text-unit">
                    {{ solar_rounded.unit }}
                  </span>
                </div>
              </div>
              <div class="temp-box">
                <div class="text-small">
                  {{ _t('UVI') }}
                </div>
                <div class="wx_parameter">
                  {{ uvi }}
                  <span class="text-unit">
                    {{ uvi_unit }}
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div class="params_block_wrapper">
              <div class="link-icon-left chart-link pt-l-4" 
                @click="showChart('wind')" 
                :title="_t('Show chart')"
              >
              </div>
            <div class="text-small text-white text-bolder">
              {{ _t('Wind') }}
            </div>
            <div class="params_block">
              <div class="temp-box">
                <div class="text-small">
                  {{ _t('Speed') }}
                </div>
                <div class="wx_parameter">
                  {{ wind_speed }}
                  <span class="text-unit">
                    {{ wind_speed_unit }}
                  </span>
                </div>
              </div>
              <div class="temp-box height130" v-if="!!wind_arrow_style">
                <div class="wind-arrow" :style="wind_arrow_style"></div>
                <div class="wx_parameter" style="position:relative;top:-100px;">
                  {{ wind_direction }}
                  <span class="text-unit">
                    {{ wind_direction_unit }}
                  </span>
                  <p class="wind-rumb">{{ wind_rumb }}</p>
                </div>
              </div>
              <div class="temp-box">
                <div class="text-small">
                  {{ _t('Gust') }}
                </div>
                <div class="wx_parameter">
                  {{ wind_gust }}
                  <span class="text-unit">
                    {{ wind_speed_unit }}
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div class="params_block_wrapper">
            <div class="link-icon-left chart-link pt-l-4" 
              @click="showChart('rainfall')" 
              :title="_t('Show chart')"
            >
            </div>
            <div class="text-small text-white text-bolder">
              {{ _t('Rain') }}
            </div>
            <div class="params_block">
              <div class="temp-box">
                <div class="text-small">
                  {{ _t('Per hour') }}
                </div>
                <div class="wx_parameter">
                  {{ rain_hour }} 
                  <span class="text-unit">
                    {{ rain_unit }}
                  </span>
                </div>
                <div class="text-small">
                  {{ _t('Per day') }}
                </div>
                <div class="wx_parameter">
                  {{ rain_day }} 
                  <span class="text-unit">
                    {{ rain_unit }}
                  </span>
                </div>
              </div>
              <div class="temp-box align-center">
                <div class="text-small space-between" style="height:2em;">
                  {{ _t('Weekly') }} <span class="text-green">
                    {{ rain_week }} {{ rain_unit }}
                  </span>
                </div>
                <div class="text-small space-between" style="height:2em;">
                  {{ _t('Monthly') }} <span class="text-green">
                    {{ rain_month }} {{ rain_unit }}
                  </span>
                </div>
                <div class="text-small space-between" style="height:2em;">
                  {{ _t('Yearly') }} <span class="text-green">
                    {{ rain_year }} {{ rain_unit }}
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="wrapper" v-if="chartMode">
          <div class="params_block">
            <div class="close-icon-right" @click="showChart(null)" :title="_t('Close')">
                &#65794;
            </div>
            <LineChart :history="dataset" style="" />
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
  import axios from "axios";
  import REQUEST_PARAMS from "./gwassets/request_params.ts";
  import TRANSLATIONS from "./gwassets/translations.ts";
  import moment from "moment/dist/moment";
  import LineChart from "./gwassets/LineChart.vue"

  import HISTORY_REQUEST_PARAMS from "./gwassets/history_request_params.ts";

  const HISTORY_UPDATES_INTERVAL = 7200000;  //TODO 2 hours
  const WEATHER_UPDATES_INTERVAL = 300000;  //TODO 5 minutes

export default {
  name: "App",
  components: { LineChart },
  data() {
    return {
      wxData: null,
      historyData: null,
      language: 'en-US',
      timer: '',
      updated_at: "",
      show: false,
      chartMode: false,
      dataset: null
    };
  },
  async mounted() {
    this.setLanguage();
    try {
      const response = await axios('https://electromore.ru/api/meteo');
    } catch (error) {
      console.error(this._t('Error fetching weather data:'), error);
    }
  },
  beforeDestroy() {
    clearInterval(this.timer);
  },
  methods: {
    async getWxData() {
      this.updateHistory();
      try {
        const response = await axios(REQUEST_PARAMS);
        this.wxData = response.data.data;
        this.updated_at = new Date().toLocaleTimeString('ru-RU', { 
          hour: '2-digit', 
          minute: '2-digit', 
          hour12: false 
        });
      } catch (error) {
        console.error(this._t('Error fetching weather data:'), error);
      }
    },
    async updateHistory() {
      this.historyData = JSON.parse(localStorage.getItem('history'));
      if (!this.history_is_ready) {
        try {
          const response = await axios(HISTORY_REQUEST_PARAMS);
          this.historyData = response.data.data;
          let currentTimestamp = Date.now();
          this.historyData.updated_at = currentTimestamp;
          localStorage.setItem('history', JSON.stringify(this.historyData));
        } catch (error) {
          console.error(this._t('Error fetching history data:'), error);
        }
      }
    },
    setLanguage() {
      this.language = window.navigator.language;
      if (typeof document === 'object') {
        let tagHtml = document.getElementsByTagName('html');
        if(typeof tagHtml === 'object' && typeof tagHtml[0] !== 'undefined') {
          if(typeof tagHtml[0] === 'object') {
            if(tagHtml[0].getAttribute('lang') !== null) {
              this.language = tagHtml[0].getAttribute('lang');
            }
          }
        }
      } 
      if(this.language === 'ru') {
        this.language = 'ru-RU'; 
      }
      if(this.language === 'en') {
        this.language = 'en-US'; 
      }
    },
    _t(txt) {
      let current = TRANSLATIONS[this.language];
      if (typeof current !== 'undefined') {
        return current[txt] ?? txt;
      }
      return txt;
    },
    start() {
      if (this.show) {
        clearInterval(this.timer);
      } else {
        this.getWxData();
        this.timer = setInterval(this.getWxData, 300000);
      }
      this.chartMode=false;
      this.show = !this.show;  
    },
    showChart(wx_param) {
      if (wx_param === null) {
        this.chartMode = false;
      } else {
        switch (wx_param) {
          case 'temperature' :
            this.dataset = this.temperature_history;
            break;
          case "humidity":
            this.dataset = this.humidity_history;
            break;
          case "pressure":
            this.dataset = this.pressure_history;
            break;
          case "solar":
            this.dataset = this.solar_history;
            break;
          case "wind":
            this.dataset = this.wind_history;
            break;
          case "rainfall":
            this.dataset = this.rainfall_history;
            break;
          default:
            this.dataset = this.temperature_history;
        }
        this.chartMode = true;
      }
    }
  },
  computed: {
    temperature_out() {
      return this.wxData?.outdoor?.temperature?.value ?? null;
    },
    temperature_unit() {
      return this.temperature_out !== null ? 
        this._t(this.wxData?.outdoor?.temperature?.unit) : 
        null;
    },
    pressure_abs() {
      return this.wxData?.pressure?.absolute?.value ?? null;
    },
    pressure_rel() {
      return this.wxData?.pressure?.relative?.value ?? null;
    },
    pressure_unit() {
      return this.pressure_abs !== null ? 
        this._t(this.wxData?.pressure?.absolute?.unit) : 
        null;
    },
    humidity() {
      return this.wxData?.outdoor?.humidity?.value ?? null;
    },
    humidity_unit() {
      return this.humidity !== null ? 
        this._t(this.wxData?.outdoor?.humidity?.unit) : 
        null;
    },
    rain_hour() {
      return this.wxData?.rainfall['1_hour']?.value ?? null;
    },
    rain_day() {
      return this.wxData?.rainfall?.daily?.value ?? null;
    },
    rain_event() {
      return this.wxData?.rainfall?.event?.value ?? null;
    },
    rain_week() {
      return this.wxData?.rainfall?.weekly?.value ?? null;
    },
    rain_month() {
      return this.wxData?.rainfall?.monthly?.value ?? null;
    },
    rain_year() {
      return this.wxData?.rainfall?.yearly?.value ?? null;
    },
    rain_unit() {
      return this._t(this.wxData?.rainfall?.daily?.unit ?? null);
    },
    wind_direction() {
      return this.wxData?.wind?.wind_direction?.value ?? null;
    },
    wind_gust() {
      return this.wxData?.wind?.wind_gust?.value ?? null;
    },
    wind_speed() {
      return this.wxData?.wind?.wind_speed?.value ?? null;
    },
    wind_direction_unit() {
      return this.wind_direction !== null ? 
        this._t(this.wxData?.wind?.wind_direction?.unit) : 
        null;
    },
    wind_speed_unit() {
      return this.wind_speed !== null ? 
        this._t(this.wxData?.wind?.wind_speed?.unit) : 
        null;
    },
    wind_arrow_style() {
      if (Boolean(this.wind_speed * 1) || Boolean(this.wind_gust * 1)) {
        return 'transform:rotate(' + this.wind_direction + 'deg)';
      }
      return null;
    },
    solar() {
      return this.wxData?.solar_and_uvi?.solar?.value ?? null;
    },
    solar_unit() {
      return this.solar !== null ? 
        this._t(this.wxData?.solar_and_uvi?.solar?.unit) : 
        null;
    },
    uvi() {
      return this.wxData?.solar_and_uvi?.uvi?.value ?? null;
    },
    uvi_unit() {
      return this.uvi !== null ? 
        this._t(this.wxData?.solar_and_uvi?.uvi?.unit) : 
        null;
    },
    dew_point() {
      return this.wxData?.outdoor?.dew_point?.value ?? null;
    },
    dew_point_unit() {
      return this.dew_point !== null ? 
        this._t(this.wxData?.outdoor?.dew_point?.unit) : 
        null;
    },
    feels_like() {
      return this.wxData?.outdoor?.feels_like?.value ?? null;
    },
    feels_like_unit() {
      return this.feels_like !== null ? 
        this._t(this.wxData?.outdoor?.feels_like?.unit) : 
        null;
    },
    solar_rounded() {
      let result = {
        value: this.solar,
        unit: this.solar_unit
      };
      if (this.solar > 5000) {
        result.value = (Math.round(this.solar / 100) / 10),
        result.unit = 'K' + this.solar_unit;
      }
      return result;
    },
    wind_rumb() {
      if (isNaN(this.wind_direction)) {
        return "";
      }
      let rumb = (this.wind_direction / 1) + 11.25;
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
    toggler_style() {
      if (!this.show) {
        return 'width: 270px;left: 0;';
      } else {
        return '';
      }
    },
    history_is_ready() {
      if (this.historyData === null || this.historyData.updted_at === undefined) {
        return false;
      }
      if (this.historyData.updated_at === null) {
        return false;
      }
      let currentTimestamp = Date.now();
      if (currentTimestamp - this.historyData.updated_at > HISTORY_UPDATES_INTERVAL) {
        return false;
      }
      return true;
    },
    temperature_history() {
      let temperatureHistory = this.historyData?.outdoor?.temperature?.list;
      let labels = [];
      let temperatureDataset = [];
      Object.keys(temperatureHistory).forEach(key => {
        if (!isNaN(key)) {
          labels.push(moment.unix(key).format("DD.MM"))
          temperatureDataset.push(parseFloat(temperatureHistory[key]));
        }
      });
      return {
        'labels':labels,
        'datasets': [
          {
            data:temperatureDataset,
            label: this._t('Temperature') + ', ' + this._t('℃'),  
            borderColor: 'rgb(141, 172, 45)', 
            backgroundColor: 'rgba(141, 172, 45, 0.3)',
            pointRadius: 3
          }
        ]
      };
    },
    humidity_history() {
      let humidityHistory = this.historyData?.outdoor?.humidity?.list;
      let labels = [];
      let humidityDataset = [];
      Object.keys(humidityHistory).forEach(key => {
        if (!isNaN(key)) {
          labels.push(moment.unix(key).format("DD.MM"))
          humidityDataset.push(parseFloat(humidityHistory[key]));
        }
      });
      return {
        'labels':labels,
        'datasets': [
          {
            data:humidityDataset,
            label: this._t('Humidity')  + ', ' + this._t('%'), 
            borderColor: 'rgb(141, 172, 45)', 
            backgroundColor: 'rgba(141, 172, 45, 0.3)',
            pointRadius: 3
          }
        ]
      };
    },
    pressure_history() {
      let pressureHistory = this.historyData?.pressure?.absolute?.list;
      let labels = [];
      let pressureDataset = [];
      Object.keys(pressureHistory).forEach(key => {
        if (!isNaN(key)) {
          labels.push(moment.unix(key).format("DD.MM"))
          pressureDataset.push(parseFloat(pressureHistory[key]));
        }
      });
      return {
        'labels':labels,
        'datasets': [
          {
            data:pressureDataset,
            label: this._t('Pressure') + ', ' + this._t('mmHg'), 
            borderColor: 'rgb(141, 172, 45)', 
            backgroundColor: 'rgba(141, 172, 45, 0.3)',
            pointRadius: 3
          }
        ]
      };
    },
    wind_history() {
      let windHistory = this.historyData?.wind?.wind_speed?.list;
      let labels = [];
      let windDataset = [];
      Object.keys(windHistory).forEach(key => {
        if (!isNaN(key)) {
          labels.push(moment.unix(key).format("DD.MM"))
          windDataset.push(parseFloat(windHistory[key]));
        }
      });
      return {
        'labels':labels,
        'datasets': [
          {
            data:windDataset,
            label: this._t('Wind') + ', ' + this._t('m/s'), 
            borderColor: 'rgb(141, 172, 45)', 
            backgroundColor: 'rgba(141, 172, 45, 0.3)',
            pointRadius: 3
          }
        ]
      };
    },
    rainfall_history() {
      let rainfallHistory = this.historyData?.rainfall?.event?.list;
      let labels = [];
      let rainfallDataset = [];
      Object.keys(rainfallHistory).forEach(key => {
        if (!isNaN(key)) {
          labels.push(moment.unix(key).format("DD.MM"))
          rainfallDataset.push(parseFloat(rainfallHistory[key]));
        }
      });
      return {
        'labels':labels,
        'datasets': [
          {
            data:rainfallDataset,
            label: this._t('Rain') + ', ' + this._t('mm'),  
            borderColor: 'rgb(141, 172, 45)', 
            backgroundColor: 'rgba(141, 172, 45, 0.3)',
            pointRadius: 3
          }
        ]
      };
    },
    solar_history() {
      let solarHistory = this.historyData?.solar_and_uvi?.solar?.list;
      let labels = [];
      let solarDataset = [];
      Object.keys(solarHistory).forEach(key => {
        if (!isNaN(key)) {
          if (moment.unix(key).hour() === 15) {
            labels.push(moment.unix(key).format("DD.MM"))
            solarDataset.push(parseFloat(solarHistory[key]));
          }
        }
      });
      return {
        'labels':labels,
        'datasets': [
          {
            data:solarDataset,
            label: this._t('Illumination') + ', ' + this._t('lx'), 
            borderColor: 'rgb(141, 172, 45)', 
            backgroundColor: 'rgba(141, 172, 45, 0.3)',
            pointRadius: 3
          }
        ]
      };
    }
  }
}
</script>

<style scoped>

  html, body {
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

  .weather {
      text-align: center;
      width: 100%;
      color: #fff;
      margin-bottom: 3rem;
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
  }

  .wrapper {
      display: flex;
      flex-wrap: wrap;
      padding: 1px;
  }

  .params_block_wrapper {
      border: 2px solid rgba(141, 172, 45, 0.2);
      flex-grow: 1;
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

  .text-white {
      color: rgb(255, 255, 255);
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
      background-image: url('gwassets/wind_arrow.png');
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
      background-image: url(gwassets/chart.png);
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

  .link-icon-left:hover, .link-icon-right:hover, .close-icon-right:hover {
      background-color: darkslategrey;
  }

</style>
