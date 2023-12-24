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
        <v-card>
          <v-card-text>
            <app-media-upload-form/>
          </v-card-text>
          <v-card-actions>
            <v-btn color="primary" block @click="modal = false">{{ $t('Close') }}</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
</template>

<script>
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
				attachmentData: {}
			}
		},
		methods: {
	      addDocument() {
	      	this.attachmentData.object = this.objectname;
	      	this.attachmentData.object_id = this.clientid;
	        this.modal = true;
	      }
		}
}
</script>