<template>
  <v-card>
    <v-layout>
      <v-app-bar
        color="primary"
        prominent
      >
        <v-app-bar-nav-icon variant="text" @click.stop="drawer = !drawer"></v-app-bar-nav-icon>

        <widget-weather/>

        <v-spacer></v-spacer>

        <v-btn variant="text" icon="mdi-filter"></v-btn>

        <v-btn variant="text" icon="mdi-dots-vertical"></v-btn>
      </v-app-bar>

      <v-navigation-drawer
        v-model="drawer"
        location="start"
        temporary
      >
        <v-list>
          <v-list-item>
            <v-text-field 
              density="compact"
              label=""
              append-inner-icon="mdi-magnify"
              single-line
              hide-details
              @keyup="test"
              v-model="searchString"
            >
            </v-text-field>
          </v-list-item>
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

      <v-main style="height: 100vh;">
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
        ]
      }
    },
    mounted() {
    },
    methods: {
      switchOff() {
        navigator.app.exitApp();
      },
      test(e) {
        this.$store.commit('setSearchKey', this.searchString);
        console.log(this.$store.getters.searchKey)
      }
    }
  }
</script>