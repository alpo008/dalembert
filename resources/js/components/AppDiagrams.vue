<template>
  <h1> Temporary test page</h1>
  <app-media-upload-form></app-media-upload-form>
</template>
<script>
import AppMediaUploadForm from './AppMediaUploadForm';
export default {
  components: {
    AppMediaUploadForm
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