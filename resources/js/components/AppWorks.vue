<template>
  <div>
Price-list
  </div>
</template>
<script>
  export default {
    data: function () {
      return {

      }
    },
    async created() {
      await this.$store.dispatch('httpRequest', {
        url: '/works',
        method: 'GET',
        data: null,
        mutation: ''
      });
    },
  }
</script>
<style scoped>

</style>