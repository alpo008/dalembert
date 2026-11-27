<template>
  <Line
    id="history_chart"
    :key="type"
    :options="chartOptions"
    :data="history"
    width="100%"
  />
</template>

<script>
  import { Line } from 'vue-chartjs';
  import { Chart as ChartJS, Title, Tooltip, Legend, LineElement, CategoryScale, LinearScale, PointElement, Filler } from 'chart.js';
  import defaultChartOptions from './defaultChartOptions';

  ChartJS.register(
    Title, Tooltip, Legend, LineElement, CategoryScale, LinearScale, PointElement, Filler
  );

  export default {
    name: 'LineChart',
    components: { Line },
    props: ['history', 'type'],
    data() {
      return {
      }
    },
    beforeCreate(){
    },
    mounted() {
    },
    computed: {
      chartOptions() {
        // Глубокая копия: гарантирует, что defaultChartOptions никогда не мутируется!
        const options = structuredClone(defaultChartOptions);

        switch(this.type) {
          case 'pressure':
            options.scales.y = {
              ...options.scales.y, // сохраняем базовые ticks (цвет и шрифт) из defaultChartOptions!
              beginAtZero: false,
              grace: '10%',
              grid: {
                color: (ctx) => (ctx.tick && ctx.tick.value === 750 ? 'rgba(52, 211, 153, 0.45)' : 'rgba(255, 255, 255, 0.08)'),
                lineWidth: (ctx) => (ctx.tick && ctx.tick.value === 750 ? 1.5 : 1)
              }
            };
            break;

          case 'wind':
            options.plugins.tooltip.callbacks = {
              afterBody: (items) => {
                const windItem = items[1] || items[0];
                if (!windItem) return '';

                let direction = this.$store.getters.findOrFail(
                  windItem,
                  'dataset.directions.' + windItem.dataIndex
                );
                let rumb = this.$store.getters.findOrFail(
                  windItem,
                  'dataset.rumbs.' + windItem.dataIndex
                );

                // Если датчик не передал направление в этой точке — ничего не выводим
                if (direction == null && rumb == null) return '';

                return this.$store.getters.t('Direction') + ' : ' + rumb + ' (' + direction +
                  ' ' + this.$store.getters.t(this.$store.getters.windDirectionUnit) + ')';
              }
            };
            break;

          case 'water_temperature':
            options.scales.y = {
              ...options.scales.y, // сохраняем базовые ticks из defaultChartOptions!
              min: 0,
              grid: {
                color: (ctx) => {
                  if (ctx.tick && ctx.tick.value === 4) {
                    return 'rgba(6, 182, 212, 0.4)';
                  }
                  return 'rgba(255, 255, 255, 0.08)';
                }
              }
            };
            break;
        }

        return options;
      }
    }
  }

</script>

<style scoped>
#history_chart {
  width: 100% !important;
  max-height: calc(100dvh - 100px); 
  background-image: radial-gradient(circle, #4A4A4A 0%, #414151 70%, #0D0D0D 100%);
}
</style>