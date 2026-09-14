<template>
  <iframe :src="webCamSrc" 
    width="100%" height="580" 
    frameBorder="0" 
    seamless="seamless" 
    allowfullscreen
  >
    {{ $t('Your browser does not support frames') }} !
  </iframe>
</template>
<script>
  export default {
    data: function () {
      return {
        webCamSrc: `${process.env.MIX_WEBCAM_SRC}`
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