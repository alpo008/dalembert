<template>
  <widget-gweather/>

<v-carousel 
  show-arrows="hover"
  interval="10000"
  cycle
  v-if="stickers.length && showStickers" 
  class="position-fixed" 
  style="z-index:-1;top:98px;height:80vh;"
  >
  <v-carousel-item
    v-for="(sticker, i) in stickers"
    :key="i"
    :src="imagePath(sticker)"
  >
    <v-sheet
      color="rgba(128,128,128,0.4)"
      height="100%"
      tile
      style="justify-items:center;"
    >
      <div class="d-flex flex-column justify-end fill-height pb-8 w-75" style="filter:invert(1);">
        <div class="text-h6" v-if="!!sticker.message">
          {{ sticker.message }}
        </div>
        <div class="text-h6 d-flex justify-start w-100">
          {{ sticker.contact_name }} &nbsp;
          <v-btn 
            density="comfortable"
            color="rgba(220,220,220,0.3)"
            icon="mdi-phone" 
            v-if="!!sticker.contact_phone"
            @click="phoneCall(sticker)"
            >
          </v-btn>
          &nbsp;
          <v-btn 
            density="comfortable"
            color="rgba(220,220,220,0.3)"
            icon="mdi-email-fast-outline" 
            v-if="!!sticker.contact_email"
            @click="sendEmail(sticker)"
            >
          </v-btn>
        </div>
      </div>
    </v-sheet>
  </v-carousel-item>
</v-carousel>
</template>
<script>
  const isEmpty = obj => [Object, Array].includes((obj || {}).constructor) && !Object.entries((obj || {})).length;
  import WidgetGweather from './widgets/WidgetGweather.vue'
  export default {
    components: {
      WidgetGweather
    },
    data: function () {
      return {
        stickers: [],
        showStickers: true
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
      hasImage(sticker) {
        let attachment = sticker.attachments[0];
        if (typeof attachment === 'undefined' || typeof attachment.media === 'undefined') {
          return false;
        }
        return true;
      },
      imagePath(sticker) {
        if (this.hasImage(sticker)) {
          return sticker.attachments[0].media.path.replace('public', '/storage');
        } else {
        return null;
        }
      },
      phoneCall(sticker) {
        window.open('tel://' + sticker.contact_phone);
      },
      sendEmail(sticker) {
        window.open('mailto:' + sticker.contact_email, '_system');
      }
    },
    computed: {
    },
    watch: {
      "$store.state.globus.meteoMode"(payload) {
        this.showStickers = payload;
      }
    }
  }
</script>
<style scoped>
    .blur {
      backdrop-filter: blur(10px);
    }
</style>