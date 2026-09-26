<template>
  <div @click="$router.go(-1)">S T I C K E R</div>
</template>
<script>
  export default {
    data: function () {
      return {
      }
    },
    async created() {
      console.log(this.$route.params.id)
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