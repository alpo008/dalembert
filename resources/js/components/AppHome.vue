<template>
  <div>
    <div class="d-flex flex-row mb-6">
      <v-sheet class="ma-2 pa-2">
        <v-img src="/icons/night/10.png" width=60></v-img>
      </v-sheet>
      <v-sheet class="ma-2 pa-2">Yjdjpfdbljdcrbq</v-sheet>
      <v-sheet class="ma-2 pa-2">Flex item 3</v-sheet>
    </div>
  </div>
</template>
<script>
  export default {
    data: function () {
      return {
        weather: {}
      }
    },
    mounted() {
      axios
        .get('/home')
        .then(response => {
          console.log(response);
        });
    } 
  }
</script>
<style scoped>
    .blur {
      backdrop-filter: blur(10px);
    }
</style>