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

  <div class="ticker-wrapper">
    <div class="ticker bg-light">
      <p>Lorem, ipsum, dolor sit amet consectetur adipisicing elit. Eaque sunt, ...</p>
    </div>
  </div>

  <nav class="navbar sticky-top navbar-light bg-light">
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
            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <router-view></router-view>
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
        mutation: ''
      });
    },
    mounted() {
      this.collapseInstance = new Collapse(document.getElementById("navbarDropdownMenu"));
      setTimeout(() => this.collapseInstance.hide(), 1000);
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
        if (to.path !== from.path) {
          this.collapseInstance.hide();
        }
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
  .ticker{
    height: auto;
    width:300px;
    margin:0 auto;
    background-color: transparent;
  }
  .ticker p{
    text-align:center;
    color: #555;
    animation: text 8s infinite linear;
    padding-left: 1000px;
    white-space: nowrap;
    background-color: transparent;
    margin-bottom: 0;
  }

  .ticker-wrapper {
    --bs-bg-opacity: 1;
    background-color: rgba(var(--bs-light-rgb), var(--bs-bg-opacity)) !important;
    left: 0px;
    width: 100%;
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