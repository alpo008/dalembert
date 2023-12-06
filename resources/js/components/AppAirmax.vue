<template>
  <v-system-bar color="lightgrey" 
    style="height:50px;width: calc((100% - 10px) - 20px);top:120px;left:16px;"
    class="rounded"
  >
    <h2 class="pa-1 d-inline" style="margin-right: auto;"> Клиенты</h2>
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
          Place
        </th>
        <th class="text-left">
          Name
        </th>
      </tr>
    </thead>
    <tbody v-if="clients.length">
      <tr
        v-for="client in filteredClients"
        :key="client.place"
      >
        <td>
          <v-btn density="compact" :to="'/airmax/'+client.place">
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
      clients: []
    }
  },
  async created() {
    await this.$store.dispatch('updateAirmaxClients');
    this.clients = this.$store.getters.airmaxClients;
  },
  computed: {
    filteredClients() {
      const searchString = this.$store.getters.searchKey.toLowerCase();
      return this.clients.filter(client => {
          return (!!client.name && client.name.toLowerCase().indexOf(searchString) !== -1) ||
          (!!client.place && client.place.toLowerCase().indexOf(searchString) !== -1);
      });
    }
  }
}
</script>