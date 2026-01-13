<template>
  <h1> {{ $t('Customers') }}</h1>
    <v-btn 
    density="compact" 
    icon="mdi-menu-open"
    style="position:fixed;top:113px;right:5px;"
    @click="showToolbar=true"
    :title="$t('Toolbar')"
  >
  </v-btn>
  <Transition name="slide-fade">
    <v-system-bar 
      style="height:50px;top:100px;padding: 0 2%;justify-content:center;width: calc((100% - 0px) - 0px);backdrop-filter: blur(10px);background-color:rgba(255,255,255, 0.3);"
      class="rounded"
      elevation="10"
      v-show="showToolbar"
    >
      <v-spacer></v-spacer>
      <v-btn
        icon="mdi-account-plus-outline"
        to="/customers/0"
        :title="$t('New customer')"
        style="margin-left:5px;"
      >
      </v-btn>
      <v-icon
        size="x-large"
        color="black"
        :title="$t('Hide')"
        icon="mdi-menu-right-outline"
        @click="showToolbar=false"
        style="left:10px;"
      ></v-icon>
    </v-system-bar>
  </Transition>
  <v-data-table :headers="tableHeaders" :items="allCustomers" item-key="title" class="elevation-1" style="margin-top:30px;">
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
      showToolbar: false
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