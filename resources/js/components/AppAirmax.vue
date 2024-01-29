<template>
  <v-system-bar color="white" style="top:115px;max-width: 50vw;">
  <h2 class="pa-1 d-inline" style="margin-right: auto;max-width:fit-content;"> {{ $t('Airmax clients') }}</h2>
  <v-checkbox
    style="max-width:fit-content;"    
    v-model="activityFilter.active"
    :label="$t('Active')"
    color="success"
    hide-details
@change="tst"
  >
  </v-checkbox> 
  <v-checkbox
    style="max-width:fit-content;"
    v-model="activityFilter.disabled"
    :label="$t('Disabled')"
    color="warning"
    hide-details
    @change="tst"
  >   
  </v-checkbox>
</v-system-bar>
  <v-system-bar color="white" 
    style="height:50px;width:auto;top:115px;right:20px;left:auto;padding: 0 2%;justify-content:center;"
    class="rounded"
    elevation="10"
  >
    <v-btn
      icon="mdi-file-excel"
      @click="exportExcel"
      style="margin: 0 3%;"
      :title="$t('Export')"
    >
    </v-btn>
    <v-btn
      icon="mdi-account-plus-outline"
      to="/airmax/new"
      style="margin: 0 3%;"
      :title="$t('New client')"
    >
    </v-btn>
  </v-system-bar>
  <v-table
    fixed-header
    style="height:90%;width:80%;margin-top: 30px;"
    class="table-condensed"
  >
    <thead>
      <tr>
        <th class="text-left">
          {{ $t('Place') }}
        </th>
        <th class="text-left">
          {{ $t('Name') }}
        </th>
        <th class="text-left">
          {{ $t('Bridge IP') }}
        </th>
      </tr>
    </thead>
    <tbody v-if="clients.length">
      <tr
        v-for="client in filteredClients"
        :key="client.wlan_mac"
      >
        <td>
          <v-btn 
            density="compact" :to="'/airmax/'+client.place" 
            :prepend-icon="client.active? 'mdi-check-circle' : 'mdi-close-circle'"
          >
          <template v-slot:prepend>
            <v-icon :color="client.active? 'success' : 'error'"></v-icon>
          </template>
            {{ client.place }}
          </v-btn>
        </td>
        <td>{{ client.name }}</td>
        <td>
          <a :href="'http://' + client.ip_address" target="_blank">{{ client.ip_address }}</a>
        </td>
      </tr>
    </tbody>
  </v-table>
</template>
<script>
  const FileSaver = require('file-saver');
  export default {
    data: function () {
      return {
        clients: [],
        errors: {},
        activityFilter: {
          active: true,
          disabled: true
        }
      }
    },
    async created() {
      this.$store.commit('setCurrentClient', {'current' : {}});
      await this.$store.dispatch('updateAirmaxClients');
      this.clients = this.$store.getters.airmaxClients;
      this.errors = this.$store.getters.httpErrors;
    },
    methods: {
      exportExcel() {
        axios.get('export/airmax', {responseType: 'blob'}).then((response) => {
          FileSaver.saveAs(response.data, 'airmax-clients.xlsx');
        }).catch((error) => {
          let message = error.message ?? this.$t('Could not Download the Excel report');
          this.$store.commit('setHttpErrors', message);
        });
      },
      tst() {
        //console.log(this.activityFilter)
      }
    },
    computed: {
      filteredClients() {
        const searchString = this.$store.getters.searchKey.toLowerCase();
        return this.clients.filter(client => {
            let activityCriteria = client.active&this.activityFilter.active || !client.active&this.activityFilter.disabled;
            return ((!!client.name && client.name.toLowerCase().indexOf(searchString) !== -1) ||
            (!!client.place && client.place.toLowerCase().indexOf(searchString) !== -1) ||
            (!!client.ip_address && client.ip_address.indexOf(searchString) !== -1) ||
            (!!client.wlan_mac && client.wlan_mac.toLowerCase().indexOf(searchString.toLowerCase()) !== -1)) &&
            activityCriteria;
        });
      }
    }
  }
</script>