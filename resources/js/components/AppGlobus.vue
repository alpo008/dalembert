<template>
  <widget-gweather/>

<v-carousel v-if="stickers.length" class="position-fixed" style="z-index:-1;top:98px;">
  <v-carousel-item
    v-for="(sticker, i) in stickers"
    :key="i"
    :src="imagePath(sticker)"
  >
    <v-sheet
      color="rgba(128,128,128,0.4)"
      height="100%"
      tile
    >
      <div class="d-flex fill-height justify-center align-center">
        <div class="text-h2">
          {{ sticker.contact_name }}
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
        stickers: []
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
</style>