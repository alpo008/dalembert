<template>
  <v-parallax
    src="./img/bg-gl.jpg"
    class="mt-n10"
  >
    <div class="d-flex flex-column fill-height justify-start align-center text-white mt-10">
    </div>
  </v-parallax>

</template>
<script>
  const isEmpty = obj => [Object, Array].includes((obj || {}).constructor) && !Object.entries((obj || {})).length;
  export default {
    data: function () {
      return {
      }
    },
    async created() {
      console.log(this.$route.name)
      let widget = document.getElementById('weatherapp');
      console.log(widget)
      if (this.$route.name == 'Home' && widget.length) {
        widget.remove();
      }
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