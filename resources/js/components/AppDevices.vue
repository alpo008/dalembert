<template>
	<v-system-bar 
		color="transparent"
		style="
			height:50px;width: calc((100% - 10px) - 20px);
			top:104px;left:16px;
			justify-content:space-between;"
		class="rounded"
	>
<!--     <v-checkbox
      style="max-width:fit-content;margin-right:30px;"    
      v-model="activityFilter"
      color="success"
      hide-details
      :label="$t('Active only')"
    >
    </v-checkbox>
		<v-btn
			icon="mdi-note-plus-outline"
			@click="addDevice"
			style="margin: 0 1%;"
			:title="$t('Add sticker')"
			v-if="$auth.check(['admin', 'super'])"
		>
		</v-btn> -->
	</v-system-bar>

  <v-data-table :headers="tableHeaders" :items="allDevices" item-key="id" class="elevation-1 mt-14">
	</v-data-table>
</template>

<script>
	const isEmpty = obj => [Object, Array].includes((obj || {}).constructor) && !Object.entries((obj || {})).length;
  import moment from "moment/dist/moment";
	export default {
		components: {
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
            title: this.$t('Model'),
            align: 'left',
            key: 'model'
          },
          {
            title: this.$t('Platform'),
            align: 'left',
            key: 'platform'
          },
          {
            title: this.$t('Version'),
            align: 'center',
            key: 'version'
          },
          {
            title: this.$t('Manufacturer'),
            align: 'center',
            key: 'manufacturer'
          },
          {
            title: '',
            align: 'center',
            key: 'action'
          }
        ],
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
			test(i) {
				console.log(i)
				return 'Test'
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