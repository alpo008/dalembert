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
        v-for="client in clients"
        :key="client.place"
      >
        <td>{{ client.place }}</td>
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
    console.log(this.clients)
  }
}
</script>