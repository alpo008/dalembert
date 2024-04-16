<template>
  <h1> Customers page</h1>
  <v-data-table :headers="tableHeaders" :items="customers" item-key="title" class="elevation-1">
    <template v-slot:item.action="{ item }">
      <v-btn
        icon="mdi-square-edit-outline"
        @click="test(item)"
        style="margin: 0 1%;"
        :title="$t('Edit')"
        v-if="$auth.check('super')"
      >
      </v-btn>
      <v-btn
        icon="mdi-delete-forever-outline"
        @click="test(item)"
        style="margin: 0 1%;"
        :title="$t('Delete')"
        v-if="$auth.check('super')"
      >
      </v-btn>
    </template>
  </v-data-table>
</template>
<script>
export default {
  components: {
  },
  data: function () {
    return {
      errors: {},
      customers: [],
      tableHeaders: [
        {
          title: this.$t('Name'),
          align: 'left',
          key: 'name'
        },
        {
          title: '',
          align: 'center',
          key: 'action'
        }
      ],
    }
  },
  async created() {
    await this.$store.dispatch('httpRequest', {
      url: '/customers',
      method: 'GET',
      data: null,
      mutation: 'setCustomers'
    });
    this.customers = this.$store.getters.allCustomers;
    console.log(this.customers)
  },
  methods: {
    test(tableItem) {
      console.log(tableItem.raw)
    }
  },
  computed: {
    allCustomers() {
      const allCustomers = this.$store.getters.allCustomers;
      console.log(allCustomers)
      const searchString = this.$store.getters.searchKey.toLowerCase();
      return allCustomers;
/*      return allCustomers.filter(customer => {
        return (!!customer.title && customer.title.toLowerCase().indexOf(searchString) !== -1)
      });*/
    },
    notEmpty() {
      return this.allCustomers.length;
    }
  },
}

</script>;