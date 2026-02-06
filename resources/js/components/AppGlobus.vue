<template>
  <widget-gweather/>
  <v-card class="mx-auto" 
  style="
    position: fixed;
    top: 83px;
    background: transparent;
    z-index: -1;
    justify-self: flex-end;
    align-self: anchor-center;
  ">
    <v-container fluid>
      <v-row dense>
        <v-col
          v-for="card in cards"
          :key="card.title"
          max-width="360"
        >
          <v-card theme="dark" style="background-color:rgba(33,33,33, 0.4);">
            <v-img
              :src="card.src"
              class="white--text align-end"
              gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
              height="200px"
            >
              <v-card-title v-text="card.title"></v-card-title>
              <v-card-text v-text="card.text"></v-card-text>
            </v-img>

            <v-card-actions>
              <v-spacer></v-spacer>

              <v-btn icon>
                <v-icon>mdi-heart</v-icon>
              </v-btn>

              <v-btn icon>
                <v-icon>mdi-bookmark</v-icon>
              </v-btn>

              <v-btn icon>
                <v-icon>mdi-share-variant</v-icon>
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </v-card>
</template>
<script>
  const isEmpty = obj => [Object, Array].includes((obj || {}).constructor) && !Object.entries((obj || {})).length;
  import WidgetGweather from './widgets/WidgetGweather.vue'
  export default {
    components: {
      WidgetGweather
    },
    data: function () {
      return {
        cards: [
          { 
            title: 'Pre-fab homes', 
            src: 'https://cdn.vuetifyjs.com/images/cards/house.jpg',
            text: 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis, doloribus, repellat. Suscipit tenetur doloribus corrupti molestiae, aspernatur fugiat. Animi sapiente alias, quam. Quos animi porro enim eveniet cum ab iure.', 
            flex: 6 
          },
          { title: 'Favorite road trips', 
            src: 'https://cdn.vuetifyjs.com/images/cards/road.jpg',
            text: 'Suscipit tenetur doloribus corrupti molestiae, aspernatur fugiat. Animi sapiente alias, quam. Quos animi porro enim eveniet cum ab iure.', 
            flex: 6 
          },
          { 
            title: 'Best airlines', 
            src: 'https://cdn.vuetifyjs.com/images/cards/plane.jpg',
            text: 'Animi sapiente alias, quam. Quos animi porro enim eveniet cum ab iure.', 
            flex: 6 
          },
        ]
      }
    },
    async created() {
    },
    methods: {
    },
    computed: {
    }
  }
</script>
<style scoped>
    .blur {
      backdrop-filter: blur(10px);
    }
</style>