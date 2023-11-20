<template>
  <h1> Клиент {{ place }}</h1>
  <v-text-field 
    label="Name"
    ref="name"
    v-if="!!clientData.name|editable"
    v-model="clientData.name"
    :readonly="!editable"
    append-icon="mdi-content-copy"
    @click:append="copyText('name')"
  >
  </v-text-field>
</template>
<script>
export default {
  data: function () {
    return {
      editable: true,
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
  },
  methods:{
    copyText(txt){
      const element = this.$refs[txt];
      element.select();
      element.setSelectionRange(0, 99999);
      document.execCommand('copy');
    }
  }
}Васильев Андрей Евгньевич
</script>