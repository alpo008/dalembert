<template>
	<v-system-bar 
		color="transparent"
		style="height:50px;width: calc((100% - 10px) - 20px);top:160px;left:16px;"
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

  <v-table v-if="true">
    <thead>
      <tr>
        <th class="text-left pa-1 text-break">
          {{ $t('Date') }}
        </th>
        <th class="text-left pa-1 text-break">
          {{ $t('Amount') }}
        </th>
        <th class="text-left pa-1 text-break">
          {{ $t('Destination') }}
        </th>
        <th></th>
        <th></th>
      </tr>
    </thead>
    <tbody>
<!--       <tr
        v-for="sticker in allStickers"
        :key="sticker.id"
      >
        <td class="pa-1">
          {{ formatDate(sticker.doi, 'D.M.YYYY') }}
      	</td>
        <td class="pa-1">{{ sticker.amount }}</td>
        <td>{{ sticker.destination }}</td>
        <td class="pa-1">
        	<v-btn density="compact" class="px-1" icon="mdi-eye-outline" @click="viewMedia(sticker)" v-if="hasMedia(sticker)"></v-btn>
        </td>
        <td class="pa-1">
        	<v-btn 
        		density="compact" 
        		class="px-1" 
        		icon="mdi-delete-forever-outline" 
        		@click="deleteSticker(sticker)"
						v-if="canDelete(sticker)"       		
      		>      			
      		</v-btn>
        </td>
      </tr> -->
    </tbody>
  </v-table>
<!--   <v-dialog eager v-model="preview" style="width:60vw;">
	  <v-card style="min-height:90vh" id="media-preview">
	    <v-toolbar
	      dark
	      prominent
	    >
	      <v-toolbar-title>{{ mediaPreview.doi }} ( {{ mediaPreview.destination }} )</v-toolbar-title>

	      <v-spacer></v-spacer>

	      <v-btn icon @click="preview = false">
	        <v-icon>mdi-close</v-icon>
	      </v-btn>
	    </v-toolbar>
	    <v-card-text> {{ mediaPreview.comments }} </v-card-text>
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
	</v-dialog> -->
  
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
      	<app-sticker-form></app-sticker-form>
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
				allStickers: {},
				mediaContents: '',
				preview: false,
				mediaPreview: {}
			}
		},
		async created() {
	      await this.$store.dispatch('httpRequest', {
	        url: '/stickers',
	        method: 'GET',
	        data: null,
	        mutation: 'setStickers'
	      });
	      this.allStickers = this.$store.getters.allStickers;
		},
		methods: {
      addSticker() {
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
		  		this.allStickers = this.$store.getters.allStickers;
	  		}
      },
      canDelete(sticker) {
      	let id = this.userId;
      	return ((id === sticker.created_by) || this.$auth.check('super'));
      },
      deleteSticker(sticker) {
        if (!isNaN(sticker.id)) {
          this.$refs.confirm_del.open(this.$t('Deletion'), 
            this.$t('Are you sure?'), { color: '#ff0266' }).then((confirm) => {
            if(confirm) {
    		      this.$store.dispatch('httpRequest', {
				        url: '/stickers/' + sticker.id,
				        method: 'DELETE',
				        data: sticker,
				        mutation: 'afterDeleteSticker'
				      }).then(() => {this.allStickers = this.$store.getters.allStickers;});
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
		      this.mediaPreview.comments = sticker.comments;
		      this.mediaPreview.destination = sticker.destination;
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