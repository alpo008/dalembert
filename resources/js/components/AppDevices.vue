<template>
	<v-system-bar 
		color="transparent"
		style="
			height:50px;width: calc((100% - 10px) - 20px);
			top:104px;left:16px;"
		class="rounded"
	>
	    <v-btn
      icon="mdi-note-plus-outline"
      @click="modal = true"
      style="margin: 0 1%;"
      :title="$t('Create application key')"
      v-if="$auth.check('super')"
      >
    </v-btn>
	</v-system-bar>

  <v-data-table 
    :headers="devLogTableHeaders" 
    :items="allDevices" 
    item-key="id" 
    class="elevation-1 mt-14"
    v-if="showLog"
  >
	</v-data-table> 

  <v-data-table 
    :headers="appRegistrationsTableHeaders" 
    :items="allAppRegistrations" 
    item-key="id" 
    class="elevation-1 mt-14"
    v-if="!showLog"
  >
    <template v-slot:item.action="{ item }">
      <v-btn
        icon="mdi-delete-forever-outline"
        @click="deleteRegistration(item)"
        style="margin: 0 1%;"
        :title="$t('Delete')"
        v-if="$auth.check('super')"
      >
      </v-btn>
    </template>
  </v-data-table>

  <v-dialog
	  v-model="modal"
	  width="80vw"
  >
    <v-card
      elevation="4"
      rounded
    >
      <v-toolbar
        dark
        prominent
      >
        <v-toolbar-title>{{ $t('Create application key') }}</v-toolbar-title>

        <v-spacer></v-spacer>

        <v-btn icon @click="modal = false">
          <v-icon>mdi-close</v-icon>
        </v-btn>
      </v-toolbar>
      <v-card-text>
        <app-device-key-form/>
      </v-card-text>
    </v-card>
  </v-dialog>
  <widget-confirm ref="confirm_del"></widget-confirm>
</template>

<script>
  import AppDeviceKeyForm from './AppDeviceKeyForm';
	const isEmpty = obj => [Object, Array].includes((obj || {}).constructor) && !Object.entries((obj || {})).length;
  import WidgetConfirm from './widgets/WidgetConfirm.vue';
  import moment from "moment/dist/moment";
	export default {
		components: {
			AppDeviceKeyForm,
      WidgetConfirm
		},
		data: function () {
			return {
				modal: false,
        showLog: false,
				currentDevice: {},
        devLogTableHeaders: [
          {
            title: this.$t('Was active'),
            align: 'left',
            key: 'created_at',
            value: item => moment(item.created_at).format("DD.MM.YY HH:mm")
          },
          {
            title: this.$t('Customer'),
            align: 'center',
            key: 'customer',
            value: item =>   this.findOrFail(item, 'app_registrations.0.customer.name')
          },
          {
            title: this.$t('Model'),
            align: 'left',
            key: 'model',
            value: item => item.manufacturer + ' ' + item.model
          },
          {
            title: this.$t('Platform'),
            align: 'left',
            key: 'platform',
            value: item => item.platform + ' - ' + item.version
          },
          {
            title: this.$t('Action'),
            align: 'center',
            key: 'action'
          }
        ],
        appRegistrationsTableHeaders: [
          {
            title: this.$t('Client'),
            align: 'left',
            key: 'customer',
            value: item => item.customer?.name
          },
          {
            title: this.$t('Application'),
            align: 'center',
            key: 'app_id',
            value: item => this.applications[item.app_id]
          },
          {
            title: this.$t('Registered at'),
            align: 'center',
            key: 'updated_at',
            value: item => moment(item.updated_at).format("DD.MM.YY HH:mm")
          },
          {
            title: this.$t('Last active'),
            align: 'center',
            key: 'latest_log.updated_at',
            value: item => item.latest_log?.updated_at ? moment(item.latest_log?.updated_at).format("DD.MM.YY HH:mm") : '- - -'
          },
          {
            title: '',
            align: 'center',
            key: 'action'
          }
        ],
        applications: {
          1: 'Globus-meteo',
          2: 'Test'
        },
        modal: false
			}
		},
		async created() {
      await this.$store.dispatch('httpRequest', {
        url: '/device-log',
        method: 'GET',
        data: null,
        mutation: 'setDevices'
      });
      await this.$store.dispatch('httpRequest', {
        url: '/app-registration',
        method: 'GET',
        data: null,
        mutation: 'setAppRegistrations'
      });
		},
		methods: {
      findOrFail(obj, path) {
        if (isEmpty(obj) || !path.length) {
          return null;
        }
        let pathArr = path.split('.');
        for (let i=0; i < pathArr.length; i++ ) {
          if (typeof obj[pathArr[i]] === 'undefined') {
            return null;
          } else {
            obj = obj[pathArr[i]];
          }
        }
        return obj;      
      },
      deleteRegistration(dataTableItem) {
        if (!isNaN(dataTableItem.raw.id)) {
          this.$refs.confirm_del.open(this.$t('Deletion'), 
            this.$t('Are you sure?'), { color: '#ff0266' }).then((confirm) => {
            if(confirm) {
              this.$store.dispatch('httpRequest', {
                url: '/app-registration/' + dataTableItem.raw.id,
                method: 'DELETE',
                data: dataTableItem.raw,
                mutation: 'afterDeleteAppRegistration'
              });
            }
          });
        }
      }
		},
		computed: {
      allDevices() {
      	return this.$store.getters.allDevices;
      },
      allAppRegistrations() {
        return this.$store.getters.allAppRegistrations;
      },
			userId() {
				let user = this.$auth.user();
				return user?.id;
			}
		},
	  watch: {
		  "$store.state.sticker.current"() {
		  	this.modal = false;
		  }
		}
}
</script>