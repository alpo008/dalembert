<template>
  <Line
    id="history_chart"
    :options="chartOptions"
    :data="history"
    width="100%"
  />
</template>

<script>
import { Line } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, LineElement, CategoryScale, LinearScale, PointElement } from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, LineElement, CategoryScale, LinearScale, PointElement)

export default {
  name: 'LineChart',
  components: { Line },
  props: ['history'],
  data() {
    return {
      chartOptions: {
        responsive: true,
        elements: {
          line: {
            cubicInterpolationMode: 'monotone'
          },
          point: {
            hitRadius: 5,
            hoverRadius: 6
          }
        }
      }
    }
  },
  beforeCreate(){
  },
  mounted() {
  }
}
</script>

<style scoped>
  #history_chart {
    max-height: -webkit-fill-available;
    background-image: radial-gradient(circle, #4A4A4A 0%, #414151 70%, #0D0D0D 100%);
  }
</style>