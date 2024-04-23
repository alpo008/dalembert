<template>
  <v-card style="margin-top:5px;">
    <v-text-field 
      type="text"
      :label="$t('Name')"
      ref="name"
      v-if="!!customerData.name|editable"
      v-model="customerData.name"
      :readonly="!editable"
      :error-messages="errors.name"
      counter="30"
    >
    </v-text-field>
      <v-text-field 
        type="tel"
        :label="$t('Phone')"
        ref="phone"
        v-if="!!customerData.phone|editable"
        v-model="customerData.phone"
        :readonly="!editable"
        :error-messages="errors.phone"
      >
      </v-text-field>
      <v-text-field 
        type="email"
        label="E-mail"
        ref="email"
        v-if="!!customerData.email|editable"
        v-model="customerData.email"
        :readonly="!editable"
        :error-messages="errors.email"
      >
      </v-text-field>
      <v-text-field 
        type="text"
        :label="$t('Address')"
        ref="address"
        v-if="!!customerData.address|editable"
        v-model="customerData.address"
        :readonly="!editable"
        :error-messages="errors.address"
      >
      </v-text-field>
      <v-textarea 
        :label="$t('Comments')"
        ref="comments"
        v-if="!!customerData.comments|editable"
        v-model="customerData.comments"
        :readonly="!editable"
        :error-messages="errors.comments"
      >       
      </v-textarea>
  </v-card>
</template>
<script>
    export default {
      data: function () {
        return {
          customerData: {},
          errors: {}
        }
      },
      async created() {
        if (!this.$store.getters.allCustomers.length) {
          await this.$store.dispatch('httpRequest', {
            url: '/customers',
            method: 'GET',
            data: null,
            mutation: 'setCustomers'
          });
        }
        this.customerData = this.$store.getters.customerById(parseInt(this.$route.params.id)) ?? {};
      },
      computed: {
        editable() {
          return this.$store.getters.canEdit;
        }
      },
      watch: {
          "$store.state.general.editorMode"(e) {
        }
      }
    } 
</script>