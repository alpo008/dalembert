<template>
  <v-card style="margin-top:5px;">
    <v-card-text>
      <v-system-bar color="transparent"
        v-if="editable&&$auth.check('super')"
        style="height:50px;width:auto;top:160px;right:20px;left:auto;padding: 0 2%;justify-content:center;"
        class="rounded"
        elevation="10"
      >
        <v-btn
          icon="mdi-delete-alert-outline"
          v-if="editable&&$auth.check('super')"
          @click="delete"
          style="margin: 0 3%;"
          :title="$t('Delete')"
        >
        </v-btn>
        <v-btn
          icon="mdi-content-save"
          v-if="editable&&$auth.check('super')"
          @click="save"
          style="margin: 0 3%;"
          :title="$t('Save')"
        >
        </v-btn>
      </v-system-bar>
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
        :center="mapCenter"
        :zoom="16"
        map-type-id="hybrid"
        :streetViewControl="false"
        :options="{
          zoomControl: true,
          mapTypeControl: true,
          scaleControl: true,
          streetViewControl: false,
          rotateControl: false,
          fullscreenControl: true,
        }"
        style="width: 250px; height: 250px; margin-left: auto; margin-right: auto;"
        @click="handleMapClick"
      >
        <GMapMarker :position="customerData.location"/>
      </GMapMap>
    </v-card-text>
  </v-card>
</template>
<script>
  const isEmpty = obj => [Object, Array].includes((obj || {}).constructor) && !Object.entries((obj || {})).length;
  export default {
    data: function () {
      return {
        customerData: {},
        errors: {},
        showMap: false,
        mapCenter: {}
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
      if (this.$route.params.id === '0') {
        this.customerData = {};
        this.customerData.location = this.defaultMapCenter;
        this.$store.commit('setEditorMode', true);
      } else {
        this.customerData = this.$store.getters.customerById(parseInt(this.$route.params.id)) ?? {};
      }      
      this.setMap();
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
        let url = !!this.customerData.id ? '/customers/' + this.customerData.id : '/customers';
        await this.$store.dispatch('httpRequest', {
          url: url,
          method: method,
          data: this.customerData,
          mutation: 'setCurrentCustomer'
        });
        this.errors = this.$store.getters.httpErrors;
        if(method === 'POST' && isEmpty(this.errors)) {
          this.customerData = this.$store.getters.currentCustomer;
          this.$router.push('/customers/' + this.customerData.id);
        }
      },
      delete() {

      },
      setMap() {
        this.mapCenter = this.customerData.location;
        this.showMap = this.customerData.location?.lat & this.customerData.location?.lng;
      }
    },
    computed: {
      editable() {
        return this.$store.getters.canEdit;
      },
      defaultMapCenter() {
        return JSON.parse(`${process.env.MIX_GM_MAP_CENTER}`);
      }
    },
    watch: {
        "$store.state.general.editorMode"(e) {
      }
    }
  } 
</script>