<template>
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

<div class="dropdown">
    <button
      class="btn btn-secondary dropdown-toggle"
      type="button"
      id="dropdownMenuButton1"
      data-bs-toggle="dropdown"
      aria-expanded="false"
    >
      Check Bootstrap
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
      <li><router-link to="/"> Home </router-link></li>
      <li><router-link to="/meteo"> Meteostation </router-link></li>
    </ul>
  </div>

  <router-view></router-view>


</template>

<script>
  const isEmpty = obj => [Object, Array].includes((obj || {}).constructor) && !Object.entries((obj || {})).length;
  //import WidgetWeather from './widgets/WidgetWeather.vue';
  export default {
    components: {
    },
    data: function () {
      return {
        loadingState: false,
        httpError: false
      }
    },
    created() {
    },
    mounted() {
    },
    methods: {
      reloadPage() {
        window.location.reload();
      }
    },
    computed: {
    },
    watch: {
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
</style>