<template>
  <div @click="$router.go(-1)">S T I C K E R</div>
</template>
<script>
  export default {
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
    }
  }
</script>
<style scoped>
    .blur {
      backdrop-filter: blur(10px);
    }
</style>