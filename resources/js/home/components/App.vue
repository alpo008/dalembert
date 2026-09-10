<template>
  <div class="container-fluid wrapper">
  <div class="d-flex justify-content-center loader" v-if="loadingState || httpError">
    <div class="alert alert-secondary reload-link" role="alert" v-if="httpError" 
      @click="reloadPage"
     >
      {{ $t('Network error. Click to reload.') }}
    </div>
    <div class="spinner-border" role="status" v-if="!httpError">
      <span class="visually-hidden">Loading...</span>
    </div>
  </div>

<!--   <div class="ticker-wrapper">
  <div class="ticker bg-dark">
        <p class="h1">{{ $store.getters.weatherTicker }}</p>
  </div></div> -->
  <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-with-gradient">
    <div class="container-fluid">
      <button class="navbar-toggler" 
        type="button" 
        data-bs-toggle="collapse" 
        data-bs-target="#navbarDropdownMenu" 
        aria-controls="navbarDropdownMenu" 
        aria-expanded="false" 
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarDropdownMenu">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <router-link :class="navLinkClass('Home')" aria-current="page" to="/">Home</router-link>
          </li>
          <li class="nav-item">
            <router-link :class="navLinkClass('Meteo')" to="/meteo">Meteo</router-link>
          </li>
          <li class="nav-item">
            <router-link :class="navLinkClass('Webcam')" to="/webcam">Web camera</router-link>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
          </li>
        </ul>
      </div>
      <span class="navbar-brand mb-0">Lorem ipsum, dolor sit amet?</span>
    </div>
  </nav>

  <div class="container-fluid pt-70 mh-85 dark-water-layered">
    <router-view></router-view>
  </div>
    <footer class="py-1 bg-with-gradient">
      <div class="container px-1 px-lg-2">
        <p class="m-0 text-center text-white">
          {{ $store.getters.weatherTicker }}
        </p>
      </div>
  </footer>
</div>
</template>

<script>
import { Collapse } from 'bootstrap';

  const isEmpty = obj => [Object, Array].includes((obj || {}).constructor) && !Object.entries((obj || {})).length;
  //import WidgetWeather from './widgets/WidgetWeather.vue';
  export default {
    components: {
    },
    data: function () {
      return {
        loadingState: false,
        httpError: false,
        collapseInstance: null
      }
    },
    async created() {
      await this.$store.dispatch('httpRequest', {
        url: '/meteo/description',
        method: 'GET',
        data: null,
        mutation: 'setWeatherTicker'
      });
    },
    mounted() {
    },
    updated() {
      if (this.collapseInstance === null) {
        this.collapseInstance = new Collapse(document.getElementById("navbarDropdownMenu"),
        {toggle: false});
      }
      this.collapseInstance.hide();
    },
    methods: {
      reloadPage() {
        window.location.reload();
      },
      navLinkClass(routeName) {
        let result = 'nav-link';
        if (this.$route.name === routeName) {
          result += ' active';
        }
        return result;
      }
    },
    computed: {

    },
    watch: {
      $route(to, from) {
      },
      '$store.state.general.loading' (val) {
        this.loadingState = val;
      },
      '$store.state.general.httpError' (val) {
        this.httpError = val;
      }
    }
  }

</script>

<style scoped>
  .wrapper {
    padding: 0;
  }
  .reload-link {
    position:fixed;
    cursor: pointer;
  }
  .loader {
    width: 100vw;
    height: 100vh;
    z-index: 1000;
    align-items: center;
    position: fixed;
    backdrop-filter: blur(2px);
  }

  .bg-with-gradient {
    background-color: #0f172a;
    background-image: 
      radial-gradient(at 10% 20%, rgba(56, 189, 248, 0.3) 0px, transparent 50%),
      radial-gradient(at 90% 80%, rgba(236, 72, 153, 0.3) 0px, transparent 50%),
      radial-gradient(at 50% 50%, rgba(99, 102, 241, 0.2) 0px, transparent 50%);
  }

  .dark-water-layered {
    background: 
      radial-gradient(at 20% 20%, rgba(10, 61, 98, 0.4) 0px, transparent 50%),
      radial-gradient(at 80% 40%, rgba(0, 140, 153, 0.15) 0px, transparent 50%),
      linear-gradient(160deg, #031424 0%, #010a12 100%);
  }

  .ticker{
    height: auto;
    width:300px;
    margin:0 auto;
    background-color: transparent;
  }
  .ticker p{
    text-align:center;
    color: rgba(255, 255, 255, 0.55);
    font-size: 20px;
    animation: text 8s infinite linear;
    padding-left: 1000px;
    white-space: nowrap;
    background-color: transparent;
    margin-bottom: 0;
  }

  .ticker-wrapper {
    --bs-bg-opacity: 1;
    background-color: rgba(var(--bs-dark-rgb), var(--bs-bg-opacity)) !important;
    left: 0px;

  }
  @keyframes text {
    0%{
      transform: translate(0, 0);
    }
    
    100%{
      transform: translate(-160%, 0);
    }
  }
</style>