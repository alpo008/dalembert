<template>  
  <v-text-field 
    type="text"
    :label="$t('Key')"
    v-model="settingData.key"
    :error-messages="errors.key"
    counter="255"
  >
  </v-text-field>
  <v-select
    :label="$t('Locale')"
    v-model="settingData.locale"
    :error-messages="errors.locale"
    :items="locales"
  >    
  </v-select>
  <v-text-field 
    type="text"
    :label="$t('Comment')"
    v-model="settingData.comment"
    :error-messages="errors.comment"
    counter="255"
  >
</v-text-field>
  <v-textarea 
    :label="$t('Value')"
    v-model="settingData.value"
    :error-messages="errors.value"
  >   
  </v-textarea>
  <v-btn @click="submit">{{ $t('Save') }}</v-btn>
</template>

<script>
export default {
  props: {
    setting: Object
  },
  data: function () {
    return {
      settingData: {
        key: '',
        locale: 'ru',
        value: '',
        comment: ''
      },
      locales: ['ru', 'en'],
      errors: {}
    }
  },
  mounted() {
    this.settingData = this.setting;
  },
  methods: {
    async submit() {
      let method = !!this.settingData.id ? 'PUT' : 'POST';
      let url = !!this.settingData.id ? '/site-settings/' + this.settingData.id : '/site-settings';
      await this.$store.dispatch('httpRequest', {
        url: url,
        method: method,
        data: this.settingData,
        mutation: 'setCurrentSiteSetting'
      });
      this.errors = this.$store.getters.httpErrors;
    },
  },
  computed: {
  }
}
</script>