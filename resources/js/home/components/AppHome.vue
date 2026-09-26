<template>
  <div class="container px-4 px-lg-5">
    <div class="row gx-4 gx-lg-5 align-items-center my-5">
        <div class="col-lg-7"><img class="img-fluid rounded mb-4 mb-lg-0" src="https://dummyimage.com/900x400/dee2e6/6c757d.jpg" alt="..." /></div>
        <div class="col-lg-5">
            <h1 class="font-weight-light">Business Name or Tagline</h1>
            <p>This is a template that is great for small businesses. It doesn't have too much fancy flare to it, but it makes a great use of the standard Bootstrap core components. Feel free to use this template for any project you want!</p>
            <a class="btn btn-primary" href="#!">Call to Action!</a>
        </div>
    </div>

    <div class="card text-white bg-secondary my-5 py-4 text-center">
        <div class="card-body"><p class="text-white m-0">This call to action card is a great place to showcase some important information or display a clever tagline!</p></div>
    </div>
      <!-- Content Row-->
      <div class="row gx-4 gx-lg-5">
        <div class="col-md-4 mb-5" v-for="sticker in stickers">
          <div class="card h-100">
            <img
              v-if="sticker.attachments.length"
              :src="imagePath(sticker)" 
              class="card-img-top img-fixed-height sticker-link" 
              :alt="$store.getters.findOrFail(sticker, 'attachments.0.media.description')"
              @click="showSticker(sticker.id)"
              :title="$store.getters.t('Click to see details')"
            >
            <div class="card-body sticker-link" 
              @click="showSticker(sticker.id)"
              :title="$store.getters.t('Click to see details')"
            >
                <h4 class="card-title">{{ sticker.contact_name }}</h4>
                <p class="card-text">{{ sticker.message }}</p>
            </div>
            <div class="card-footer">
              <button class="btn" type="button" @click="phoneCall(sticker)" 
                v-if="sticker.contact_phone"
              >
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone-forward" viewBox="0 0 16 16">
                  <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.6 17.6 0 0 0 4.168 6.608 17.6 17.6 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.68.68 0 0 0-.58-.122l-2.19.547a1.75 1.75 0 0 1-1.657-.459L5.482 8.062a1.75 1.75 0 0 1-.46-1.657l.548-2.19a.68.68 0 0 0-.122-.58zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877zm10.762.135a.5.5 0 0 1 .708 0l2.5 2.5a.5.5 0 0 1 0 .708l-2.5 2.5a.5.5 0 0 1-.708-.708L14.293 4H9.5a.5.5 0 0 1 0-1h4.793l-1.647-1.646a.5.5 0 0 1 0-.708"/>
                </svg>
              </button>
              <button class="btn" type="button" @click="sendEmail(sticker)" 
                v-if="sticker.contact_email"
              >
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                  <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z"/>
                </svg>
              </button>
            </div>
          </div>
      </div>
    </div>
  </div>
</template>

<script>
  const isEmpty = obj => [Object, Array].includes((obj || {}).constructor) && !Object.entries((obj || {})).length;
  export default {
    data: function () {
      return {
        stickers: [],
      }
    },
    async created() {
      await this.$store.dispatch('httpRequest', {
        url: '/home/globus',
        method: 'POST',
        data: null,
        mutation: 'setStickers'
      });
      this.stickers = this.$store.getters.activeStickers;
    },
    methods: {
      imagePath(sticker) {
        return this.$store.getters.findOrFail(sticker, 'attachments.0.media.path')
          .replace('public', '/storage');
      },
      showSticker(id) {
        this.$router.push('/stickers/' + id)
      },
      phoneCall(sticker) {
        window.open('tel://' + sticker.contact_phone);
      },
      sendEmail(sticker) {
        window.open('mailto:' + sticker.contact_email, '_system');
      }
    },
    computed: {
    }
  }
</script>
<style scoped>
  .blur {
    backdrop-filter: blur(10px);
  }
  .img-fixed-height {
    width: 100%;
    height: 200px;
    object-fit: cover;
  }
  .contact-link {
    margin-right: 10px;
  }
  .sticker-link {
    cursor: pointer;
  }
</style>