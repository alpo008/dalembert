<template>
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



        <v-btn variant="text" icon="mdi-filter"></v-btn>

        <v-btn variant="text" icon="mdi-dots-vertical"></v-btn>
      </v-app-bar>

      <v-system-bar color="primary" style="margin-top:1px;height:32px;">
        <widget-weather/>
        <v-icon icon="mdi-wifi-strength-4" class="ms-2"></v-icon>

        <v-icon icon="mdi-signal-cellular-outline" class="ms-2"></v-icon>

        <v-icon icon="mdi-battery" class="ms-2"></v-icon>

        <span class="ms-2">08:30</span>
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
      }
    }
  }
</script>