<template>
  <h1> Diagram page {{ diagram.id }}</h1> 
  <h2>Хорошо</h2>
</template>
<script>
    export default {
      data: function () {
        return {
          diagram: {}
        }
      },
      mounted() {
        this.diagram.id = this.$route.params.id
      }
    } 
</script>