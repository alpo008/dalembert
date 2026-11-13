<template>
  <v-data-table 
    :headers="tableHeaders" 
    :items="allHydrometry" 
    item-key="id" 
    class="elevation-1"
    :class="currentHydrometry?.id === '' ? 'has-new-item' : ''"
    v-model:sort-by="tableSortBy"
    v-model:items-per-page="tableItemsPerPage"
  >
    <template v-slot:item.level_local="{ item }">
      <v-text-field
        v-if="item.raw.id === tableItemEditable"
        v-model="item.raw.level_local"
        density="compact"
        hide-details
      ></v-text-field>
      <span v-else>{{ item.raw.level_local }}</span>
    </template>
    <template v-slot:item.temp_local="{ item }">
      <v-text-field
        v-if="item.raw.id === tableItemEditable"
        v-model="item.raw.temp_local"
        density="compact"
        hide-details
      ></v-text-field>
      <span v-else>{{ item.raw.temp_local }}</span>
    </template>
    <template v-slot:item.ice_thickness_local="{ item }">
      <v-text-field
        v-if="item.raw.id === tableItemEditable"
        v-model="item.raw.ice_thickness_local"
        density="compact"
        hide-details
      ></v-text-field>
      <span v-else>{{ item.raw.ice_thickness_local }}</span>
    </template>
    <template v-slot:item.turbulence="{ item }">
      <v-text-field
        v-if="item.raw.id === tableItemEditable"
        v-model="item.raw.turbulence"
        density="compact"
        hide-details
      ></v-text-field>
      <span v-else>{{ item.raw.turbulence }}</span>
    </template>
    <template v-slot:item.action="{ item }">
      <v-btn
        :icon="item.raw.id !== tableItemEditable ? 'mdi-square-edit-outline' : 'mdi-pencil-off-outline'"
        @click="editHydro(item)"
        style="margin: 0 1%;"
        :title="$t('Edit')"
        v-if="$auth.check('super')"
      >
      </v-btn>
      <v-btn
        icon="mdi-content-save-outline"
        @click="saveHydro(item)"
        style="margin: 0 1%;"
        :title="$t('Save')"
        v-if="$auth.check('super') && item.raw.id === tableItemEditable"
      >
      </v-btn>
      <v-btn
        icon="mdi-delete-forever-outline"
        @click="deleteHydro(item)"
        style="margin: 0 1%;"
        :title="$t('Delete')"
        v-if="$auth.check('super') && item.raw.id === tableItemEditable && item.raw.id !== ''"
      >
      </v-btn>
    </template>
  </v-data-table>
  <widget-confirm ref="confirm_del"></widget-confirm>

</template>
<script>
  import WidgetConfirm from './widgets/WidgetConfirm.vue';
  import moment from "moment/dist/moment";
  const isEmpty = obj => [Object, Array].includes((obj || {}).constructor) && !Object.entries((obj || {})).length;
  export default {
    components: {
      WidgetConfirm
    },
    data: function () {
      return {
        currentHydrometry: {},
        tableHeaders: [
          {
            title: this.$t('Date'),
            align: 'left',
            key: 'created_at',
            value: item => moment(item.created_at).format("DD.MM.YY")
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
        ],
        tableSortBy: [{ key: 'created_at', order:'desc'}],
        tableItemsPerPage: 25,
        tableItemEditable: '',
      }
    },
    async created() {
      await this.$store.dispatch('httpRequest', {
        url: '/hydrometry',
        method: 'GET',
        data: null,
        mutation: 'setHydrometry'
      });
    },
    methods: {
      editHydro(tableItem) {
        if(this.tableItemEditable === tableItem.raw.id) {
          this.tableItemEditable = '';
        } else {
          this.tableItemEditable = tableItem.raw.id;
        }
      },
      async saveHydro(tableItem) {
        let id = tableItem?.raw?.id;
        let method = id ? 'PUT' : 'POST';
        let url = id ? '/hydrometry/' + id : '/hydrometry';
        await this.$store.dispatch('httpRequest', {
          url: url,
          method: method,
          data: tableItem.raw,
          mutation: 'setHydrometry'
        });
        this.errors = this.$store.getters.httpErrors;
      },
      deleteHydro(tableItem) {
        if (!isNaN(tableItem.raw.id)) {
          this.$refs.confirm_del.open(this.$t('Deletion'), 
            this.$t('Are you sure?'), { color: '#ff0266' }).then((confirm) => {
            if(confirm) {
              this.$store.dispatch('httpRequest', {
                url: '/hydrometry/' + tableItem.raw.id,
                method: 'DELETE',
                data: tableItem.raw,
                mutation: 'afterDeleteHydrometry'
              });
            }
          });
        }
      }
    },
    computed: {
      allHydrometry() {
        let all = this.$store.getters.allHydrometry;
        this.currentHydrometry = this.$store.getters.currentHydrometry;
        if(this.currentHydrometry?.id === '') {
          all.push(this.currentHydrometry);
        }
        return all;
      }
    }
  }
</script>
<style scoped>
    .has-new-item tbody {
      color: blue!important;
    }
    .has-new-item tbody tr:first-child {
      color: red!important;
    }
</style>