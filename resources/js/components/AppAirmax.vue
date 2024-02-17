<template>
  <h2 class="pa-1 d-inline" style="margin-right: auto;max-width:fit-content;"> 
    {{ $t('Airmax clients') }} ( {{ filteredClients.length }} )
  </h2>
  <v-btn 
    density="compact" 
    icon="mdi-menu-open"
    style="position:fixed;top:113px;right:5px;"
    @click="showToolbar=true"
    :title="$t('Toolbar')"
  >
  </v-btn>
  <Transition name="slide-fade">
    <v-system-bar 
      style="height:50px;top:100px;padding: 0 2%;justify-content:center;width: calc((100% - 0px) - 0px);backdrop-filter: blur(10px);background-color:transparent"
      class="rounded"
      elevation="10"
      v-show="showToolbar"
    >
      <v-checkbox
        style="max-width:fit-content;"    
        v-model="activityFilter.active"
        color="success"
        hide-details
        :title="$t('Active')"
      >
      </v-checkbox> 
      <v-checkbox
        style="max-width:fit-content;"
        v-model="activityFilter.disabled"
        color="warning"
        hide-details
        :title="$t('Disabled')"
      >   
      </v-checkbox>
      <v-spacer></v-spacer>
      <v-btn
        icon="mdi-backup-restore"
        @click="exportSql"
        :title="$t('Backup')"
        v-if="$auth.check('super')"
        style="margin-left:5px;"
      >
      </v-btn>
      <v-menu location="bottom">
        <template v-slot:activator="{ props }">
          <v-btn
            icon="mdi-file-excel"
            v-bind="props"
            :title="$t('Export')"
            style="margin-left:5px;"
          >
          </v-btn>
        </template>
        <v-list>
          <v-list-item @click="exportExcel('all')">
            <v-list-item-title>{{ $t('All') }}</v-list-item-title>
          </v-list-item>
          <v-list-item @click="exportExcel('active')">
            <v-list-item-title>{{ $t('Active') }}</v-list-item-title>
          </v-list-item>
          <v-list-item @click="exportExcel('disabled')">
            <v-list-item-title>{{ $t('Disabled') }}</v-list-item-title>
          </v-list-item>
          <v-list-item @click="exportExcel('overdue')">
            <v-list-item-title>{{ $t('Debtors') }}</v-list-item-title>
          </v-list-item>
          <v-list-item @click="exportExcel('overdueButActive')">
            <v-list-item-title>{{ $t('Not blocked debtors') }}</v-list-item-title>
          </v-list-item>
          <v-list-item @click="exportExcel('remind')">
            <v-list-item-title>{{ $t('Reminders') }}</v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu>
      <v-btn
        icon="mdi-account-plus-outline"
        to="/airmax/new"
        :title="$t('New client')"
        style="margin-left:5px;"
      >
      </v-btn>
      <v-icon
        size="x-large"
        color="black"
        :title="$t('Hide')"
        icon="mdi-menu-right-outline"
        @click="showToolbar=false"
        style="left:10px;"
      ></v-icon>
    </v-system-bar>
  </Transition>
  <v-table
    fixed-header
    style="height:90%;width:90%;margin-top: 30px;"
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
          <v-chip variant="elevated" :to="'/airmax/'+client.place" :color="client.active? 'success' : 'warning'">
            {{ client.place }}
          </v-chip>
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
        },
        showToolbar: true
      }
    },
    async created() {
      this.$store.commit('setCurrentClient', {'current' : {}});
      await this.$store.dispatch('updateAirmaxClients');
      this.clients = this.$store.getters.airmaxClients;
      this.errors = this.$store.getters.httpErrors;
    },
    methods: {
      exportExcel(keyword) {
        axios.get('export/airmax', {responseType: 'blob', params: {keyword}}).then((response) => {
          FileSaver.saveAs(response.data, 'airmax-clients.xlsx');
        }).catch((error) => {
          let message = error.message ?? this.$t('Could not Download the Excel report');
          this.$store.commit('setHttpErrors', message);
        });
      },
      exportSql() {
        axios.get('export/backup', {responseType: 'blob'}).then((response) => {
          FileSaver.saveAs(response.data, 'backup.sql');
        }).catch((error) => {
          let message = error.message ?? this.$t('Could not Download the Excel report');
          this.$store.commit('setHttpErrors', message);
        });
      }
    },
    computed: {
      filteredClients() {
        const searchString = this.$store.getters.searchKey.toLowerCase();
        return this.clients.filter(client => {
            let activityCriteria = client.active&this.activityFilter.active || 
                                   !client.active&this.activityFilter.disabled;
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

<style scoped>
  .slide-fade-enter-active {
    transition: all 0.2s ease-out;
  }

  .slide-fade-leave-active {
    transition: all 0.3s cubic-bezier(1, 0.5, 0.8, 1);
  }

  .slide-fade-enter-from,
  .slide-fade-leave-to {
    transform: translateX(20px);
    opacity: 0;
  }
.bounce-enter-active {
  animation: bounce-in 0.5s;
}
.bounce-leave-active {
  animation: bounce-in 0.5s reverse;
}
@keyframes bounce-in {
  0% {
    transform: scale(0);
  }
  50% {
    transform: scale(1.25);
  }
  100% {
    transform: scale(1);
  }
}
</style>