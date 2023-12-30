<template>
  <h1> Temporary test page</h1>
</template>
<script>
export default {
  components: {
  },
  data: function () {
    return {
      diagrams: {},
      _file: null
    }
  },
  mounted() {
    axios
      .get('/diagrams')
      .then(response => {
        //
      });
  },
}

</script>