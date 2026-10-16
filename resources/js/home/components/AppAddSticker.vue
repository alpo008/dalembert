<template>
  <div @click="$router.go(-1)" class="back-link link-grey" :title="$store.getters.t('Back')"> 
    <svg width="30px" height="30px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
      <g id="icomoon-ignore"></g>
      <path d="M14.389 7.956v4.374l1.056 0.010c7.335 0.071 11.466 3.333 12.543 9.944-4.029-4.661-8.675-4.663-12.532-4.664h-1.067v4.337l-9.884-7.001 9.884-7zM15.456 5.893l-12.795 9.063 12.795 9.063v-5.332c5.121 0.002 9.869 0.26 13.884 7.42 0-4.547-0.751-14.706-13.884-14.833v-5.381z" fill="#000000">
      </path>
    </svg>
  </div>
  <div class="container px-4 px-lg-5 mt-5">
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
    <form @submit.prevent="submitForm">
      <div class="row mb-3">
        <label for="formInputSenderName" class="col-sm-2 col-form-label col-form-label-sm">
          {{ $store.getters.t('What is your name') }} ?
        </label>
        <div class="col-sm-10">
          <input type="text" 
            class="form-control form-control-sm input-transparent" 
            :class="!!fieldError('sender_name') ? 'is-invalid' : ''"
            id="formInputSenderName" 
            v-model="formData.sender_name"
            :placeholder="$store.getters.t('Your Name and Surname')" 
          >
          <div class="invalid-feedback form-control-sm">
            {{ fieldError('sender_name') }}
          </div>
        </div>
      </div>
      <div class="row mb-3">
        <label for="formInputSenderEmail" class="col-sm-2 col-form-label col-form-label-sm">
          {{ $store.getters.t('Feedback email') }}
        </label>
        <div class="col-sm-10">
          <input type="email" 
            class="form-control form-control-sm input-transparent" 
            :class="!!fieldError('sender_email') ? 'is-invalid' : ''"
            id="formInputSenderEmail" 
            v-model="formData.sender_email"
            :placeholder="$store.getters.t('Won`t be published')" 
          >
          <div class="invalid-feedback form-control-sm">
            {{ fieldError('sender_email') }}
          </div>
        </div>
      </div>
      <div class="row mb-3">
        <label for="formInputSenderAdditional" class="col-sm-2 col-form-label col-form-label-sm">
          {{ $store.getters.t('Additional information') }}
        </label>
        <div class="col-sm-10">
          <input type="text" 
            class="form-control form-control-sm input-transparent" 
            :class="!!fieldError('sender_additional_info') ? 'is-invalid' : ''"
            id="formInputSenderAdditional" 
            v-model="formData.sender_additional_info"
          >
          <div class="invalid-feedback form-control-sm">
            {{ fieldError('sender_additional_info') }}
          </div>
        </div>
      </div>
      <div class="mb-3 form-check">
        <input type="checkbox" 
          class="form-check-input input-transparent" 
          id="personalDataAgreementCheck"
          v-model="canSubmit"
          ref="personalDataCheckbox"
        >
        <label class="form-check-label" for="personalDataAgreementCheck">
         {{ $store.getters.t('I consent to the processing of my personal data (without transfer to third parties)') }}.
        </label>
      </div>
      <div class="w-100"><hr /></div>
      <div class="row mb-3">
        <label for="formInputVenue" class="col-sm-2 col-form-label col-form-label-sm">
          {{ $store.getters.t('Venue') }}
        </label>
        <div class="col-sm-10">
          <input type="text" 
            class="form-control form-control-sm input-transparent" 
            :class="!!fieldError('venue') ? 'is-invalid' : ''"
            id="formInputVenue" 
            v-model="formData.venue"
          >
          <div class="invalid-feedback form-control-sm">
            {{ fieldError('venue') }}
          </div>
        </div>
      </div>
      <div class="row mb-3">
        <label for="formInputDoi" class="col-sm-2 col-form-label col-form-label-sm">
          {{ $store.getters.t('Date of beginning')}}
        </label>
        <div class="col-sm-10">
          <input type="date" 
            class="form-control form-control-sm input-transparent"
            :class="!!fieldError('doi') ? 'is-invalid' : ''"
            id="formInputDoi" 
            v-model="formData.doi"
          >
          <div class="invalid-feedback invalid-feedback-sm">
            {{ fieldError('doi') }}
          </div>
        </div>
      </div>
      <div class="row mb-3">
        <label for="formInputValidUntil" class="col-sm-2 col-form-label col-form-label-sm">
          {{ $store.getters.t('Date of end')}}
        </label>
        <div class="col-sm-10">
          <input type="date" 
            class="form-control form-control-sm input-transparent"
            :class="!!fieldError('valid_until') ? 'is-invalid' : ''"
            id="formInputValidUntil" 
            v-model="formData.valid_until"
          >
          <div class="invalid-feedback invalid-feedback-sm">
            {{ fieldError('valid_until') }}
          </div>
        </div>
      </div>
      <div class="row mb-3">
        <label for="formInputSponsorEmail" class="col-sm-2 col-form-label col-form-label-sm">
          {{ $store.getters.t('Sponsor email') }}
        </label>
        <div class="col-sm-10">
          <input type="email" 
            class="form-control form-control-sm input-transparent" 
            :class="!!fieldError('sponsor_email') ? 'is-invalid' : ''"
            id="formInputSponsorEmail" 
            v-model="formData.sponsor_email"
            :placeholder="$store.getters.t('Will be published on the website')"
          >
          <div class="invalid-feedback form-control-sm">
            {{ fieldError('sponsor_email') }}
          </div>
        </div>
      </div>
      <div class="row mb-3">
        <label for="formInputSponsorPhone" class="col-sm-2 col-form-label col-form-label-sm">
          {{ $store.getters.t('Sponsor phone') }}
        </label>
        <div class="col-sm-10">
          <input type="tel" 
            class="form-control form-control-sm input-transparent" 
            :class="!!fieldError('sponsor_phone') ? 'is-invalid' : ''"
            id="formInputSponsorPhone" 
            v-model="formData.sponsor_phone"
            :placeholder="$store.getters.t('Will be published on the website')"
          >
          <div class="invalid-feedback form-control-sm">
            {{ fieldError('sponsor_phone') }}
          </div>
        </div>
      </div>
      <div class="row mb-3">
        <label for="formInputLinkAddress" class="col-sm-2 col-form-label col-form-label-sm">
          {{ $store.getters.t('Reference to the source') }}
        </label>
        <div class="col-sm-10">
          <input type="tel" 
            class="form-control form-control-sm input-transparent" 
            :class="!!fieldError('link_address') ? 'is-invalid' : ''"
            id="formInputLinkAddress" 
            v-model="formData.link_address"
            :placeholder="$store.getters.t('Will be published on the website')"
          >
          <div class="invalid-feedback form-control-sm">
            {{ fieldError('link_address') }}
          </div>
        </div>
      </div>
      <div class="row mb-3">
        <label for="formInputImage" class="form-label">
          {{ $store.getters.t('Image')}}
        </label>
        <div class="col-sm-10">
          <input class="form-control form-control-sm input-transparent" type="file" id="formInputImage" ref="imageFile">
        </div>
        <div class="invalid-feedback form-control-sm">
          {{ fieldError('file') }}
        </div>
      </div>
      <button 
        type="submit" 
        :class="canSubmit ? 'btn btn-light' : 'btn btn-light disabled'" 
        class="mb-5"
      >
        {{ $store.getters.t('Send') }}
      </button>
    </form>
  </div>
</template>
<script>
  export default {
    data: function () {
      return {
        apiKey: `${process.env.MIX_GLOBUS_API_KEY}`,
        formData: {},
        canSubmit: false,
        errors: {},
        showSuccessMessage: false,
        imageFile: null
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