<template>
  <v-system-bar 
    color="transparent"
    style="padding: 15px 0;justify-content:center;top:200px;backdrop-filter: blur(10px);background-color:transparent;"
    class="rounded"
    elevation="10"
  >
    <v-table style="width: 100%;" theme="dark">
      <thead>
        <tr>
          <th class="text-left">
            {{ $t('Work title') }}
          </th>
          <th class="text-left">
            {{ $t('Unit') }}
          </th>
          <th class="text-left">
            {{ $t('Price per unit') }}
          </th>
          <th class="text-left">
            {{ $t('Q-ty') }}
          </th>
          <th class="text-left">
            {{ $t('Cost') }}
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            <v-autocomplete
              v-model="currentWorkId"
              :items="allWorks"
              item-title="title"
              item-value="id"
              density="compact"
              @update:modelValue="findWork"
              :closeOnSelect="true"
              :menu-props="{ top: true, offsetY: true }"
              clearable
            ></v-autocomplete>
          </td>
          <td> {{ currentWork?.unit }} </td>
          <td> {{ currentWork?.price }} </td>
          <td>
            <v-text-field 
              type="number"
              v-model="currentQty"
              min="0"
              clearable
            >           
            </v-text-field>
          </td>
          <td>  {{ currentCost}} </td>
        </tr>
      </tbody>
    </v-table>
  </v-system-bar>
<!--   <v-data-table :headers="tableHeaders" :items="allWorks" item-key="title" class="elevation-1">
      <template v-slot:item.action="{ item }">
        <v-btn
          icon="mdi-square-edit-outline"
          @click="editWork(item)"
          style="margin: 0 1%;"
          :title="$t('Edit')"
          v-if="$auth.check('super')"
        >
        </v-btn>
        <v-btn
          icon="mdi-delete-forever-outline"
          @click="deleteWork(item)"
          style="margin: 0 1%;"
          :title="$t('Delete')"
          v-if="$auth.check('super')"
        >
        </v-btn>
      </template>
  </v-data-table> -->



</template>

<script>
  export default {
    data: function () {
      return {
        allWorks: [],
        selectedWorks: [],
        currentWorkId: null,
        currentWork: {},
        currentQty: 0
      }
    },
    async created() {
      await this.$store.dispatch('httpRequest', {
        url: '/works',
        method: 'GET',
        data: null,
        mutation: 'setWorks'
      });
      this.allWorks = this.$store.getters.allWorks.filter(work => (work.category === 'electrics.cabling'));
      this.currentWork = this.allWorks[0];
      this.currentWorkId = this.currentWork.id;
    },
    methods: {
      findWork(id) {
        this.currentWork = this.$store.getters.workById(id);
      }
    },
    computed: {
      currentCost() {
        if (this.currentWork?.price) {
          return this.currentWork.price * this.currentQty;
        } else {
          return 0;
        }
      }
    }
  }
</script>
<style scoped>

</style>