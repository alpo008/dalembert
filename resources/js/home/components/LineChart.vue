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
import { Chart as ChartJS, Title, Tooltip, Legend, LineElement, CategoryScale, LinearScale, PointElement, Filler } from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, LineElement, CategoryScale, LinearScale, PointElement, Filler)

export default {
  name: 'LineChart',
  components: { Line },
  props: ['history'],
  data() {
    return {
      chartOptions: {
        responsive: true,
        maintainAspectRatio: false,
        // Всплывающая подсказка появляется сразу при наведении на любую вертикаль (очень удобно для графиков)
        interaction: {
          mode: 'index',
          intersect: false,
        },
        plugins: {
          legend: {
            labels: {
              color: '#e2e8f0', // Светлый, хорошо читаемый текст легенды
              font: {
                size: 13,
                weight: '500'
              },
              usePointStyle: true, // Аккуратные кружочки вместо прямоугольников в легенде
              padding: 16
            }
          },
          tooltip: {
            backgroundColor: 'rgba(15, 23, 42, 0.92)', // Темно-синяя полупрозрачная подложка
            titleColor: '#f8fafc',
            bodyColor: '#cbd5e1',
            borderColor: 'rgba(255, 255, 255, 0.15)',
            borderWidth: 1,
            padding: 10,
            cornerRadius: 8
          }
        },
        scales: {
          x: {
            grid: {
              color: 'rgba(255, 255, 255, 0.06)', // Еле заметная вертикальная сетка
              drawBorder: false
            },
            ticks: {
              color: '#94a3b8', // Четкий светло-серый цвет дат
              font: { size: 11 },
              maxTicksLimit: 10, // Автоматически прореживает подписи, чтобы они не слипались
              maxRotation: 0,    // Горизонтальный текст (читается гораздо легче, чем под углом)
              autoSkip: true
            }
          },
          y: {
            grid: {
              color: 'rgba(255, 255, 255, 0.08)', // Мягкие горизонтальные линии
              drawBorder: false
            },
            ticks: {
              color: '#94a3b8', // Светлые цифры значений
              font: { size: 12 },
              padding: 8
            }
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