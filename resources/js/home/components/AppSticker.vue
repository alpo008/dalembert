<template>
  <GoBack />
  <div class="container px-4 px-lg-5 mt-4" v-if="!!sticker">
    <div class="row gx-4 gx-lg-5 align-items-center my-3">
        <div class="col-lg-7" v-if="imagePath">
          <img class="img-fluid rounded mb-4 mb-lg-0 img-width-100"
            v-if="imagePath"
            :src="imagePath" 
          />
          </div>
        <div :class="imagePath ? 'col-lg-5' : 'col-lg-12'">
          <h1 class="font-weight-light">
            {{ sticker.contact_name }}
          </h1>
          <p> {{ sticker.message }}</p>
          <button class="btn" type="button" @click="$store.dispatch('phoneCall', sticker.contact_phone)" 
              v-if="sticker.contact_phone"
          >
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone-forward" viewBox="0 0 16 16">
              <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.6 17.6 0 0 0 4.168 6.608 17.6 17.6 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.68.68 0 0 0-.58-.122l-2.19.547a1.75 1.75 0 0 1-1.657-.459L5.482 8.062a1.75 1.75 0 0 1-.46-1.657l.548-2.19a.68.68 0 0 0-.122-.58zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877zm10.762.135a.5.5 0 0 1 .708 0l2.5 2.5a.5.5 0 0 1 0 .708l-2.5 2.5a.5.5 0 0 1-.708-.708L14.293 4H9.5a.5.5 0 0 1 0-1h4.793l-1.647-1.646a.5.5 0 0 1 0-.708"/>
            </svg>
          </button>
          <button class="btn" type="button" @click="$store.dispatch('sendEmail', sticker.contact_email)" 
            v-if="sticker.contact_email"
          >
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
              <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z"/>
            </svg>
          </button>
        </div>
    </div>
    <div class="mb-4" v-if="sticker.link_address">
        {{ $store.getters.t('Reference') }} : &nbsp;
      <a :href="sticker.link_address" target="_blank" class="link-grey">
        {{ sticker.link_text ?? sticker_link_address }}
      </a>
    </div>
  </div>
</template>
<script>
  import GoBack from "./GoBack.vue"
  export default {
    components: { GoBack },
    data: function () {
      return {
        sticker: null
      }
    },
    async created() {
      if(!this.$store.getters.activeStickers.length) {
        await this.$store.dispatch('httpRequest', {
          url: '/home/globus',
          method: 'POST',
          data: null,
          mutation: 'setStickers'
        });
      }
      this.sticker = this.$store.getters.stickerById(this.$route.params.id);
    },
    methods: {
    },
    computed: {
      imagePath () {
        return this.$store.getters.stickerImagePath(this.sticker.id, 'Sticker image');
      }
    }
  }
</script>
<style scoped>
    .blur {
      backdrop-filter: blur(10px);
    }
    .img-width-100 {
    width: 100%;
    height: auto;
    object-fit: cover;
  }
</style>