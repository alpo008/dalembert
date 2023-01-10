<template>
  <h1> Diagrams page </h1>
</template>
<script>
export default {
  data: function () {
    return {
      diagrams: {}
    }
  },
  mounted() {
    axios
      .get('/api/diagrams/')
      .then(response => {
        this.diagrams = response.data.diagrams;
      });
  } 
}
</script>