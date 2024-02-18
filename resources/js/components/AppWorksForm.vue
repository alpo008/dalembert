<template>  
  <v-select
    :label="$t('Category')"
    v-model="workData.category"
    :error-messages="errors.category"
    :items="categories"
  >    
  </v-select>
  <v-text-field 
    type="text"
    :label="$t('Work title')"
    v-model="workData.title"
    :error-messages="errors.title"
    counter="50"
  >
  </v-text-field>
    <v-text-field 
    type="number"
    :label="$t('Price per unit')"
    v-model="workData.price"
    :error-messages="errors.price"
  >           
  </v-text-field>
  <v-select
    :label="$t('Unit')"
    v-model="workData.unit"
    :error-messages="errors.unit"
    :items="units"
  >    
  </v-select>
  <v-textarea 
    :label="$t('Comments')"
    v-model="workData.comments"
    :error-messages="errors.comments"
  >   
  </v-textarea>
  <v-btn @click="submit">{{ $t('Save') }}</v-btn>
</template>

<script>
export default {
  props: {
    work: Object
  },
  data: function () {
    return {
      workData: {
        title: '',
        price: null,
        unit: this.$t('pcs'),
        category: 'generic',
        comments: ''
      },
      rootCategory: 'electrics',
      errors: {}
    }
  },
  mounted() {
    this.workData = this.work;
  },
  methods: {
    async submit() {
/*      await this.$store.dispatch('httpRequest', {
        url: '/attachments',
        method: 'POST',
        data: formData,
        mutation: 'setCurrentDocument'
      });*/
      this.errors = this.$store.getters.httpErrors;
    }
  },
  computed: {
    units() {
      const workUnits = `${process.env.MIX_WORK_UNITS}`;
      let units = JSON.parse(workUnits);
      return units.map(i => this.$t(i));
    },
    categories() {
      const workCategories = `${process.env.MIX_WORK_CATEGORIES}`;
      let cats = JSON.parse(workCategories);
      let subCats = cats.filter(cat => cat.indexOf(this.rootCategory) !== -1);
      const result = [];
      subCats.forEach(el => {
        let value = el;
        let title = this.$t(el.replace(this.rootCategory + '.', ''));
        result.push({title, value});
      });
      return result;
    }
  }
}
</script>