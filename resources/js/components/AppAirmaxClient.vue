<template>
  <h1> Клиент {{ place }}</h1>
  <v-text-field 
    type="text"
    label="Name"
    ref="name"
    v-if="!!clientData.name|editable"
    v-model="clientData.name"
    :readonly="!editable"
    append-icon="mdi-content-copy"
    @click:append="copyText('name')"
  >
  </v-text-field>
  <v-text-field 
    type="tel"
    label="Phone"
    ref="phone"
    v-if="!!clientData.phone|editable"
    v-model="clientData.phone"
    :readonly="!editable"
    append-icon="mdi-phone"
    @click:append="phoneCall(clientData.phone)"
  >
  </v-text-field>
  <v-text-field 
    type="email"
    label="E-mail"
    ref="email"
    v-if="!!clientData.email|editable"
    v-model="clientData.email"
    :readonly="!editable"
    append-icon="mdi-email"
    @click:append="sendEmail(clientData.email)"
  >
  </v-text-field>
  <v-text-field 
    type="text"
    label="SSID"
    ref="ssid"
    v-if="!!clientData.ssid|editable"
    v-model="clientData.ssid"
    :readonly="!editable"
    append-icon="mdi-content-copy"
    @click:append="copyText('ssid')"
  >
  </v-text-field>
  <v-text-field 
    type="text"
    label="Password"
    ref="password"
    v-if="!!clientData.password|editable"
    v-model="clientData.password"
    :readonly="!editable"
    append-icon="mdi-content-copy"
    @click:append="copyText('password')"
  >
  </v-text-field>
  <v-text-field 
    type="text"
    label="Bridge IP"
    ref="ip_address"
    v-if="!!clientData.ip_address|editable"
    v-model="clientData.ip_address"
    :readonly="!editable"
    append-icon="mdi-web"
    @click:append="openLink(clientData.ip_address)"
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
    console.log(this.clientData)
  },
  methods:{
    copyText(txt){
      const element = this.$refs[txt];
      element.select();
      element.setSelectionRange(0, 99999);
      document.execCommand('copy');
    },
    phoneCall(phoneNo) {
      window.location.href = 'tel://' + phoneNo;
    },
    sendEmail(addr) {
      window.location.href = 'mailto://' + addr;
    },
    openLink(ip_address) {
      let url = 'http://' + ip_address;
      window.open(url, '_blank').focus();
    }
  }
}
</script>