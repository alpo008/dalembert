<template>
  <div class="container">
    <div 
      class="alert alert-secondary alert-dismissible fade show" 
      role="alert" 
      v-if="showSuccessMessage"
    >
      {{ $t('Request has been sent. Wait for an e-mail.') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <p>
      <button class="btn btn-secondary mr-8" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDownloadForm" aria-expanded="false" aria-controls="collapseDownloadForm"
      @click="closeCollapse('regForm')"
      >
        {{ $store.getters.t('Download app for android') }}
      </button>
      <button class="btn btn-secondary mr-8" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRegForm" aria-expanded="false" aria-controls="collapseRegForm"
      @click="closeCollapse('downloadForm')"
      >
        {{ $store.getters.t('Get activation code') }}
      </button>
    </p>
    <div class="collapse" id="collapseDownloadForm" ref="downloadForm">
      <form @submit.prevent="downloadApp">
        <div class="mb-3">
          <label class="form-check-label" for="personalDataAgreementCheck">
           {{ $store.getters.t('Select an application') }}.
          </label>
          <select class="form-select" aria-label="Default select example" v-model="appToDownload">
            <option value="1">Globus-meteo</option>
            <option value="2" disabled>Globus-info</option>
          </select>
        </div>
        <div class="mb-3 form-check">
          <input type="checkbox" 
            class="form-check-input input-transparent" 
            id="disclaimerCheck"
            v-model="canDownload"
            ref="disclaimerCheckbox"
          >
          <label class="form-check-label" for="personalDataAgreementCheck">
           {{ $store.getters.t('Disclaimer__short') }}.
          </label>
        </div>
        <button type="submit" :class="canDownload ? 'btn btn-light' : 'btn btn-light disabled'">
          {{ $store.getters.t('Download') }}
        </button>
      </form>
    </div>
    <div class="collapse" id="collapseRegForm" ref="regForm">
      <form @submit.prevent="submitForm">
        <div class="row mb-3">
          <label for="formInputName" class="col-sm-2 col-form-label col-form-label-sm">
            {{ $store.getters.t('Name')}}
          </label>
          <div class="col-sm-10">
          <input type="text" 
            class="form-control form-control-sm input-transparent"
            :class="!!fieldError('name') ? 'is-invalid' : ''"
            id="formInputName" 
            v-model="regData.name"
          >
          <div class="invalid-feedback invalid-feedback-sm">
            {{ fieldError('name') }}
          </div>
        </div>
        </div>
        <div class="row mb-3">
          <label for="formInputPhone" class="col-sm-2 col-form-label col-form-label-sm">
            {{ $store.getters.t('Phone') }}
          </label>
          <div class="col-sm-10">
            <input type="tel" 
              class="form-control form-control-sm input-transparent" 
              :class="!!fieldError('phone') ? 'is-invalid' : ''"
              id="formInputPhone" 
              aria-describedby="phoneHelp"
              v-model="regData.phone"
            >
            <div class="invalid-feedback form-control-sm">
              {{ fieldError('phone') }}
            </div>
            <div id="phoneHelp" class="form-text text-help form-control-sm">
              {{ $store.getters.t('Not required if email address is provided') }} .
              {{ $store.getters.t('We`ll never share your phone number with anyone else') }} .
            </div>
          </div>
        </div>
        <div class="row mb-3">
          <label for="formInputEmail" class="col-sm-2 col-form-label col-form-label-sm">Email</label>
          <div class="col-sm-10">
            <input type="email" 
              class="form-control form-control-sm input-transparent" 
              :class="!!fieldError('email') ? 'is-invalid' : ''"
              id="formInputEmail" 
              aria-describedby="emailHelp"
              v-model="regData.email"
            >
            <div class="invalid-feedback form-control-sm">
              {{ fieldError('email') }}
            </div>
            <div id="emailHelp" class="form-text text-help form-control-sm">
              {{ $store.getters.t('Real e-mail to send application key') }} .
              {{ $store.getters.t('We`ll never share your email with anyone else') }} .
            </div>
          </div>
        </div>
        <div class="row mb-3">
          <label for="formInputAddress" class="col-sm-2 col-form-label col-form-label-sm">
            {{ $store.getters.t('Address') }}
          </label>
          <div class="col-sm-10">
            <input type="text" 
              class="form-control form-control-sm input-transparent" 
              :class="!!fieldError('address') ? 'is-invalid' : ''"
              id="formInputAddress" 
              aria-describedby="addressHelp"
              v-model="regData.address"
            >
            <div class="invalid-feedback form-control-sm">
              {{ fieldError('address') }}
            </div>
            <div id="addressHelp" class="form-text text-help form-control-sm">
              {{ $store.getters.t('Place number or address') }}
            </div>
          </div>
        </div>
        <div class="mb-3 form-check">
          <input type="checkbox" 
            class="form-check-input input-transparent" 
            id="personalDataAgreementCheck"
            v-model="canSubmit"
            ref="personalDataAgreementCheckbox"
          >
          <label class="form-check-label" for="personalDataAgreementCheck">
           {{ $store.getters.t('Law 152-FZ__short') }}  «Globus-Meteo» .
          </label>
        </div>
        <button type="submit" :class="canSubmit ? 'btn btn-light' : 'btn btn-light disabled'">
          {{ $store.getters.t('Send') }}
        </button>
      </form>
    </div>
  </div>
</template>
<script>
  export default {
    data: function () {
      return {
        apiKey: `${process.env.MIX_GLOBUS_API_KEY}`,
        regData: {
          name: '',
          phone: '',
          email: '',
          address: ''
        },
        canSubmit: false,
        canDownload: false,
        appToDownload: 1,
        errors: {},
        showSuccessMessage: false
      }
    },
    async created() {
    },
    methods: {
      async submitForm() {
        if(!this.canSubmit) {
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
        }
      },
      fieldError(fieldName) {
        return this.$store.getters.findOrFail(this.errors, fieldName + '.0')
      },
      closeCollapse(collapseElRef) {
        this.$refs[collapseElRef].classList.remove('show');
      },
      async downloadApp() {
        let data = {api_key: this.apiKey};
        await this.$store.dispatch('httpRequest', {
          url: '/home/download/' + this.appToDownload,
          method: 'POST',
          data: data,
          mutation: ''
        });
      }
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