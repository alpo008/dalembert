<template>
<v-system-bar 
    color="transparent"
    style="height:50px;top:70px;right:0;left:auto;padding: 0 2%;justify-content:center;"
    class="rounded"
  >
    <v-checkbox
      style="max-width:fit-content;" 
      class="white-label"   
      v-model="localesFilter.ru"
      hide-details
      color="success"
      label="RU"
    >
    </v-checkbox> 
    <v-checkbox
      style="max-width:fit-content;"
      class="white-label"
      v-model="localesFilter.en"
      hide-details
      color="success"
      label="EN"
    >   
    </v-checkbox>

    <v-spacer></v-spacer>
    <v-btn
      icon="mdi-note-plus-outline"
      @click="addSiteSetting"
      style="margin: 0 1%;"
      :title="$t('Add setting')"
      v-if="$auth.check('super')"
      >
    </v-btn>
  </v-system-bar>
  <v-data-table 
    :headers="tableHeaders" 
    :items="allSiteSettings" 
    item-key="id" 
    class="elevation-1 mt-5"
  >
    <template v-slot:item.action="{ item }">
      <v-btn
        icon="mdi-square-edit-outline"
        @click="editSiteSetting(item)"
        style="margin: 0 1%;"
        :title="$t('Edit')"
        v-if="$auth.check('super')"
      >
      </v-btn>
      <v-btn
        icon="mdi-delete-forever-outline"
        @click="deleteSiteSetting(item)"
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
        <v-toolbar-title>{{ $t('Site settings') }}</v-toolbar-title>

        <v-spacer></v-spacer>

        <v-btn icon @click="modal = false">
          <v-icon>mdi-close</v-icon>
        </v-btn>
      </v-toolbar>
      <v-card-text>
<!--         <app-works-form :work="currentWork"/> -->
      </v-card-text>
    </v-card>
  </v-dialog>
  <widget-confirm ref="confirm_del"></widget-confirm>

</template>

<script>
  // import AppSiteSettingsForm from './AppSiteSettingsForm';
  import WidgetConfirm from './widgets/WidgetConfirm.vue';
  export default {
    components: {
      //AppSiteSettingsForm,
      WidgetConfirm
    },
    data: function () {
      return {
        modal: false,
        localesFilter : {
          ru: true,
          en: true
        },
        tableHeaders: [
          {
            title: this.$t('Key'),
            align: 'left',
            key: 'key'
          },
          {
            title: this.$t('Locale'),
            align: 'left',
            key: 'locale'
          },
/*          {
            title: this.$t('Value'),
            align: 'center',
            key: 'value'
          },*/
          {
            title: this.$t('Comment'),
            align: 'center',
            key: 'comment'
          },
          {
            title: '',
            align: 'center',
            key: 'action'
          }
        ],
        currentSiteSetting: {}
      }
    },
    async mounted() {
      await this.$store.dispatch('httpRequest', {
        url: '/site-settings',
        method: 'GET',
        data: null,
        mutation: 'setSiteSettings'
      });
    },
    methods: {
      editSiteSetting(dataTableItem) {
        this.currentSiteSetting = dataTableItem.raw;
        this.modal = true;
      },
      addSiteSetting() {
        this.currentSiteSetting = {};
        this.modal = true;
      },
      deleteSiteSetting(dataTableItem) {
        if (!isNaN(dataTableItem.raw.id)) {
          this.$refs.confirm_del.open(this.$t('Deletion'), 
            this.$t('Are you sure?'), { color: '#ff0266' }).then((confirm) => {
            if(confirm) {
              this.$store.dispatch('httpRequest', {
                url: '/site-settings/' + dataTableItem.raw.id,
                method: 'DELETE',
                data: dataTableItem.raw,
                mutation: 'afterDeleteSiteSetting'
              });
            }
          });
        }
      }
    },
    computed: {
      allSiteSettings() {
        const allSiteSettings = this.$store.getters.allSiteSettings;
        const searchString = this.$store.getters.searchKey.toLowerCase();
        return allSiteSettings.filter(site_setting => {
          return (
            ((!!site_setting.key && site_setting.key.toLowerCase().indexOf(searchString) !== -1) ||
            (!!site_setting.comment && site_setting.comment.toLowerCase().indexOf(searchString) !== -1)) && ((this.localesFilter.ru && site_setting.locale.toLowerCase() == 'ru')
              || (this.localesFilter.en && site_setting.locale.toLowerCase() == 'en'))
          );
        });
      }
    },
    watch: {
      "$store.state.site_setting.current"() {
        this.modal = false;
      }
    }
  }
</script>
<style scoped>
  .white-label label {
    color: #fff !important;
  }
</style>