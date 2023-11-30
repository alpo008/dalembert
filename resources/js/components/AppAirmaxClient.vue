<template>
  <div style="display:inline-flex;justify-content:space-between;width:100%;">
    <h2 class="pa-1 d-inline"> Клиент {{ place }}</h2>
    <v-btn
      icon="mdi-note-edit"
      @click="swapEditionMode"
    >
    </v-btn>
  </div>
    <v-divider></v-divider>
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
    label="Location"
    ref="location"
    v-if="!!clientData.location|editable"
    v-model="clientData.location"
    :readonly="!editable"
    append-icon="mdi-map"
    @click:append="openGeo(clientData.location)"
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
    label="Bridge model"
    ref="ap_model"
    v-if="!!clientData.ap_model|editable"
    v-model="clientData.ap_model"
    :readonly="!editable"
    append-icon="mdi-web"
    @click:append="openLink('google.com/search?q=' + clientData.ap_model)"
  >
  </v-text-field>
  <v-text-field 
    type="date"
    label="Installed on"
    ref="installed_on"
    v-if="!!clientData.installed_on|editable"
    v-model="clientData.installed_on"
    :readonly="!editable"
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
  <v-text-field 
    type="text"
    label="Bridge WLAN MAC"
    ref="wlan_mac"
    v-if="!!clientData.lan_mac|editable"
    v-model="clientData.lan_mac"
    :readonly="!editable"
    append-icon="mdi-content-copy"
    @click:append="copyText('lan_mac')"
  >
  </v-text-field>
  <v-text-field 
    type="text"
    label="Bridge LAN MAC"
    ref="lan_mac"
    v-if="!!clientData.wlan_mac|editable"
    v-model="clientData.wlan_mac"
    :readonly="!editable"
    append-icon="mdi-content-copy"
    @click:append="copyText('wlan_mac')"
  >
  </v-text-field>
  <v-text-field 
    type="text"
    label="Router model"
    ref="router_model"
    v-if="!!clientData.router_model|editable"
    v-model="clientData.router_model"
    :readonly="!editable"
    append-icon="mdi-web"
    @click:append="openLink('google.com/search?q=' + clientData.router_model)"
  >
  </v-text-field>
  <v-text-field 
    type="text"
    label="Router admin"
    ref="admin"
    v-if="!!clientData.admin|editable"
    v-model="clientData.admin"
    :readonly="!editable"
    append-icon="mdi-content-copy"
    @click:append="copyText('admin')"
  >
  </v-text-field>
  <v-text-field 
    type="text"
    label="Router LAN IP"
    ref="router_ip_address"
    v-if="!!clientData.router_ip_address|editable"
    v-model="clientData.router_ip_address"
    :readonly="!editable"
    append-icon="mdi-web"
    @click:append="openLink(clientData.router_ip_address)"
  >
  </v-text-field>
  <v-text-field 
    type="text"
    label="Router MAC"
    ref="router_mac"
    v-if="!!clientData.router_mac|editable"
    v-model="clientData.router_mac"
    :readonly="!editable"
    append-icon="mdi-content-copy"
    @click:append="copyText('router_mac')"
  >
  </v-text-field>
  <v-btn
    icon="mdi-content-save"
    v-if="editable"
    @click="save"
  >
  </v-btn>
</template>
<script>
export default {
  data: function () {
    return {
      editable: false,
      place: '',
      clientData: {}
    }
  },
  async created() {
    if (!this.$store.getters.airmaxClients.length) {
      await this.$store.dispatch('updateAirmaxClients');
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
      window.open('tel://' + phoneNo);
    },
    sendEmail(addr) {
      window.open('mailto:' + addr, '_system');
    },
    openLink(ip_address) {
      let url = 'http://' + ip_address;
      window.open(url, '_blank').focus();
    },
    openGeo(coords) {
      let c = coords.replace('(', '').replace(')', '');
      let url = 'geo:' + c + ";z=16&q=" + c;
      window.open(url, '_system').focus();
    },
    swapEditionMode() {
      this.editable = !this.editable;
    },
    save() {
      this.$store.dispatch('saveClient', this.clientData);
    }
  },
  computed: {
    formattedLocation () {
      let loc = this.clientData.location;
      let result = null;
      if (typeof(loc) === 'object' && loc !== null && typeof(loc.lat) !== 'undefined' && typeof(loc.lng) !== 'undefined') {
        result = '(' + loc.lat + ',' + loc.lng + ')';
      }
      return result;
    }
  }
}
</script>