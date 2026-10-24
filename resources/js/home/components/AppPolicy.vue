<template>
  <div class="alert">
    <div class="row mb-3" ref="rootDiv"></div>
  </div>
</template>
<script>
  export default {
    data: function () {
      return {
      }
    },
    mounted() {
      this.$refs.rootDiv.insertAdjacentHTML('beforeend', 
        this.$store.getters.findOrFail(this.$store.getters.config, 'policy')
      );
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