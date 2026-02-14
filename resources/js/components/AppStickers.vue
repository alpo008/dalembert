<template>
	<v-system-bar 
		color="transparent"
		style="height:50px;width: calc((100% - 10px) - 20px);top:104px;left:16px;"
		class="rounded"
	>
		<v-btn
			icon="mdi-note-plus-outline"
			@click="addSticker"
			style="margin: 0 1%;"
			:title="$t('Add sticker')"
			v-if="$auth.check(['admin', 'super'])"
		>
		</v-btn>
	</v-system-bar>

  <v-data-table :headers="tableHeaders" :items="allStickers" item-key="id" class="elevation-1">
    <template v-slot:item.action="{ item }">
      <v-btn
        icon="mdi-image-outline"
        @click="viewMedia(item.raw)"
        style="margin: 0 1%;"
        :title="$t('View')"
        v-if="$auth.check('super')  && hasMedia(item.raw)"
      >
      </v-btn>
      <v-btn
        icon="mdi-square-edit-outline"
        @click="editSticker(item)"
        style="margin: 0 1%;"
        :title="$t('Edit')"
        v-if="$auth.check('super')"
      >
      </v-btn>
      <v-btn
        icon="mdi-delete-forever-outline"
        @click="deleteSticker(item)"
        style="margin: 0 1%;"
        :title="$t('Delete')"
        v-if="$auth.check('super')"
      >
      </v-btn>
    </template>
</v-data-table>

<v-dialog eager v-model="preview" style="width:60vw;">
  <v-card style="min-height:90vh" id="media-preview">
    <v-toolbar
      dark
      prominent
    >
      <v-btn icon @click="preview = false" style="position:absolute;right:0">
        <v-icon>mdi-close</v-icon>
      </v-btn>
    </v-toolbar>
    <iframe 
    	:src="mediaContents" 
    	frameborder="0" 
    	style="min-height:80vh; text-align:center; padding: 0.5rem 1rem;" 
    	allowfullscreen
    	v-if="mediaPreview.mime_type==='application/pdf'"
    	>	    		
  	</iframe>
  	<img
  		:src="mediaContents" 
  		v-else
  		style="width: 55vw;"
  	/>
  </v-card>
</v-dialog>
  
  <v-dialog
    v-model="modal"
    width="90%"
  >
    <v-card
	    elevation="4"
	    rounded
    >
	    <v-toolbar
	      dark
	      prominent
	    >
	      <v-toolbar-title>{{ $t('New sticker') }}</v-toolbar-title>

	      <v-spacer></v-spacer>

	      <v-btn icon @click="modal = false">
	        <v-icon>mdi-close</v-icon>
	      </v-btn>
	    </v-toolbar>
      <v-card-text>
      	<app-sticker-form :sticker="currentSticker"></app-sticker-form>
      </v-card-text>
    </v-card>
  </v-dialog>
  <widget-confirm ref="confirm_del"></widget-confirm>
</template>

<script>
	const isEmpty = obj => [Object, Array].includes((obj || {}).constructor) && !Object.entries((obj || {})).length;
  import WidgetConfirm from './widgets/WidgetConfirm.vue';
	import AppStickerForm from './AppStickerForm.vue';
	export default {
		components: {
			AppStickerForm,
			WidgetConfirm
		},
		data: function () {
			return {
				modal: false,
				attachmentData: {},
				currentSticker: {},
				mediaContents: '',
				preview: false,
				mediaPreview: {},
        tableHeaders: [
          {
            title: this.$t('Date of issue'),
            align: 'left',
            key: 'doi'
          },
          {
            title: this.$t('Date of expire'),
            align: 'left',
            key: 'valid_until'
          },
          {
            title: this.$t('Publisher'),
            align: 'center',
            key: 'contact_name'
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
	        url: '/stickers',
	        method: 'GET',
	        data: null,
	        mutation: 'setStickers'
	      });
		},
		methods: {
      addSticker() {
      	this.currentSticker = {
	        message: '',
	        doi: new Date().toISOString().slice(0,10),
	        valid_until: new Date().toISOString().slice(0,10),
	        contact_name: '',
	        contact_phone: '',
	        contact_email: '',
	        priority: 3,
	      }
        this.modal = true;
      },
      editSticker(dataTableItem) {
        this.currentSticker = dataTableItem.raw;
        this.modal = true;
      },
      deleteSticker(dataTableItem) {
      	if (!isNaN(dataTableItem.raw.id)) {
      	  this.$refs.confirm_del.open(this.$t('Deletion'), 
      	    this.$t('Are you sure?'), { color: '#ff0266' }).then((confirm) => {
      	    if(confirm) {
      	      this.$store.dispatch('httpRequest', {
      	        url: '/stickers/' + dataTableItem.raw.id,
      	        method: 'DELETE',
      	        data: dataTableItem.raw,
      	        mutation: 'afterDeleteSticker'
      	      });
      	    }
      	  });
      	}
      },
      async viewMedia(sticker) {
      	if (!isEmpty(sticker.attachments) && !!sticker.attachments[0]?.id) {
		      await this.$store.dispatch('httpRequest', {
		        url: '/attachments/download',
		        method: 'POST',
		        data: {id: sticker.attachments[0].id},
		        mutation: 'setMediaContents'
		      });
  	      this.mediaContents = this.$store.getters.fileContents;
		      this.mediaPreview = sticker.attachments[0].media;
	      	this.preview = true;
      	}
      },
      hasMedia(sticker) {
      	return (!isEmpty(sticker.attachments) && !!sticker.attachments[0]?.id);	
      },
      formatDate(date) {
      	let parts = date.split('-');
      	return parts[2] + '.' + parts[1] + '.' + parts[0];
      }
		},
		computed: {
      allStickers() {
        return this.$store.getters.allStickers;
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