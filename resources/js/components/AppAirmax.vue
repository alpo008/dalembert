<template>
  <v-system-bar color="lightgrey" 
    style="height:50px;width: calc((100% - 10px) - 20px);top:120px;left:16px;"
    class="rounded"
  >
    <h2 class="pa-1 d-inline" style="margin-right: auto;"> {{ $t('Airmax clients') }}</h2>
    <v-btn
      icon="mdi-account-plus-outline"
      to="/airmax/new"
    >
    </v-btn>
  </v-system-bar>
  <v-table
    fixed-header
    height="90%"
  >
    <thead>
      <tr>
        <th class="text-left">
          {{ $t('Place') }}
        </th>
        <th class="text-left">
          {{ $t('Name') }}
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
      </tr>
    </tbody>
  </v-table>
</template>
<script>
export default {
  data: function () {
    return {
      clients: [],
      errors: {}
    }
  },
  async created() {
    this.$store.commit('setCurrentClient', {'current' : {}});
    await this.$store.dispatch('updateAirmaxClients');
    this.clients = this.$store.getters.airmaxClients;
    this.errors = this.$store.getters.httpErrors;
  },
  computed: {
    filteredClients() {
      const searchString = this.$store.getters.searchKey.toLowerCase();
      return this.clients.filter(client => {
          return (!!client.name && client.name.toLowerCase().indexOf(searchString) !== -1) ||
          (!!client.place && client.place.toLowerCase().indexOf(searchString) !== -1) ||
          (!!client.wlan_mac && client.wlan_mac.toLowerCase().indexOf(searchString.toLowerCase()) !== -1);
      });
    }
  }
}
</script>