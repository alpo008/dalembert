<template>  
   <v-select
    :label="$t('Customer')"
    v-model="regData.customer_id"
    :items="customers"
    item-title="name"
    item-value="id"
    :error-messages="errors.customer_id"
  >    
  </v-select>
  <v-select
    :label="$t('Application')"
    v-model="regData.app_id"
    :items="applications"
    item-title="name"
    item-value="id"
    :error-messages="errors.app_id"
  >    
  </v-select>
  <v-text-field 
    type="text"
    ref="key"
    :label="$t('Key')"
    v-if="!!regData.app_key"
    v-model="regData.app_key"
    readonly
    append-icon="mdi-content-copy"
    @click:append="copyText('key')"
    persistent-hint
  >
  </v-text-field>
  <v-btn @click="submit" v-if="!regData.app_key">{{ $t('Save') }}</v-btn>
</template>

<script>
export default {
  data: function () {
    return {
      customers: [],
      applications: [
        { name: 'Globus-meteo', id: 1 },
        { name: 'Test', id: 2 }
      ],
      regData: {},
      errors: {}
    }
  },
  async mounted() {
    this.regData = {
        app_id: null,
        app_key: null,
        customer_id: null
      };
    await this.$store.dispatch('httpRequest', {
      url: '/customers',
      method: 'GET',
      data: null,
      mutation: 'setCustomers'
    });
    this.customers = this.$store.getters.allCustomers;
  },
  methods: {
    async submit() {
      await this.$store.dispatch('httpRequest', {
        url: '/app-registration',
        method: 'POST',
        data: this.regData,
        mutation: 'setCurrentAppRegistration'
      });
      this.errors = this.$store.getters.httpErrors;
      this.regData = this.$store.getters.currentAppRegistration;
      setTimeout(() => this.copyText('key'), 300);
    },
    copyText(txt){
      const element = this.$refs[txt];
      element.select();
      element.setSelectionRange(0, 99999);
      document.execCommand('copy');
    },
  },
  computed: {

  }
}
</script>