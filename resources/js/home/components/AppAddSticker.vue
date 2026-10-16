<template>
  <div @click="$router.go(-1)" class="back-link link-grey" :title="$store.getters.t('Back')"> 
    <svg width="30px" height="30px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
      <g id="icomoon-ignore"></g>
      <path d="M14.389 7.956v4.374l1.056 0.010c7.335 0.071 11.466 3.333 12.543 9.944-4.029-4.661-8.675-4.663-12.532-4.664h-1.067v4.337l-9.884-7.001 9.884-7zM15.456 5.893l-12.795 9.063 12.795 9.063v-5.332c5.121 0.002 9.869 0.26 13.884 7.42 0-4.547-0.751-14.706-13.884-14.833v-5.381z" fill="#000000">
      </path>
    </svg>
  </div>
  <div class="container px-4 px-lg-5">
    <div 
      class="alert alert-secondary alert-dismissible fade show" 
      role="alert" 
      v-if="showSuccessMessage"
    >
      {{ $t('Request has been sent. Wait for an e-mail.') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <p>
      {{ $store.getters.findOrFail(this.$store.getters.config, 'page.form_text') }}
    </p>
  </div>
</template>
<script>
  export default {
    data: function () {
      return {
        apiKey: `${process.env.MIX_GLOBUS_API_KEY}`,
        canSubmit: false,
        canDownload: false,
        errors: {},
        showSuccessMessage: false
      }
    },
    async created() {
    },
    methods: {
      async submitForm() {
/*        if(!this.canSubmit) {
          this.$refs.personalDataAgreementCheckbox.classList.add('is-invalid');
        } else {
          this.$refs.personalDataAgreementCheckbox.classList.add('is-valid');
        }
        let data = Object.assign(this.regData, {api_key: this.apiKey});
        await this.$store.dispatch('httpRequest', {
          url: '/app-registration/apply',
          method: 'POST',
          data: data,
          mutation: ''
        });
        this.errors = this.$store.getters.httpErrors;
        if(!_.isEmpty(this.errors)) {
          this.$store.commit('setHttpLoadingState', false);
        } else {
          this.showSuccessMessage = true;
        }*/
      },
      fieldError(fieldName) {
        return this.$store.getters.findOrFail(this.errors, fieldName + '.0')
      },
    },
    computed: {
    }
  }
</script>
<style scoped>
  .input-transparent {
    background-color: rgba(255, 255, 255, 0.55);
  }
  .text-help {
    mix-blend-mode: difference;
  }
</style>