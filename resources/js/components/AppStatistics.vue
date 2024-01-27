<template>
  <h1> Statistics page</h1>
</template>
<script>
export default {
  components: {
  },
  data: function () {
    return {
      statistics: {}
    }
  },
  async created() {
    await this.$store.dispatch('httpRequest', {
      url: '/airmax-clients/statistics',
      method: 'POST',
      data: null,
      mutation: 'setStatistics'
    });
    this.statistics = this.$store.getters.airmaxStatistics;
  },
}

</script>