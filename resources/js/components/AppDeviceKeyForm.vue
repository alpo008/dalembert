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
<!--  <v-select
    :label="$t('Category')"
    v-model="workData.category"
    :error-messages="errors.category"
    :items="categories"
    @update:modelValue="checkCategory"
  >    
  </v-select>
  <v-text-field 
    type="text"
    :label="$t('Work title')"
    v-model="workData.title"
    :error-messages="errors.title"
    counter="50"
  >
  </v-text-field>
    <v-text-field 
    type="number"
    :label="$t('Price per unit')"
    v-model="workData.price"
    :error-messages="errors.price"
  >           
  </v-text-field>
  <v-select
    :label="$t('Unit')"
    v-model="workData.unit"
    :error-messages="errors.unit"
    :items="units"
  >    
  </v-select>
  <v-textarea 
    :label="$t('Comments')"
    v-model="workData.comments"
    :error-messages="errors.comments"
  >   
  </v-textarea> -->
  <v-btn @click="submit">{{ $t('Save') }}</v-btn>
</template>

<script>
export default {
  data: function () {
    return {
      customers: [],
      regData: {
        app_id: null,
        app_key: null,
        customer_id: null
      },
      errors: {}
    }
  },
  async mounted() {
  await this.$store.dispatch('httpRequest', {
      url: '/customers',
      method: 'GET',
      data: null,
      mutation: 'setCustomers'
    });
    this.customers = this.$store.getters.allCustomers;
    console.log(this.customers)
  },
  methods: {
    async submit() {
/*      let method = !!this.workData.id ? 'PUT' : 'POST';
      let url = !!this.workData.id ? '/works/' + this.workData.id : '/works';
      await this.$store.dispatch('httpRequest', {
        url: url,
        method: method,
        data: this.workData,
        mutation: 'setCurrentWork'
      });
      this.errors = this.$store.getters.httpErrors;*/
    },
  },
  computed: {

  }
}
</script>