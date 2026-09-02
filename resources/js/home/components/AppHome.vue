<template>
<p>Home</p>
</template>
<script>
  const isEmpty = obj => [Object, Array].includes((obj || {}).constructor) && !Object.entries((obj || {})).length;
  export default {
    data: function () {
      return {
        stickers: []
      }
    },
    async created() {
      await this.$store.dispatch('updateStickers');
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