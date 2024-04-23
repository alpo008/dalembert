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
      <GMapMap
        v-if="showMap"
        :center="customerData.location"
        :zoom="13"
        map-type-id="terrain"
        style="width: 100%; height: 300px; margin: 3px;"
        @click="handleMapClick"
      >
        <GMapMarker :position="customerData.location"/>
      </GMapMap>
      <v-btn
        icon="mdi-content-save"
        v-if="editable&&$auth.check('super')"
        @click="save"
        :title="$t('Save')"
      >
      </v-btn>
  </v-card>
</template>
<script>
  export default {
    data: function () {
      return {
        customerData: {},
        errors: {},
        showMap: false
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
        this.customerData = this.$store.getters.customerById(parseInt(this.$route.params.id)) ?? {};
        this.showMap = this.customerData.location?.lat & this.customerData.location?.lng;
      } else {
        this.customerData = this.$store.getters.customerById(parseInt(this.$route.params.id)) ?? {};
        this.showMap = this.customerData.location?.lat & this.customerData.location?.lng;
      }
    },
    methods: {
      handleMapClick(e) {
        if(this.editable) {
          this.customerData.location.lat = e.latLng.lat();
          this.customerData.location.lng = e.latLng.lng();
        }
      },
      async save() {
        let method = !!this.customerData.id ? 'PUT' : 'POST';
        let url = !!this.customerData.id ? '/customers/' + this.customerData.id : '/works';
        await this.$store.dispatch('httpRequest', {
          url: url,
          method: method,
          data: this.customerData,
          mutation: 'setCurrentCustomer'
        });
        this.errors = this.$store.getters.httpErrors;
      }
    },
    computed: {
      editable() {
        return this.$store.getters.canEdit;
      },
      mapCenter() {
        return JSON.parse(`${process.env.MIX_GM_MAP_CENTER}`);
      }
    },
    watch: {
        "$store.state.general.editorMode"(e) {
      }
    }
  } 
</script>