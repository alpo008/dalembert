<template>
  <div class="modal fade justify-items-center" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" inert="true">
  <div class="modal-dialog top-40vh">
    <div class="modal-content card-transparent mx-0">
      <div class="modal-body">
        <div class="alert alert-success fade show" role="alert">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="green" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
          </svg>
          {{ $t('Request has been sent. Wait for an e-mail.') }}
        </div>
      </div>
    </div>
  </div>
</div>
</template>

<script>
  import { Modal } from 'bootstrap';

export default {
  name: 'GoBack',
  data() {
    return {
      modalInstance: null
    }
  },
  mounted() {
    if(this.modalInstance === null) {
      this.modalInstance = new Modal(document.getElementById("alertModal"));
    }
  },
  watch: {
    '$store.state.general.modal' (current, prev) {
      if(current) {
        if (typeof this.modalInstance.show === 'function') {
          this.modalInstance.show();
        }
      } else {
        if (typeof this.modalInstance.hide === 'function') {
          this.modalInstance.hide();
          if (this.$route.path !== '/') {
            this.$router.go(-1);
          }
        }
      }
    }
  }
}
</script>

<style scoped>
  .card-transparent {
    background-color: transparent!important;
    border:none;
  }
  .justify-items-center {
    justify-items: center;
  }
  .top-40vh {
    top: 40vh;
  }
</style>