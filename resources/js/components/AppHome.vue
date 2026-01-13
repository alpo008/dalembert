<template>
  <v-parallax
    src="./img/bg-gl.jpg"
    class="mt-n10"
    style=""
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