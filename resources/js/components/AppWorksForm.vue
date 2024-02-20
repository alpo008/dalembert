<template>  
  <v-select
    :label="$t('Specialization')"
    v-model="specialization"
    :items="specializations"
    :error-messages="errors.specialization"
    @update:modelValue="checkCategory"
  >    
  </v-select>
  <v-select
    :label="$t('Category')"
    v-model="workData.category"
    :error-messages="errors.category"
    :items="categories"
    @update:modelValue="checkCategory"
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
      specialization: 'electrics',
      errors: {}
    }
  },
  mounted() {
    this.workData = this.work;
    if (this.workData.category === 'generic') {
      this.workData.category = this.specialization + '.' + this.workData.category;
    }
  },
  methods: {
    async submit() {
      let method = !!this.workData.id ? 'PUT' : 'POST';
      let url = !!this.workData.id ? '/works/' + this.workData.id : '/works';
      await this.$store.dispatch('httpRequest', {
        url: url,
        method: method,
        data: this.workData,
        mutation: 'setCurrentWork'
      });
      this.errors = this.$store.getters.httpErrors;
    },
    checkCategory() {
      this.errors.specialization = [];
      if(this.workData.category.indexOf(this.specialization) === -1) {
        this.errors.specialization = [this.$t('Specialization does not match')]
      }
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
      let subCats = cats.filter(cat => cat.indexOf(this.specialization) !== -1);
      const result = [];
      subCats.forEach(el => {
        let value = el;
        let title = this.$t(el.replace(this.specialization + '.', ''));
        result.push({title, value});
      });
      return result;
    },
    specializations() {
      const workSpecializations = `${process.env.MIX_WORK_SPECIALIZATIONS}`;
      let specs = JSON.parse(workSpecializations);
      const result = [];
      specs.forEach(el => {
        let value = el;
        let title = this.$t(el);
        result.push({title, value});
      });
      return result;    
    }
  }
}
</script>