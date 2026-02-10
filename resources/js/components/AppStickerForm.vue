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
    v-model="stickerData.valid_until"
    :error-messages="errors.valid_until"
  >           
  </v-text-field>
  <v-text-field 
    type="text"
    :label="$t('Name')"
    ref="name"
    v-model="stickerData.contact_name"
    :error-messages="errors.contact_name"
    counter="50"
  >
  </v-text-field>
  <v-text-field 
    type="tel"
    :label="$t('Phone')"
    ref="phone"
    v-model="stickerData.contact_phone"
    :error-messages="errors.contact_phone"
  >
  </v-text-field>
  <v-text-field 
    type="email"
    label="E-mail"
    ref="email"
    v-model="stickerData.contact_email"
    :error-messages="errors.contact_email"
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
      let url = !!this.stickerData.id ? '/stickers/' + this.stickerData.id : '/stickers';
      const formData = new FormData();
      if(!!this.file) {
        formData.append('file', this.file);
      }
      if(!!this.stickerData.id) {
        formData.append('_method', 'put');
      }
      formData.append('doi', this.stickerData.doi);
      formData.append('valid_until', this.stickerData.valid_until);
      if (this.stickerData.message !== null && this.stickerData.message !== undefined) {
          formData.append('message', this.stickerData.message);
      } else {
          formData.append('message', '');
      }
      if (this.stickerData.contact_name !== null && this.stickerData.contact_name !== undefined) {
          formData.append('contact_name', this.stickerData.contact_name);
      } else {
          formData.append('contact_name', '');
      }
      if (this.stickerData.contact_phone !== null && this.stickerData.contact_phone !== undefined) {
          formData.append('contact_phone', this.stickerData.contact_phone);
      } else {
          formData.append('contact_phone', '');
      }
      if (this.stickerData.contact_email !== null && this.stickerData.contact_email !== undefined) {
          formData.append('contact_email', this.stickerData.contact_email);
      } else {
          formData.append('contact_email', '');
      }
      formData.append('priority', this.stickerData.priority);

      await this.$store.dispatch('httpRequest', {
        url: url,
        method: 'POST',
        data: formData,
        mutation: 'setCurrentSticker'
      });
      this.errors = this.$store.getters.httpErrors;
    }
  }
}
</script>