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
      .get('/diagrams')
      .then(response => {
        //console.log(response);
      });
  } 
}
</script>