<template>
  <div class="container-fluid wrapper">
  <div class="d-flex justify-content-center loader" v-if="loadingState || httpError">
    <div class="alert alert-secondary reload-link" role="alert" v-if="httpError" 
      @click="reloadPage"
     >
      {{ $t('Network error. Click to reload.') }}
    </div>
    <div class="spinner-border" role="status" v-if="!httpError">
      <span class="visually-hidden">Loading...</span>
    </div>
  </div>

  <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-with-gradient">
    <div class="container-fluid">
      <button class="navbar-toggler" 
        type="button" 
        data-bs-toggle="collapse" 
        data-bs-target="#navbarDropdownMenu" 
        aria-controls="navbarDropdownMenu" 
        aria-expanded="false" 
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarDropdownMenu">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <router-link :class="navLinkClass('Home')" aria-current="page" to="/">Home</router-link>
          </li>
          <li class="nav-item">
            <router-link :class="navLinkClass('Meteo')" to="/meteo">Meteo</router-link>
          </li>
          <li class="nav-item">
            <router-link :class="navLinkClass('Webcam')" to="/webcam">Web camera</router-link>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
          </li>
        </ul>
      </div>
      <span class="navbar-brand mb-0" style="max-width: 75%"><!--  28 symbols -->
        {{ dateString }}
      </span>
    </div>
  </nav>

  <div class="pt-70 mh-85 grey-sunny-sky">
    <router-view></router-view>
  </div>
    <footer class="py-1 bg-with-gradient">
      <div>
        <div class="marquee-container">
          <div id="dynamicMarquee" class="marquee-track">
            <span class="marquee-item px-4 text-white">
              {{ this.$store.getters.weatherTicker }}
            </span>
          </div>
        </div>
      </div>
  </footer>
</div>
</template>

<script>
  import { Collapse } from 'bootstrap';
  export default {
    components: {
    },
    data: function () {
      return {
        loadingState: false,
        httpError: false,
        collapseInstance: null,
        dateString: ''
      }
    },
    async created() {
      await this.$store.dispatch('httpRequest', {
        url: '/meteo/description',
        method: 'GET',
        data: null,
        mutation: 'setWeatherTicker'
      });
    },
    mounted() {
    },
    updated() {
      this.refreshDate();
      if (this.collapseInstance === null) {
        this.collapseInstance = new Collapse(document.getElementById("navbarDropdownMenu"),
        {toggle: false});
      }
      this.collapseInstance.hide();
      this.setupSeamlessMarquee();
    },
    methods: {
      refreshDate() {
        let date = new Date();
        let formatter = new Intl.DateTimeFormat(this.$store.getters.currentLocale, {
          weekday: 'long',
          //year: 'numeric',
          month: 'long',
          day: 'numeric'
        });
        let str =  formatter.format(date);
        this.dateString =str.charAt(0).toUpperCase() + str.slice(1);
      },
      reloadPage() {
        window.location.reload();
      },
      navLinkClass(routeName) {
        let result = 'nav-link';
        if (this.$route.name === routeName) {
          result += ' active';
        }
        return result;
      },
      setupSeamlessMarquee() {
        const track = document.getElementById('dynamicMarquee');
        if (!track) return;
        const items = Array.from(track.children);
        items.forEach(item => {
          const clone = item.cloneNode(true);
          // Optional: add a class or attribute to identify clones if needed
          clone.setAttribute('aria-hidden', 'true'); 
          track.appendChild(clone);
          if (items.length >= 32) { //TODO
            track.firstElementChild.remove();
          }
        });
      }
    },
    computed: {

    },
    watch: {
      $route(to, from) {
      },
      '$store.state.general.loading' (val) {
        this.loadingState = val;
      },
      '$store.state.general.httpError' (val) {
        this.httpError = val;
      }
    }
  }

</script>

<style scoped>
  .wrapper {
    padding: 0;
  }
  .reload-link {
    position:fixed;
    cursor: pointer;
  }
  .loader {
    width: 100vw;
    height: 100vh;
    z-index: 1000;
    align-items: center;
    position: fixed;
    backdrop-filter: blur(2px);
  }

  .bg-with-gradient {
    background-color: #0f172a;
    background-image: 
      radial-gradient(at 10% 20%, rgba(56, 189, 248, 0.3) 0px, transparent 50%),
      radial-gradient(at 90% 80%, rgba(236, 72, 153, 0.3) 0px, transparent 50%),
      radial-gradient(at 50% 50%, rgba(99, 102, 241, 0.2) 0px, transparent 50%);
  }

  .dark-water-layered {
    background: 
      radial-gradient(at 20% 20%, rgba(10, 61, 98, 0.4) 0px, transparent 50%),
      radial-gradient(at 80% 40%, rgba(0, 140, 153, 0.15) 0px, transparent 50%),
      linear-gradient(160deg, #031424 0%, #010a12 100%);
  }

  .grey-sunny-sky {
    background: radial-gradient(
      circle at 80% 20%,      /* Солнце смещено чуть выше центра */
      #fffde6 0%,             /* Мягкий тепло-белый центр солнца */
      #e2e7ec 15%,            /* Светлое свечение сквозь облака */
      #9faab5 45%,            /* Основной серый цвет туч */
      #5a6570 100%            /* Темные грозовые края */
    );
  }

.marquee-container {
  width: 100%;
}

.marquee-track {
  display: flex;
  width: max-content;
  animation: scroll-left 20s linear infinite;
}

.marquee-track:hover {
  animation-play-state: paused;
}

@keyframes scroll-left {
  0% {
    transform: translateX(0);
  }
  100% {
    transform: translateX(-50%);
  }
}

</style>