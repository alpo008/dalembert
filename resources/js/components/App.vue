<template>
  <v-alert
  v-if="showAlert"
  color="warning"
  style="z-index:1005;"
  icon="$warning"
  :title="$t('Alert')"
  :text="genericErrors.toString()"
  closable
  ></v-alert>
  <v-card>
    <v-layout>
      <v-app-bar
        color="primary"
        prominent
      >
        <v-app-bar-nav-icon variant="text" @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
          
          <v-text-field 
            density="compact"
            label=""
            append-inner-icon="mdi-magnify"
            single-line
            hide-details
            @keyup="updateSearchString"
            v-model="searchString"
          >
          </v-text-field>

        <v-btn variant="text" icon="mdi-login" to="/login" v-if="!$auth.check()"></v-btn>
        <v-btn variant="text" icon="mdi-logout" @click="logout" v-if="$auth.check()"></v-btn>
      </v-app-bar>

      <v-system-bar color="primary" style="margin-top:1px;height:32px;" v-if="showWeather">
        <widget-weather/>
      </v-system-bar>

      <v-navigation-drawer
        v-model="drawer"
        location="start"
        temporary
      >
        <v-list>
          <v-list-item
            v-for="item of items"
            :key="item.title"
            :to="item.url"
            @click.prevent=""
            exact
          >
            <router-link :to="item.url"> {{ item.title }} </router-link>
          </v-list-item>
          <v-list-item title="Exit" @click="switchOff"></v-list-item>
        </v-list>
      </v-navigation-drawer>

      <v-main style="height: 300vh;">
        <v-card-text>
          <router-view></router-view>
        </v-card-text>
      </v-main>
    </v-layout>
  </v-card>  
</template>

<script>
  const isEmpty = obj => [Object, Array].includes((obj || {}).constructor) && !Object.entries((obj || {})).length;
  import WidgetWeather from './widgets/WidgetWeather.vue'
  export default {
    components: {
      WidgetWeather
    },
    data: function () {
      return {
        drawer: false,
        group: null,
        searchString: '',
        showWeather: false,
        items: [
          {
            title: 'Home',
            url: '/',
          },
          {
            title: 'Diagrams',
            url: '/diagrams',
          },
          {
            title: 'Diagram 1',
            url: '/diagrams/1',
          },
          {
            title: 'Airmax Clients',
            url: '/airmax',
          }
        ],
        time: ''
      }
    },
    mounted() {
      this.showWeather = false;
      this.$store.dispatch('updateWeather').then(
        () => {
          let weather = this.$store.getters.weather;
          this.showWeather = weather.is_ready;
        }
      ).catch(err => console.warn(`ERROR(${err.code}): ${err.message}`));
    },
    watch: {
      $route(to, from) {
        this.searchString = '';
        this.$store.commit('setSearchKey', this.searchString);
      }
    },
    methods: {
      switchOff() {
        navigator.app.exitApp();
      },
      updateSearchString(e) {
        this.$store.commit('setSearchKey', this.searchString);
      },
      logout() {
        this.$auth.logout({
            makeRequest: true,
            redirect: {name: 'login'},
        }).catch(e => console.log(e));
      }
    },
    computed: {
      genericErrors() {
        let errors = this.$store.getters.httpErrors;
        if (typeof(errors.generic) === 'object') {
          return errors.generic.map(message => this.$t(message));
        } else {
          return [];
        }
      },
      showAlert() {
        return !isEmpty(this.genericErrors);
      }
    }
  }
</script>