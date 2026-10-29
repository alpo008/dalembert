<template>
  <GoBack />
  <div class="alert mt-4">
    <div class="row mb-3" ref="rootDiv"></div>
  </div>
</template>
<script>
  import GoBack from "./GoBack.vue"
  export default {
    components: { GoBack },
    data: function () {
      return {
        html: null
      }
    },
    async mounted() {
      this.html = this.$store.getters.getContentByKey('policy:html');
      if(!this.html) {
        await this.$store.dispatch('httpRequest', {
          url: '/home/settings',
          method: 'POST',
          data: null,
          mutation: 'updateConfig'
        });
        this.html = this.$store.getters.getContentByKey('policy:html');
      }
      this.$refs.rootDiv.insertAdjacentHTML('beforeend', 
        this.html
      );
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