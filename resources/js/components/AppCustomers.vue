<template>
  <h1> {{ $t('Customers') }}</h1>
  <v-data-table :headers="tableHeaders" :items="allCustomers" item-key="title" class="elevation-1">
    <template v-slot:item.name="{ item }">
      <v-chip variant="elevated" :to="'/customers/'+ getCustomer(item, 'id')"
        color="success">
        {{ getCustomer(item, 'name') }}
      </v-chip>
    </template>
    <template v-slot:item.address="{ item }">
      <div class="text-truncate" style="max-width: 130px;">
         {{ getCustomer(item, 'address') }}
      </div>
    </template>
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
          title: this.$t('Address'),
          align: 'left',
          key: 'address'
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
    this.customers = this.$store.getters.allCustomers
  },
  methods: {
    test(tableItem) {
    },
    getCustomer(value, param) {
      return value.raw[param];
    },
  },
  computed: {
    allCustomers() {
      const allCustomers = this.$store.getters.allCustomers;
      const searchString = this.$store.getters.searchKey.toLowerCase();
      return allCustomers.filter(customer => {
        return (!!customer.name && customer.name.toLowerCase().indexOf(searchString) !== -1)
      });
    },
    notEmpty() {
      return this.allCustomers.length;
    }
  },
}

</script>;