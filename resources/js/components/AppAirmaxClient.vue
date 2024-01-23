<template>
  <v-card style="margin-top:-20px;">
    <v-tabs
      v-model="tab"
      bg-color="secondary"
      style="position:sticky;"
    >
      <v-tab value="settings" class="px-1 text-h6">
        <v-icon icon="mdi-account-cog-outline" :title="$t('Settings')"></v-icon>
      </v-tab>
      <v-tab value="documents" class="px-1 text-h6">
        <v-icon icon="mdi-account-card-outline" :title="$t('Documents')"></v-icon>
      </v-tab>
      <v-tab value="payments" class="px-1 text-h6">
        <v-icon icon="mdi-account-cash-outline" :title="$t('Payments')"></v-icon>
      </v-tab>
      <v-spacer></v-spacer>
      <div style="line-height: 48px;" class="elevation-2 px-2 font-weight-bold text-medium-emphasis rounded-pill">
        {{ clientData.place }}
      </div>
    </v-tabs>
    <v-card-text>
      <v-window v-model="tab">
        <v-window-item value="settings">
          <v-system-bar color="transparent"
            v-if="editable"
            style="height:50px;width:auto;top:160px;right:20px;left:auto;padding: 0 2%;justify-content:center;"
            class="rounded"
            elevation="10"
          >
            <v-btn
              icon="mdi-delete-alert-outline"
              v-if="editable"
              @click="deleteClient"
              style="margin: 0 3%;"
              :title="$t('Delete')"
            >
            </v-btn>
            <v-btn
              icon="mdi-content-save"
              v-if="editable"
              @click="save"
              style="margin: 0 3%;"
              :title="$t('Save')"
            >
            </v-btn>
          </v-system-bar>
          <div @dblclick="swapEditionMode">
          <v-switch 
            v-model="clientData.active" 
            :label="$t('Active')" 
            :readonly="!editable"
          >            
          </v-switch>
          <v-text-field 
            type="text"
            :label="$t('Place')"
            ref="place"
            v-if="isNew|!!clientData.place|editable"
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
            @click:append="openGeo(formattedLocation)"
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
          <v-select
            :label="$t('Base station')"
            ref="ap_mac"
            v-if="!!clientData.ap_mac|editable"
            v-model="clientData.ap_mac"
            :error-messages="errors.ap_mac"
            :items="baseStations"
            :readonly="!editable"
            append-icon="mdi-content-copy"
            @click:append="copyText('ap_mac')"
          >    
          </v-select> 
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
          </div>
          <widget-confirm ref="confirm"></widget-confirm>
        </v-window-item>
        <v-window-item value="documents">
          <app-documents :clientid="clientData.id" objectname="AirmaxClient"></app-documents>
        </v-window-item>
        <v-window-item value="payments">
          <app-payments :clientid="clientData.id" objectname="AirmaxClient"></app-payments>
        </v-window-item>
      </v-window>
    </v-card-text>
  </v-card>
</template>
<script>
  import WidgetConfirm from './widgets/WidgetConfirm.vue';
  import AppDocuments from './AppDocuments.vue';
  import AppPayments from './AppPayments.vue';
  const isEmpty = obj => [Object, Array].includes((obj || {}).constructor) && !Object.entries((obj || {})).length;
  export default {
    components: {
      WidgetConfirm,
      AppDocuments,
      AppPayments
    },
    data: function () {
      return {
        editable: false,
        isNew: false,
        place: '',
        clientData: {},
        errors: {},
        tab: null,
        baseStations: [
          {'title': 'AKM071(EE)', 'value': '00:27:22:12:DF:EE'}, 
          {'title': 'AKM072(7F)', 'value': '00:27:22:12:DF:7F'}, 
          {'title': 'AKM073(4D)', 'value': 'DC:9F:DB:34:13:4D'}
        ]
      }
    },
    async created() {
      this.$store.commit('setCurrentClient', {});
      if (!this.$store.getters.airmaxClients.length) {
        await this.$store.dispatch('updateAirmaxClients');
      }
      this.place = this.$route.params.place;
      if (this.place === 'new') {
        this.isNew = true;
        this.editable = true;
      }
      this.$store.commit('setCurrentPlace', this.place);
      this.clientData = this.$store.getters.currentAirmaxClient;
      this.$store.commit('setPayments', this.clientData);
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
        let url, method, id;
        if(!!this.clientData.id) {
          id = this.clientData.id;
        } else {
          id = this.$store.getters.currentAirmaxClientId;
          if(!!id){
            this.clientData.id = id;
          } 
        }
        url = this.isNew ? '/airmax-clients/' : '/airmax-clients/' + id;
        method = this.isNew ? 'POST' : 'PUT';
        delete this.clientData.payments;
        delete this.clientData.attachments;
        this.$store.dispatch('httpRequest', {
          url: url,
          method: method,
          data: this.clientData,
          mutation: 'setCurrentClient'
        }).then(() => {
          this.errors = this.$store.getters.httpErrors;
          if(isEmpty(this.errors)) {
            this.$store.dispatch('updateAirmaxClients');
            this.place = this.clientData.place;
            this.isNew = false;
            this.$router.push('/airmax/' + this.clientData.place);
          }
        });
      },
      deleteClient() {
        if (!isNaN(this.clientData.id)) {
          this.$refs.confirm.open(this.$t('Deletion'), 
            this.$t('Are you sure?'), { color: '#ff0266' }).then((confirm) => {
            if(confirm) {
              this.$store.dispatch('httpRequest', {
              url:'/airmax-clients/' + this.clientData.id,
              method: 'DELETE',
              data: this.clientData,
              mutation: ''
              }).then(() => {
                this.errors = this.$store.getters.httpErrors;
                this.$store.dispatch('updateAirmaxClients');
                this.$router.push('/airmax')
              });
            }
          });
        }
      }
    },
    computed: {
      formattedLocation () {
      try {      
        let loc = JSON.parse(this.clientData.location);
          if (typeof(loc) === 'object' && loc !== null && typeof(loc.lat) !== 'undefined' && typeof(loc.lng) !== 'undefined') {
            return '(' + loc.lat + ',' + loc.lng + ')';
          }
        }
        catch (e) { }
        return null;
      }
    }
  }
</script>

<style scoped>
  .v-window-item {
    min-height: 70vh!important;
  }
</style>