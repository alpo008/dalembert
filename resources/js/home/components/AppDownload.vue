<template>
  <div class="container">
    <form @submit.prevent="submitForm">
      <div class="mb-3">
        <label for="formInputName" class="form-label">
          {{ $store.getters.t('Name')}}
        </label>
        <input type="text" 
          class="form-control input-transparent" 
          id="formInputName" 
          v-model="regData.name"
        >
      </div>
      <div class="mb-3">
        <label for="formInputEmail" class="form-label">Email</label>
        <input type="email" 
          class="form-control input-transparent" 
          id="formInputEmail" 
          aria-describedby="emailHelp"
          v-model="regData.email"
        >
        <div id="emailHelp" class="form-text text-help">
          {{ $store.getters.t('Real e-mail to send application key') }} .
          {{ $store.getters.t('We`ll never share your email with anyone else') }} .
        </div>
      </div>
      <div class="mb-3">
        <label for="formInputPhone" class="form-label">
          {{ $store.getters.t('Phone') }}
        </label>
        <input type="tel" 
          class="form-control input-transparent" 
          id="formInputPhone" 
          aria-describedby="phoneHelp"
          v-model="regData.phone"
        >
        <div id="phoneHelp" class="form-text text-help">
          {{ $store.getters.t('Not required if email address is provided') }} .
          {{ $store.getters.t('We`ll never share your phone number with anyone else') }} .
        </div>
      </div>
      <div class="mb-3">
        <label for="formInputAddress" class="form-label">
          {{ $store.getters.t('Address') }}
        </label>
        <input type="text" 
          class="form-control input-transparent" 
          id="formInputAddress" 
          aria-describedby="addressHelp"
          v-model="regData.address"
        >
        <div id="addressHelp" class="form-text text-help">
          {{ $store.getters.t('Place number or address') }}
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
      <button type="submit" :class="canSubmit ? 'btn btn-light' : 'btn btn-light disabled'" 
        @click="validateAgreement">
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
        regData: {
          name: '',
          phone: '',
          email: '',
          address: ''
        },
        canSubmit: false,
        errors: {}
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
        }
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