<template>
<div>App</div>

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
      }
    },
    mounted() {
    },
    methods: {
    },
    computed: {
    }
}
</script>