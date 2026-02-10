<template>
  <v-text-field 
    type="date"
    :label="$t('Date of sticker')"
    v-model="stickerData.doi"
    :error-messages="errors.doi"
  >           
  </v-text-field>
  <v-text-field 
    type="date"
    :label="$t('Date of expire')"
    v-model="stickerData.doi"
    :error-messages="errors.doi"
  >           
  </v-text-field>
  <v-text-field 
    type="text"
    :label="$t('Name')"
    ref="name"
    v-model="stickerData.contact_name"
    :error-messages="errors.name"
    counter="50"
  >
  </v-text-field>
  <v-text-field 
    type="tel"
    :label="$t('Phone')"
    ref="phone"
    v-model="stickerData.contact_phone"
    :error-messages="errors.phone"
  >
  </v-text-field>
  <v-text-field 
    type="email"
    label="E-mail"
    ref="email"
    v-model="stickerData.contact_email"
    :error-messages="errors.email"
  >
  </v-text-field>
  <v-select
    :label="$t('Priority')"
    v-model="stickerData.priority"
    :error-messages="errors.priority"
    :items="priorities"
  >    
  </v-select>        
  <v-textarea 
    :label="$t('Text')"
    v-model="stickerData.message"
    :error-messages="errors.message"
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
    sticker: Object
  },
  data: function () {
    return {
      file: null,
      stickerData: {},
      priorities: [
        {title: this.$t('Low'), value: 3},
        {title: this.$t('Medium'), value: 2},
        {title: this.$t('High'), value: 1}
      ],
      errors: {},
      attachmentErrors: {}
    }
  },
  mounted() {
    this.stickerData = this.sticker;
  },
  methods: {
    uploadFile() {
      this.file = this.$refs.file.files[0];
    },
    async save() {
      const formData = new FormData();
      if(!!this.file) {
        formData.append('file', this.file);
      }
      formData.append('message', this.stickerData.message);
      formData.append('doi', this.stickerData.doi);
      formData.append('valid_until', this.stickerData.valid_until);
      formData.append('contact_name', this.stickerData.contact_name);
      formData.append('contact_phone', this.stickerData.contact_phone);
      formData.append('contact_email', this.stickerData.contact_email);
      await this.$store.dispatch('httpRequest', {
        url: '/stickers',
        method: 'POST',
        data: formData,
        mutation: 'setCurrentSticker'
      });
      this.errors = this.$store.getters.httpErrors;
    }
  }
}
</script>