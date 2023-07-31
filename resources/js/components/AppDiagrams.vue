<template>
  <h1> Нечто ни о чем </h1>
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
        //
      });
  } 
}
</script>