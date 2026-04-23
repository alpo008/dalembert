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

  <v-data-table :headers="tableHeaders" :items="allDevices" item-key="id" class="elevation-1 mt-14">
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
</template>

<script>
  import AppDeviceKeyForm from './AppDeviceKeyForm';
	const isEmpty = obj => [Object, Array].includes((obj || {}).constructor) && !Object.entries((obj || {})).length;
  import moment from "moment/dist/moment";
	export default {
		components: {
			AppDeviceKeyForm
		},
		data: function () {
			return {
				modal: false,
				currentDevice: {},
        tableHeaders: [
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
      }
		},
		computed: {
      allDevices() {
      	return this.$store.getters.allDevices;
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