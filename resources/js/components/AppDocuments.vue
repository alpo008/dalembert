<template>
	<v-system-bar 
		color="transparent"
		style="height:50px;width: calc((100% - 10px) - 20px);top:160px;left:16px;"
		class="rounded"
	>
		<v-btn
			icon="mdi-note-plus-outline"
			@click="addDocument"
			style="margin: 0 1%;"
			>
		</v-btn>
	</v-system-bar>
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
        <app-media-upload-form/>
      </v-card-text>
    </v-card>
  </v-dialog>
</template>

<script>
	const isEmpty = obj => [Object, Array].includes((obj || {}).constructor) && !Object.entries((obj || {})).length;
	import AppMediaUploadForm from './AppMediaUploadForm';
	export default {
		components: {
			AppMediaUploadForm
		},
		props: {
			clientid: Number,
			objectname: String
		},
		data: function () {
			return {
				modal: false,
				attachmentData: {},
				uploaded: {}
			}
		},
		async created() {
	      await this.$store.dispatch('httpRequest', {
	        url: '/attachments/' + this.objectname + '/' + this.clientid,
	        method: 'GET',
	        data: null,
	        mutation: 'setAttachments'
	      });
	      //TODO
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
	        mutation: 'setUploaded'
	      });
	      this.errors = this.$store.getters.httpErrors;
	  		if (!isEmpty(this.errors)) {
		  		console.error(this.errors);
	  		} else {
		  		this.modal = false;
	  		}
      }
		},
	  watch: {
		  "$store.state.document.uploaded"() {
		  	if(!!this.$store.getters.uploadedFile.id) {
		  		this.attachmentData.media_id = this.$store.getters.uploadedFile.id;
		  		this.addAttachment();
		  	}
		  }
		}
}
</script>