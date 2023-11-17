<template>
  <h1> Клиенты </h1>
    <v-table
    fixed-header
    height="300px"
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
    <tbody>
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
  created() {
    this.$store.dispatch('updateAirmaxClients');
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