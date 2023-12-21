<template>
  <h1> {{ $t('Upload file') }} </h1>
    <v-text-field 
    type="text"
    :label="$t('Name')"
    v-model="name"
    :error-messages="errors.name"
    counter="30"
  >
  </v-text-field>
  <v-text-field 
    type="text"
    :label="$t('Collection')"
    v-model="collection"
    :error-messages="errors.collection"
    counter="30"
  >
  </v-text-field>
  <v-textarea 
    :label="$t('Description')"
    v-model="description"
    :error-messages="errors.description"
  >   
  </v-textarea>
  <v-file-input :label="$t('File')" @change="uploadFile" ref="file"></v-file-input>
  <v-btn @click="submitFile">Upload</v-btn>
</template>
<script>
export default {
  data: function () {
    return {
      _file: null,
      name: '',
      collection: '',
      description: '',
      errors: {}
    }
  },
  mounted() {
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
      await this.$store.dispatch('httpRequest', {
        url: '/upload',
        method: 'POST',
        data: formData,
        mutation: ''
      });
      this.errors = this.$store.getters.httpErrors;
    }
  }
}
</script>