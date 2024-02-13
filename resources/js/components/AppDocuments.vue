<template>
	<v-system-bar 
		color="transparent"
    style="height:50px;width:auto;top:160px;right:20px;left:auto;padding: 0 2%;justify-content:center;"
		class="rounded"
	>
		<v-btn
			icon="mdi-note-plus-outline"
			@click="addDocument"
			style="margin: 0 1%;"
			:title="$t('Add document')"
			v-if="$auth.check(['admin', 'super'])"
			>
		</v-btn>
	</v-system-bar>

  <v-table v-if="hasAttachments">
    <thead>
      <tr>
        <th class="text-left pa-1 text-break">
          {{ $t('Document name') }}
        </th>
        <th class="text-left pa-1 text-break">
          {{ $t('Date of issue') }}
        </th>
        <th></th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <tr
        v-for="attachment in allAttachments"
        :key="attachment.id"
      >
        <td class="pa-1">{{ attachment.media.name }}</td>
        <td class="pa-1">{{ formatDate(attachment.media.doi, 'D.M.YYYY') }}</td>
        <td class="pa-1">
        	<v-btn 
        	v-if="hasMedia(attachment)"
        		density="compact" 
        		:icon="attachment.media.mime_type === 'text/plain' ? 'mdi-download' : 'mdi-eye-outline'" 
        		:title="attachment.media.mime_type === 'text/plain' ? $t('Download') : $t('View')" 
        		@click="viewOrDownloadMedia(attachment)"
      		>
      		</v-btn>
        </td>
        <td class="pa-1">
        	<v-btn 
        		density="compact" 
        		icon="mdi-delete-forever-outline" 
        		@click="deleteAttachment(attachment)"
        		:title="$t('Delete')" 
        		v-if="canDelete(attachment)"
      		>
      		</v-btn>
        </td>
      </tr>
    </tbody>
  </v-table>
  <v-dialog eager v-model="preview">
	  <v-card style="min-height:90vh" id="media-preview">
	    <v-toolbar
	      dark
	      prominent
	    >
	      <v-toolbar-title>{{ mediaPreview.name }} ( {{ mediaPreview.collection }} )</v-toolbar-title>

	      <v-spacer></v-spacer>

	      <v-btn icon @click="preview = false">
	        <v-icon>mdi-close</v-icon>
	      </v-btn>
	    </v-toolbar>
	    <v-card-text> {{ mediaPreview.description }} </v-card-text>
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
    		style="width: 100vw;"
    	/>
    	<img
    		:src="mediaContents" 
    		v-else
    		style="width: 100vw;"
    	/>
	  </v-card>
	</v-dialog>
  
  <v-dialog
    v-model="modal"
    width="auto"
  >
    <v-card
	    elevation="4"
	    rounded
    >
	    <v-toolbar
	      dark
	      prominent
	    >
	      <v-toolbar-title>{{ $t('Uploads page') }}</v-toolbar-title>

	      <v-spacer></v-spacer>

	      <v-btn icon @click="modal = false">
	        <v-icon>mdi-close</v-icon>
	      </v-btn>
	    </v-toolbar>
      <v-card-text>
        <app-media-upload-form :clientid="clientid" :objectname="objectname"/>
      </v-card-text>
    </v-card>
  </v-dialog>
  <widget-confirm ref="confirm_del"></widget-confirm>
</template>

<script>
  const FileSaver = require('file-saver');
	const isEmpty = obj => [Object, Array].includes((obj || {}).constructor) && !Object.entries((obj || {})).length;
  import WidgetConfirm from './widgets/WidgetConfirm.vue';
	import AppMediaUploadForm from './AppMediaUploadForm';
	export default {
		components: {
			AppMediaUploadForm,
			WidgetConfirm
		},
		props: {
			clientid: Number,
			objectname: String
		},
		data: function () {
			return {
				modal: false,
				attachmentData: {},
				allAttachments: {},
				mediaContents: '',
				preview: false,
				mediaPreview: {}
			}
		},
		async created() {
	      await this.$store.dispatch('httpRequest', {
	        url: '/attachments/' + this.objectname + '/' + this.clientid,
	        method: 'GET',
	        data: null,
	        mutation: 'setAttachments'
	      });
	      this.allAttachments = this.$store.getters.allAttachments;
		},
		methods: {
      addDocument() {
      	this.attachmentData.object = this.objectname;
      	this.attachmentData.object_id = this.clientid;
      	this.$store.commit('setUploaded', {});
        this.modal = true;
      },
      async addAttachment() {
	      await this.$store.dispatch('httpRequest', {
	        url: '/attachments',
	        method: 'POST',
	        data: this.attachmentData,
	        mutation: 'setCurrentDocument'
	      });
	      this.errors = this.$store.getters.httpErrors;
	  		if (!isEmpty(this.errors)) {
		  		console.error(this.errors);
	  		} else {
		  		this.modal = false;
		  		this.allAttachments = this.$store.getters.allAttachments;
	  		}
      },
      canDelete(attachment) {
      	let id = this.userId;
      	console.log(attachment.media?.uploaded_by)
      	return ((id === attachment.media?.uploaded_by) || this.$auth.check('super'));
      },
      deleteAttachment(attachment) {
        if (!isNaN(attachment.id)) {
          this.$refs.confirm_del.open(this.$t('Deletion'), 
            this.$t('Are you sure?'), { color: '#ff0266' }).then((confirm) => {
            if(confirm) {
    		      this.$store.dispatch('httpRequest', {
				        url: '/attachments/' + attachment.id,
				        method: 'DELETE',
				        data: attachment,
				        mutation: 'afterDeleteAttachment'
				      }).then(() => {this.allAttachments = this.$store.getters.allAttachments;});
            }
          });
        }
      },
      async viewOrDownloadMedia(attachment) {
	      await this.$store.dispatch('httpRequest', {
	        url: '/attachments/download',
	        method: 'POST',
	        data: {id: attachment.id},
	        mutation: 'setMediaContents'
	      });
	      this.mediaContents = this.$store.getters.fileContents;
	      this.mediaPreview = attachment.media;
	      if(attachment.media.mime_type === 'text/plain') {
	      	FileSaver.saveAs(this.mediaContents, this.mediaPreview.file_name.replace('.txt', ''));
	      } else {
	      	this.preview = true;
	      }   	
      },
			hasMedia(attachment) {
				return !isEmpty(attachment.media);
			},
      formatDate(date) {
      	let parts = date.split('-');
      	return parts[2] + '.' + parts[1] + '.' + parts[0];
      }
		},
		computed: {
			hasAttachments() {
				return !isEmpty(this.allAttachments);
			},
			userId() {
				let user = this.$auth.user();
				return user?.id;
			}
		},
	  watch: {
		  "$store.state.document.current"() {
		  	this.modal = false;
		  }
		}
}
</script>