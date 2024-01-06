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
  <v-card v-if="$auth.ready()">
    <v-layout>
      <v-app-bar
        color="primary"
        prominent
      >
        <v-app-bar-nav-icon variant="text" @click.stop="drawer = !drawer" v-if="$auth.check(['admin', 'super'])">
        </v-app-bar-nav-icon>
          <v-spacer v-if="!searchBar"></v-spacer>
          <v-text-field 
            density="compact"
            class="ml-1"
            label=""
            append-inner-icon="mdi-magnify"
            single-line
            hide-details
            @keyup="updateSearchString"
            v-model="searchString"
            v-if="searchBar"
          >
          </v-text-field>

        <v-menu location="bottom">
          <template v-slot:activator="{ props }">
            <v-btn
              variant="text" 
              :icon="userIcon"
              v-bind="props"
            >
            </v-btn>
          </template>

          <v-list>
            <v-list-item @click="logout" prependIcon="account-lock" v-if="$auth.check()">
              <v-list-item-title>{{ $t('Logout') }}</v-list-item-title>
            </v-list-item>
            <v-list-item to="/login" prependIcon="account-lock-open" v-if="!$auth.check()">
              <v-list-item-title>{{ $t('Log in') }}</v-list-item-title>
            </v-list-item>
            <v-list-item @click="switchOff" prependIcon="close-circle-outline">
              <v-list-item-title>{{ $t('Close') }}</v-list-item-title>
            </v-list-item>
          </v-list>
        </v-menu>
      </v-app-bar>

      <v-system-bar color="primary" style="margin-top:1px;height:32px;" v-if="showWeather">
        <widget-weather/>
      </v-system-bar>

      <v-navigation-drawer
        v-model="drawer"
        location="start"
        temporary
        v-if="$auth.check(['admin', 'super'])"
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

      <v-main style="height: auto;padding-top: 102px;">
        <v-card-text style="padding: 1rem 1px">
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
        searchBar: false,
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
        this.searchBar = !!to.meta?.searchBar;
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
        }).catch(e => console.warn(e));
      }
    },
    computed: {
      genericErrors() {
        let errors = this.$store.getters.httpErrors;
        if (typeof(errors.generic) === 'object') {
          return errors.generic;
        } else {
          return [];
        }
      },
      showAlert() {
        return !isEmpty(this.genericErrors);
      },
      userIcon() {
        let user = this.$auth.user();
        let result = 'mdi-account-outline';
        if (!!user && (user.role === 'admin' || user.role === 'super')) {
          result = 'mdi-account-star';
        }
        if (!!user && user.role === 'user') {
          result = 'mdi-account-check';
        }
        return result;
      }
    }
  }
</script>