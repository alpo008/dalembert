<template>
  <h1> {{ $t('Statistics') }}</h1>
  <v-expansion-panels style="margin-top:30px;" v-if="isReady">
    <v-expansion-panel v-if="haveAirmaxStatistics('overdue')">
      <v-expansion-panel-title>
        {{ $t('Airmax overdue clients') }} ( {{ getAirmaxStatistics('overdue').length }} )
      </v-expansion-panel-title>
      <v-expansion-panel-text>
        <v-data-table
          :headers="airmaxTablesHeaders"
          :items="getAirmaxStatistics('overdue')"
          :items-per-page-text="$t('Items per page')"
        >
        <template v-slot:item.place="{ item }">
          <v-btn 
            density="compact" :to="'/airmax/'+ getAirmaxClient(item, 'place')" 
            :prepend-icon="getAirmaxClient(item, 'active')? 'mdi-check-circle' : 'mdi-close-circle'"
          >
          <template v-slot:prepend>
            <v-icon :color="getAirmaxClient(item, 'active')? 'success' : 'error'"></v-icon>
          </template>
            {{ getAirmaxClient(item, 'place') }}
          </v-btn>
        </template>
        </v-data-table>
      </v-expansion-panel-text>
    </v-expansion-panel>
    <v-expansion-panel v-if="haveAirmaxStatistics('overdueButActive')">
      <v-expansion-panel-title>
        {{ $t('Airmax overdue unblocked clients') }} ( {{ getAirmaxStatistics('overdueButActive').length }} )
      </v-expansion-panel-title>
      <v-expansion-panel-text>
        <v-data-table
          :headers="airmaxTablesHeaders"
          :items="getAirmaxStatistics('overdueButActive')"
          :items-per-page-text="$t('Items per page')"
        >
        <template v-slot:item.place="{ item }">
          <v-btn 
            density="compact" :to="'/airmax/'+ getAirmaxClient(item, 'place')" 
            :prepend-icon="getAirmaxClient(item, 'active')? 'mdi-check-circle' : 'mdi-close-circle'"
          >
          <template v-slot:prepend>
            <v-icon :color="getAirmaxClient(item, 'active')? 'success' : 'error'"></v-icon>
          </template>
            {{ getAirmaxClient(item, 'place') }}
          </v-btn>
        </template>
        </v-data-table>
      </v-expansion-panel-text>
    </v-expansion-panel>
    <v-expansion-panel v-if="haveAirmaxStatistics('disabled')">
      <v-expansion-panel-title>
        {{ $t('Airmax blocked clients') }} ( {{ getAirmaxStatistics('disabled').length }} )
      </v-expansion-panel-title>
      <v-expansion-panel-text>
        <v-data-table
          :headers="airmaxTablesHeaders"
          :items="getAirmaxStatistics('disabled')"
          :items-per-page-text="$t('Items per page')"
        >
        <template v-slot:item.place="{ item }">
          <v-btn 
            density="compact" :to="'/airmax/'+ getAirmaxClient(item, 'place')" 
            :prepend-icon="getAirmaxClient(item, 'active')? 'mdi-check-circle' : 'mdi-close-circle'"
          >
          <template v-slot:prepend>
            <v-icon :color="getAirmaxClient(item, 'active')? 'success' : 'error'"></v-icon>
          </template>
            {{ getAirmaxClient(item, 'place') }}
          </v-btn>
        </template>
        </v-data-table>
      </v-expansion-panel-text>
    </v-expansion-panel>
    <v-expansion-panel v-if="haveAirmaxStatistics('remind')">
      <v-expansion-panel-title>
        {{ $t('Reminders') }} ( {{ getAirmaxStatistics('remind').length }} )
      </v-expansion-panel-title>
      <v-expansion-panel-text>
        <v-data-table
          :headers="airmaxTablesHeaders"
          :items="getAirmaxStatistics('remind')"
          :items-per-page-text="$t('Items per page')"
        >
        <template v-slot:item.place="{ item }">
          <v-btn 
            density="compact" :to="'/airmax/'+ getAirmaxClient(item, 'place')" 
            :prepend-icon="getAirmaxClient(item, 'active')? 'mdi-check-circle' : 'mdi-close-circle'"
          >
          <template v-slot:prepend>
            <v-icon :color="getAirmaxClient(item, 'active')? 'success' : 'error'"></v-icon>
          </template>
            {{ getAirmaxClient(item, 'place') }}
          </v-btn>
        </template>
        </v-data-table>
      </v-expansion-panel-text>
    </v-expansion-panel>
  </v-expansion-panels>
</template>
<script>
const isEmpty = obj => [Object, Array].includes((obj || {}).constructor) && !Object.entries((obj || {})).length;
export default {
  components: {
  },
  data: function () {
    return {
      statistics: {},
    }
  },
  async created() {
    await this.$store.dispatch('httpRequest', {
      url: '/airmax-clients/statistics',
      method: 'POST',
      data: null,
      mutation: 'setStatistics'
    });
    this.statistics = this.$store.getters.allStatistics;
  },
  methods: {
    getAirmaxClient(value, param) {
      return value.raw[param];
    },
    haveAirmaxStatistics(key) {
      return !isEmpty(this.statistics?.airmax[key]);
    },
    getAirmaxStatistics(key) {
      const result = [];
      if (!isEmpty(this.statistics?.airmax[key])) {
        const searchString = this.$store.getters.searchKey.toLowerCase();
        this.statistics.airmax[key].forEach(client => {
          if ((!!client.name && client.name.toLowerCase().indexOf(searchString) !== -1) ||
            (!!client.place && client.place.toLowerCase().indexOf(searchString) !== -1) ||
            (!!client.ip_address && client.ip_address.indexOf(searchString) !== -1)) {
              result.push({
                id: client.id, 
                place: client.place, 
                name: client.name,
                ip_address: client.ip_address,
                active: client.active,
                title: client.place
              });
            }
        });
      }
      return result;
    },
  },
  computed: {
    airmaxTablesHeaders() {
      return [
        {
          title: this.$t('Place'),
          align: 'left',
          key: 'place',
        },
        {
          title: this.$t('Name'),
          align: 'left',
          key: 'name',
        },
        {
          title: this.$t('Bridge IP'),
          align: 'left',
          key: 'ip_address',
        },
      ];
    },
    isReady() {
      return !isEmpty(this.statistics?.airmax);
    }
  }
}

</script>