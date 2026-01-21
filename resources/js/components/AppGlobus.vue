<template>

<widget-gweather/>
</template>
<script>
  const isEmpty = obj => [Object, Array].includes((obj || {}).constructor) && !Object.entries((obj || {})).length;
  import WidgetGweather from './widgets/WidgetGweather.vue'
  export default {
    components: {
      WidgetGweather
    },
    data: function () {
      return {
      }
    },
    async created() {
    },
    methods: {
    },
    computed: {
    }
  }
</script>
<style scoped>
    .blur {
      backdrop-filter: blur(10px);
    }
</style>