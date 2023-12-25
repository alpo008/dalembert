<template>
    <v-text-field 
    type="text"
    :label="$t('Name')"
    v-model="name"
    :error-messages="errors.name"
    counter="30"
  >
  </v-text-field>
  <v-select
    :label="$t('Collection')"
    v-model="collection"
    :error-messages="errors.collection"
    :items="enabledCollections"
  >    
  </v-select>
  <v-text-field 
  type="date"
  :label="$t('Date of issue')"
  v-model="doi"
  :error-messages="errors.doi"
>           
</v-text-field>
  <v-textarea 
    :label="$t('Description')"
    v-model="description"
    :error-messages="errors.description"
  >   
  </v-textarea>
  <v-file-input 
    :label="$t('File')" 
    @change="uploadFile"
    show-size
    ref="file"
    :error-messages="errors.file"
  ></v-file-input>
  <v-btn @click="submitFile">{{ $t('Save') }}</v-btn>
</template>
<script>
export default {
  data: function () {
    return {
      _file: null,
      name: '',
      collection: '',
      description: '',
      doi: new Date().toISOString().slice(0,10),
      errors: {},
      enabledCollections: []
    }
  },
  mounted() {
    const enabledMediaCollections = `${process.env.MIX_ENABLED_MEDIA_COLLECTIONS}`;
    let enabledCollections = JSON.parse(enabledMediaCollections);
    this.enabledCollections = enabledCollections.map(i => this.$t(i));
  },
  methods: {
    uploadFile() {
      this._file = this.$refs.file.files[0];
    },
    async submitFile() {
      const formData = new FormData();
      formData.append('file', this._file);
      formData.append('name', this.name);
      formData.append('collection', this.collection);
      formData.append('doi', this.doi);
      await this.$store.dispatch('httpRequest', {
        url: '/upload',
        method: 'POST',
        data: formData,
        mutation: 'setUploaded'
      });
      this.errors = this.$store.getters.httpErrors;
    }
  }
}
</script>