<template>
  <h1> Diagram page {{ customerId }}</h1> 
  <h2>Хорошо</h2>
</template>
<script>
    export default {
      data: function () {
        return {
          customerData: {},
        }
      },
      created() {
        this.customerId = this.$route.params.id
      },
      computed: {
        editable() {
          return this.$store.getters.canEdit;
        }
      },
      watch: {
          "$store.state.general.editorMode"(e) {
        }
      }
    } 
</script>