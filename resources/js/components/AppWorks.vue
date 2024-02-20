<template>
    <v-data-table :headers="tableHeaders" :items="allWorks" item-key="title" class="elevation-1">
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
    </v-data-table>

    <v-dialog
      v-model="modal"
      width="80vw"
    >
      <v-card
        elevation="4"
        rounded
      >
        <v-toolbar
          dark
          prominent
        >
          <v-toolbar-title>{{ $t('Work') }}</v-toolbar-title>

          <v-spacer></v-spacer>

          <v-btn icon @click="modal = false">
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </v-toolbar>
        <v-card-text>
          <app-works-form :work="currentWork"/>
        </v-card-text>
      </v-card>
    </v-dialog>
    <widget-confirm ref="confirm_del"></widget-confirm>

</template>

<script>
  import AppWorksForm from './AppWorksForm';
  import WidgetConfirm from './widgets/WidgetConfirm.vue';
  export default {
    components: {
      AppWorksForm,
      WidgetConfirm
    },
    data: function () {
      return {
        modal: false,
        tableHeaders: [
          {
            title: this.$t('Work title'),
            align: 'left',
            key: 'title'
          },
          {
            title: this.$t('Unit'),
            align: 'left',
            key: 'unit'
          },
          {
            title: this.$t('Price per unit'),
            align: 'center',
            key: 'price'
          },
          {
            title: '',
            align: 'center',
            key: 'action'
          }
        ],
        currentWork: {}
      }
    },
    async created() {
      await this.$store.dispatch('httpRequest', {
        url: '/works',
        method: 'GET',
        data: null,
        mutation: 'setWorks'
      });
    },
    methods: {
      editWork(dataTableItem) {
        this.currentWork = dataTableItem.raw;
        this.modal = true;
      },
      deleteWork(dataTableItem) {
        if (!isNaN(dataTableItem.raw.id)) {
          this.$refs.confirm_del.open(this.$t('Deletion'), 
            this.$t('Are you sure?'), { color: '#ff0266' }).then((confirm) => {
            if(confirm) {
              this.$store.dispatch('httpRequest', {
                url: '/works/' + dataTableItem.raw.id,
                method: 'DELETE',
                data: dataTableItem.raw,
                mutation: 'afterDeleteWork'
              });
            }
          });
        }
      }
    },
    computed: {
      allWorks() {
        const allWorks = this.$store.getters.allWorks;
        const searchString = this.$store.getters.searchKey.toLowerCase();
        return allWorks.filter(work => {
          return (!!work.title && work.title.toLowerCase().indexOf(searchString) !== -1)
        });
      }
    },
    watch: {
      "$store.state.works.current"() {
        this.modal = false;
      }
    }
  }
</script>
<style scoped>

</style>