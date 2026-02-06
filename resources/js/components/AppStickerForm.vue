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
  data: function () {
    return {
      file: null,
      stickerData: {
        message: '',
        doi: new Date().toISOString().slice(0,10),
        valid_until: new Date().toISOString().slice(0,10),
        contact_name: '',
        contact_phone: '',
        contact_email: '',
        priority: 3,
      },
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
      formData.append('amount', this.stickerData.amount);
      formData.append('doi', this.stickerData.doi);
      formData.append('payer_type', this.stickerData.payer_type);
      formData.append('payer_id', this.stickerData.payer_id);
      formData.append('comments', this.stickerData.comments);
      formData.append('destination', this.stickerData.destination);
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