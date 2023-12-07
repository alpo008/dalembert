<template>
  <v-system-bar color="lightgrey" 
    style="height:50px;width: calc((100% - 10px) - 60px);top:120px;left:16px;"
    class="rounded"
  >
    <h2 class="pa-1 d-inline" style="margin-right: auto;"> {{ $t('Client') }} {{ place }}</h2>
    <v-btn
      icon="mdi-content-save"
      v-if="editable"
      @click="save"
    >
    </v-btn>
    <v-btn
      icon="mdi-note-edit"
      @click="swapEditionMode"
      style="margin: 0 1%;"
    >
    </v-btn>
  </v-system-bar>
  <div style="width:100%; margin-top:65px;"></div>
  <v-text-field 
    type="text"
    :label="$t('Place')"
    ref="place"
    v-if="isNew"
    v-model="clientData.place"
    :readonly="!editable"
    append-icon="mdi-content-copy"
    @click:append="copyText('place')"
    :error-messages="errors.place"
    counter="30"
  >
  </v-text-field>
  <v-text-field 
    type="text"
    :label="$t('Name')"
    ref="name"
    v-if="!!clientData.name|editable"
    v-model="clientData.name"
    :readonly="!editable"
    append-icon="mdi-content-copy"
    @click:append="copyText('name')"
    :error-messages="errors.name"
    counter="30"
  >
  </v-text-field>
  <v-text-field 
    type="tel"
    :label="$t('Phone')"
    ref="phone"
    v-if="!!clientData.phone|editable"
    v-model="clientData.phone"
    :readonly="!editable"
    append-icon="mdi-phone"
    @click:append="phoneCall(clientData.phone)"
    :error-messages="errors.phone"
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
    :error-messages="errors.email"
  >
  </v-text-field>
  <v-text-field 
    type="text"
    :label="$t('Location')"
    ref="location"
    v-if="!!clientData.location|editable"
    v-model="clientData.location"
    :readonly="!editable"
    append-icon="mdi-map"
    @click:append="openGeo(clientData.location)"
    :error-messages="errors.location"
  >
  </v-text-field>
  <v-text-field 
    type="date"
    :label="$t('Installed on')"
    ref="installed_on"
    v-if="!!clientData.installed_on|editable"
    v-model="clientData.installed_on"
    :readonly="!editable"
    :error-messages="errors.installed_on"
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
    :error-messages="errors.ssid"
    counter="30"
  >
  </v-text-field>
  <v-text-field 
    type="text"
    :label="$t('Password')"
    ref="password"
    v-if="!!clientData.password|editable"
    v-model="clientData.password"
    :readonly="!editable"
    append-icon="mdi-content-copy"
    @click:append="copyText('password')"
    :error-messages="errors.password"
    counter="8"
  >
  </v-text-field>
  <v-text-field 
    type="text"
    :label="$t('Bridge model')"
    ref="ap_model"
    v-if="!!clientData.ap_model|editable"
    v-model="clientData.ap_model"
    :readonly="!editable"
    append-icon="mdi-web"
    @click:append="openLink('google.com/search?q=' + clientData.ap_model)"
    :error-messages="errors.ap_model"
    counter="30"
  >
  </v-text-field>
  <v-text-field 
    type="text"
    :label="$t('Bridge IP')"
    ref="ip_address"
    v-if="!!clientData.ip_address|editable"
    v-model="clientData.ip_address"
    :readonly="!editable"
    append-icon="mdi-web"
    @click:append="openLink(clientData.ip_address)"
    :error-messages="errors.ip_address"
  >
  </v-text-field>
  <v-text-field 
    type="text"
    :label="$t('Bridge WLAN MAC')"
    ref="wlan_mac"
    v-if="!!clientData.lan_mac|editable"
    v-model="clientData.wlan_mac"
    :readonly="!editable"
    append-icon="mdi-content-copy"
    @click:append="copyText('lan_mac')"
    :error-messages="errors.wlan_mac"
  >
  </v-text-field>
  <v-text-field 
    type="text"
    :label="$t('Bridge LAN MAC')"
    ref="lan_mac"
    v-if="!!clientData.lan_mac|editable"
    v-model="clientData.lan_mac"
    :readonly="!editable"
    append-icon="mdi-content-copy"
    @click:append="copyText('lan_mac')"
    :error-messages="errors.lan_mac"
  >
  </v-text-field>
  <v-text-field 
    type="text"
    :label="$t('Router model')"
    ref="router_model"
    v-if="!!clientData.router_model|editable"
    v-model="clientData.router_model"
    :readonly="!editable"
    append-icon="mdi-web"
    @click:append="openLink('google.com/search?q=' + clientData.router_model)"
    :error-messages="errors.router_model"
    counter="30"
  >
  </v-text-field>
  <v-text-field 
    type="text"
    :label="$t('Router admin')"
    ref="admin"
    v-if="!!clientData.admin|editable"
    v-model="clientData.admin"
    :readonly="!editable"
    append-icon="mdi-content-copy"
    @click:append="copyText('admin')"
    :error-messages="errors.admin"
  >
  </v-text-field>
  <v-text-field 
    type="text"
    :label="$t('Router LAN IP')"
    ref="router_ip_address"
    v-if="!!clientData.router_ip_address|editable"
    v-model="clientData.router_ip_address"
    :readonly="!editable"
    append-icon="mdi-web"
    @click:append="openLink(clientData.router_ip_address)"
    :error-messages="errors.router_ip_address"
  >
  </v-text-field>
  <v-text-field 
    type="text"
    :label="$t('Router MAC')"
    ref="router_mac"
    v-if="!!clientData.router_mac|editable"
    v-model="clientData.router_mac"
    :readonly="!editable"
    append-icon="mdi-content-copy"
    @click:append="copyText('router_mac')"
    :error-messages="errors.router_mac"
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
      isNew: false,
      place: '',
      clientData: {},
      errors: {}
    }
  },
  async created() {
    if (!this.$store.getters.airmaxClients.length) {
      await this.$store.dispatch('updateAirmaxClients');
    }
    this.place = this.$route.params.place;
    if (this.place === 'new') {
      this.isNew = true;
      this.editable = true;
    }
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
      let url, method;
      url = this.isNew ? '/airmax-clients/' : '/airmax-clients/' + this.clientData.id;
      method = this.isNew ? 'POST' : 'PUT';
      this.$store.dispatch('httpRequest', {
        url: url,
        method: method,
        data: this.clientData,
        mutation: ''
      }).then(() => {
        this.errors = this.$store.getters.httpErrors;
        this.$store.dispatch('updateAirmaxClients');
        this.isNew = false;
        this.editable = false;
        this.$store.commit('setCurrentClient', this.place);
        this.clientData = this.$store.getters.currentAirmaxClient;
      });
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