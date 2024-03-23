<template>
    <v-btn 
    density="compact" 
    icon="mdi-menu-open"
    style="position:fixed;top:113px;right:5px;z-index: 10005;opacity: 0.2;"
    @click="showToolbar=!showToolbar"
    :title="$t('Toolbar')"
  >
  </v-btn>

  <Transition name="slide-fade">
    <v-system-bar 
      color="transparent"
      style="padding: 15px 0;justify-content:center;top:187px;backdrop-filter: blur(10px);background-color:transparent;"
      class="rounded"
      elevation="10"
      v-show="showToolbar"
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
              <v-select
                :label="$t('Category')"
                v-model="selectedCategory"
                :items="categories"
                @update:modelValue="changeCategory"
              > 
              </v-select>
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>
                    <v-icon
          size="x-large"
          color="black"
          :title="$t('Hide')"
          icon="mdi-menu-right-outline"
          @click="showToolbar=false"
          style="left:10px;"
        ></v-icon>
            </td>
          </tr>
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
                :label="$t('Work')"
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
            <td>
              <v-btn
                :disabled="(currentQty == 0)"
                icon="mdi-playlist-plus"
                @click="addWork"
                :title="$t('Add work')"
              >
              </v-btn>
            </td>
          </tr>
        </tbody>
      </v-table>
    </v-system-bar>
  </Transition>

  <v-table
    elevation="10"
    v-if="selectedWorks.length"
    :style="dataTableStyle"
  >
    <tbody>
      <tr v-for="selectedWork in selectedWorks" :key="selectedWork.id">
        <td>{{ selectedWork.title }}</td>
        <td>{{ selectedWork.unit }}</td>
        <td>{{ selectedWork.price }}</td>
        <td>
          <v-text-field 
            type="number"
            v-model="selectedWork.qty"
            style="max-width: 100px;"
            hide-details
          >           
          </v-text-field>
        </td>
        <td>{{ selectedWork.qty * selectedWork.price }}</td>
      </tr>
    </tbody>
  </v-table>

  <v-divider v-show="selectedWorks.length"></v-divider>
  <v-btn 
    density="compact" 
    icon="mdi-content-save" 
    style="margin: 0 12px;"
    @click="submitCalculation"
    :title="$t('Save')"
    v-show="selectedWorks.length"
  >      
  </v-btn>

  <v-dialog
    v-model="modal"
    width="80vw"
  >
    <v-card
      elevation="4"
      rounded
    >
      <v-card-text>
        <v-text-field 
          :label="$t('Denotation')"
          v-model="calculationData.name"
          :error-messages="errors.name"
        >
        </v-text-field>           
          <v-text-field 
          type="number"
          :label="$t('Working days')"
          v-model="calculationData.days"
          :error-messages="errors.days"
        >           
        </v-text-field>
        <v-textarea 
          :label="$t('Comments')"
          v-model="calculationData.comments"
          :error-messages="errors.comments"
        >   
        </v-textarea>
        <v-btn @click="submit">{{ $t('Save') }}</v-btn>
      </v-card-text>
    </v-card>
  </v-dialog>

</template>

<script>
  export default {
    data: function () {
      return {
        calculationData: {},
        selectedWorks: [],
        currentWorkId: null,
        currentWork: {},
        currentQty: 0,
        selectedCategory: 'electrics.cabling',
        specialization: 'electrics',
        showToolbar: true,
        modal: false,
        errors: {}
      }
    },
    async created() {
      await this.$store.dispatch('httpRequest', {
        url: '/works',
        method: 'GET',
        data: null,
        mutation: 'setWorks'
      });
      await this.$store.dispatch('httpRequest', {
        url: '/calculations',
        method: 'GET',
        data: null,
        mutation: ''
      });
      await this.$store.dispatch('httpRequest', {
        url: '/customers',
        method: 'GET',
        data: null,
        mutation: ''
      });
      this.currentWork = this.allWorks[0];
      this.currentWorkId = this.currentWork.id;
    },
    methods: {
      findWork(id) {
        this.currentWork = this.$store.getters.workById(id);
      },
      changeCategory(cat) {
        this.selectedCategory = cat;
        this.currentWork = this.allWorks[0];
        this.currentWorkId = this.currentWork.id;
      },
      addWork() {
        let newItem = Object.assign({}, this.currentWork);
        newItem.qty = parseInt(this.currentQty);
        this.selectedWorks.push(newItem);
        this.currentQty = 0;
      },
      submitCalculation() {
        this.modal = true;
      },
      async submit() {
        this.calculationData.works = JSON.stringify(this.selectedWorks);
        this.calculationData.customer_id = 1;
        this.calculationData.sum = 1;
        let method = !!this.calculationData.id ? 'PUT' : 'POST';
        let url = !!this.calculationData.id ? '/calculations/' + this.calculationData.id : '/calculations';
        await this.$store.dispatch('httpRequest', {
          url: url,
          method: method,
          data: this.calculationData,
          mutation: ''
        });
      this.errors = this.$store.getters.httpErrors;
      }
    },
    computed: {
      allWorks() {
        return this.$store.getters.allWorks.filter(work => (work.category === this.selectedCategory));
      },
      currentCost() {
        if (this.currentWork?.price) {
          return this.currentWork.price * this.currentQty;
        } else {
          return 0;
        }
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
      },
      dataTableStyle() {
        let mt = this.showToolbar ? 'margin-top:210px;' : 'margin-top:0;';
        return 'transition: margin 700ms;' + mt;
      }
    }
  }
</script>
<style scoped>
  .slide-fade-enter-active {
    transition: all 0.7s ease-out;
  }

  .slide-fade-leave-active {
    transition: all 0.7s cubic-bezier(1, 0.5, 0.8, 1);
  }

  .slide-fade-enter-from,
  .slide-fade-leave-to {
    transform: translateX(20px);
    opacity: 0;
  }
.bounce-enter-active {
  animation: bounce-in 0.5s;
}
.bounce-leave-active {
  animation: bounce-in 0.5s reverse;
}
@keyframes bounce-in {
  0% {
    transform: scale(0);
  }
  50% {
    transform: scale(1.25);
  }
  100% {
    transform: scale(1);
  }
}
</style>