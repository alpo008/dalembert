<template>
	<v-system-bar 
		color="transparent"
		style="height:50px;width: calc((100% - 10px) - 20px);top:160px;left:16px;"
		class="rounded"
	>
		<v-btn
			icon="mdi-note-plus-outline"
			@click="addPayment"
			style="margin: 0 1%;"
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
      <tr
        v-for="payment in allPayments"
        :key="payment.id"
      >
        <td class="pa-1">
          {{ payment.doi }}
      	</td>
        <td class="pa-1">{{ payment.amount }}</td>
        <td>{{ payment.destination }}</td>
        <td class="pa-1">
        	<v-btn density="compact" class="px-1" icon="mdi-paperclip" @click="viewMedia(payment)" v-if="hasMedia(payment)"></v-btn>
        </td>
        <td class="pa-1">
        	<v-btn density="compact" class="px-1" icon="mdi-delete-forever-outline" @click="deletePayment(payment)"></v-btn>
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
	      <v-toolbar-title>{{ $t('New payment') }}</v-toolbar-title>

	      <v-spacer></v-spacer>

	      <v-btn icon @click="modal = false">
	        <v-icon>mdi-close</v-icon>
	      </v-btn>
	    </v-toolbar>
      <v-card-text>
      	<app-payment-form :clientid="clientid" :objectname="objectname"></app-payment-form>
      </v-card-text>
    </v-card>
  </v-dialog>
  <widget-confirm ref="confirm_del"></widget-confirm>
</template>

<script>
	const isEmpty = obj => [Object, Array].includes((obj || {}).constructor) && !Object.entries((obj || {})).length;
  import WidgetConfirm from './widgets/WidgetConfirm.vue';
	import AppPaymentForm from './AppPaymentForm.vue';
	export default {
		components: {
			AppPaymentForm,
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
				allPayments: {},
				mediaContents: '',
				preview: false,
				mediaPreview: {}
			}
		},
		async created() {
	      await this.$store.dispatch('httpRequest', {
	        url: '/payments/' + this.objectname + '/' + this.clientid,
	        method: 'GET',
	        data: null,
	        mutation: 'setPayments'
	      });
	      this.allPayments = this.$store.getters.allPayments;
		},
		methods: {
      addPayment() {
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
		  		this.allPayments = this.$store.getters.allPayments;
	  		}
      },
      deletePayment(payment) {
        if (!isNaN(payment.id)) {
          this.$refs.confirm_del.open(this.$t('Deletion'), 
            this.$t('Are you sure?'), { color: '#ff0266' }).then((confirm) => {
            if(confirm) {
    		      this.$store.dispatch('httpRequest', {
				        url: '/payments/' + payment.id,
				        method: 'DELETE',
				        data: payment,
				        mutation: 'afterDeletePayment'
				      }).then(() => {this.allPayments = this.$store.getters.allPayments;});
            }
          });
        }
      },
      async viewMedia(payment) {
      	if (!isEmpty(payment.attachments) && !!payment.attachments[0]?.id) {
		      await this.$store.dispatch('httpRequest', {
		        url: '/attachments/download',
		        method: 'POST',
		        data: {id: payment.attachments[0].id},
		        mutation: 'setMediaContents'
		      });
  	      this.mediaContents = this.$store.getters.fileContents;
		      this.mediaPreview = payment.attachments[0].media;
		      this.mediaPreview.comments = payment.comments;
		      this.mediaPreview.destination = payment.destination;
	      	this.preview = true;
      	}
      },
      hasMedia(payment) {
      	return (!isEmpty(payment.attachments) && !!payment.attachments[0]?.id);	
      }
		},
		computed: {
		},
	  watch: {
		  "$store.state.payment.current"() {
		  	this.modal = false;
		  }
		}
}
</script>