<template>
    <v-data-table :headers="tableHeaders" :items="allHydrometry" item-key="id" class="elevation-1">
    <template v-slot:item.action="{ item }">
      <v-btn
        icon="mdi-square-edit-outline"
        @click="editHydro(item)"
        style="margin: 0 1%;"
        :title="$t('Edit')"
        v-if="$auth.check('super')"
      >
      </v-btn>
      <v-btn
        icon="mdi-delete-forever-outline"
        @click="deleteHydro(item)"
        style="margin: 0 1%;"
        :title="$t('Delete')"
        v-if="$auth.check('super')"
      >
      </v-btn>
    </template>
  </v-data-table>

</template>
<script>
  const isEmpty = obj => [Object, Array].includes((obj || {}).constructor) && !Object.entries((obj || {})).length;
  export default {
    data: function () {
      return {
        allHydrometry: [],
        tableHeaders: [
          {
            title: this.$t('Date'),
            align: 'left',
            key: 'created_at'
          },
          {
            title: this.$t('Level Ivankovo head'),
            align: 'left',
            key: 'level_headwater_iv'
          },
          {
            title: this.$t('Level local'),
            align: 'left',
            key: 'level_local'
          },
          {
            title: this.$t('Temperature external'),
            align: 'left',
            key: 'temp_ext'
          },
          {
            title: this.$t('Temperature measured'),
            align: 'left',
            key: 'temp_local'
          },
          {
            title: this.$t('Ice thickness'),
            align: 'left',
            key: 'ice_thickness_local'
          },
          {
            title: this.$t('Turbulence'),
            align: 'left',
            key: 'turbulence'
          },
          {
            title: '',
            align: 'center',
            key: 'action'
          }
        ]
      }
    },
    async created() {
      await this.$store.dispatch('httpRequest', {
        url: '/hydrometry',
        method: 'GET',
        data: null,
        mutation: 'setHydrometry'
      });
      this.allHydrometry = this.$store.getters.allHydrometry;
    },
    methods: {
      editHydro(row) {

      },
      deleteHydro(row) {

      }
    },
    computed: {
    }
  }
</script>
<style scoped>
    .blur {
      backdrop-filter: blur(10px);
    }
</style>