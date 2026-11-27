<template>
  <div class="container px-4 px-lg-5" v-if="!!$store.getters.getContentByKey('page:h1')">
    <div class="row gx-4 gx-lg-5 align-items-center my-5">
        <div class="col-lg-7"><img class="img-fluid rounded mb-4 mb-lg-0" src="/storage/stickers/home.png" alt="..." /></div>
        <div class="col-lg-5">
            <h1 class="font-weight-light"> {{ $store.getters.getContentByKey('page:h1') }}</h1>
            <p>{{ $store.getters.getContentByKey('page:text') }}</p>
        </div>
    </div>

    <div class="card text-white bg-secondary my-5 py-4 text-center">
      <div class="card-body">
        <p class="text-white text-justify m-0">
          {{ $store.getters.getContentByKey('page:card_text') }}
        </p>
      </div>
    </div>
    <!-- Content Row-->
    <div class="row gx-4 gx-lg-5">
      <div class="col-md-4 mb-5" v-for="sticker in stickers">
        <div class="card bg-dark text-white sticker-link" @click="showSticker(sticker.id)">
          <img :src="previewPath(sticker.id)" class="card-img" alt="...">
          <div class="card-img-overlay text-center align-content-center">
            <h5 class="card-title">{{ sticker.contact_name }}</h5>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
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
      this.stickers = this.$store.getters.stickersWithAttachment;
    },
    methods: {
      showSticker(id) {
        if (!isNaN(id)) {
          this.$router.push('/stickers/' + id);
        }
      },
      phoneCall(sticker) {
        window.open('tel://' + sticker.contact_phone);
      },
      sendEmail(sticker) {
        window.open('mailto:' + sticker.contact_email, '_system');
      },
      truncate(str, limit) {
        if (str.length <= limit) {
          return str;
        }
        let arr = str.split(' ').reverse();
        let truncated = '';
        while (truncated.length <= limit) {
          truncated += arr.pop() + ' ';
        }
        return truncated + ' ...';
      },
      previewPath(id) {
        let path = this.$store.getters.stickerImagePath(id, 'Preview');
        return !!path ? path : this.$store.getters.stickerFirstImagePath(id);
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
  .img-fixed-height-100 {
    width: 100%;
    height: 100px;
    object-fit: cover;
  }
  .contact-link {
    margin-right: 10px;
  }
  .sticker-link {
    cursor: pointer;
  }
  .bg-light-gray {
    background-color: #ececec;
  }
</style>