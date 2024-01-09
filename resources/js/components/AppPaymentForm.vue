<template>
  <v-text-field 
    type="date"
    :label="$t('Date of issue')"
    v-model="paymentData.doi"
    :error-messages="errors.doi"
  >           
  </v-text-field>
  <v-text-field 
    type="number"
    :label="$t('Amount')"
    v-model="paymentData.amount"
    :error-messages="errors.amount"
  >           
  </v-text-field>
  <v-select
    :label="$t('Destination')"
    v-model="paymentData.destination"
    :error-messages="errors.destination"
    :items="enabledDestinations"
  >    
  </v-select>        
  <v-textarea 
    :label="$t('Comments')"
    v-model="paymentData.comments"
    :error-messages="errors.comments"
  >   
  </v-textarea>
  <v-file-input 
    :label="$t('File')" 
    @change="uploadFile"
    show-size
    ref="file"
    :error-messages="errors.file"
  ></v-file-input>
  <v-btn @click="save">{{ $t('Save') }}</v-btn>
</template>

<script>
const isEmpty = obj => [Object, Array].includes((obj || {}).constructor) && !Object.entries((obj || {})).length;
export default {
  props: {
    clientid: Number,
    objectname: String
  },
  data: function () {
    return {
      file: null,
      paymentData: {
        amount: 0.00,
        doi: new Date().toISOString().slice(0,10),
        comments: '',
        destination: null,
        payer_type: this.objectname,
        payer_id: this.clientid,
      },
      enabledDestinations: [],
      errors: {},
      attachmentErrors: {}
    }
  },
  mounted() {
    const enabledPaymentsDestinations = `${process.env.MIX_ENABLED_PAYMENTS_DESTINATIONS}`;
    let enabledDestinations = JSON.parse(enabledPaymentsDestinations);
    this.enabledDestinations = enabledDestinations.map(i => this.$t(i));
  },
  methods: {
    uploadFile() {
      this.file = this.$refs.file.files[0];
    },
    async save() {
      const formData = new FormData();
      formData.append('file', this.file);
      formData.append('amount', this.paymentData.amount);
      formData.append('doi', this.paymentData.doi);
      formData.append('payer_type', this.paymentData.payer_type);
      formData.append('payer_id', this.paymentData.payer_id);
      formData.append('comments', this.paymentData.comments);
      formData.append('destination', this.paymentData.destination);
      await this.$store.dispatch('httpRequest', {
        url: '/payments',
        method: 'POST',
        data: formData,
        mutation: 'setCurrentPayment'
      });
      this.errors = this.$store.getters.httpErrors;
    }
  }
}
</script>