<template>
  <h1> Клиент {{ place }}</h1>
</template>
<script>
export default {
  data: function () {
    return {
      place: '',
      clientData: {}
    }
  },
  created() {
    if (!this.$store.getters.airmaxClients.length) {
      this.$store.dispatch('updateAirmaxClients');
    }
    this.place = this.$route.params.place;
    this.$store.commit('setCurrentClient', this.place);
    this.clientData = this.$store.getters.currentAirmaxClient;
  }
}
</script>