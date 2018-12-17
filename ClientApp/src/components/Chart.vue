<script>
import { Line, Bar } from 'vue-chartjs'

export default {
  props: ['dataCart', 'options'],
  extends: Line,
  mounted () {
    this.renderChart({
      labels: [0.5, 1, 1.5, 2, 2.5, 3], 
      label: '',    
      type: 'line',
      datasets: [
      { // one line graph

        label: 'Напір',
        data: [65, 60, 55, 45, 30],
        backgroundColor: [           
          'rgba(0,156,129,.5)', // Blue
          'rgba(0,156,129,.5)',
          'rgba(0,156,129,.5)',
          'rgba(0,156,129,.5)',
          'rgba(0,156,129,.5)'
        ],
        borderColor: [
          '#36495d',
          '#36495d',
          '#36495d',
          '#36495d',
          '#36495d'
        ],
        borderWidth: 3
      },
      { // another line graph
        label: 'Робочий напір',
        type: 'line',
        data: [58, 58, 58, 58, 58],
        backgroundColor: [
          'rgba(0,156,129,.0)', // Blue
         'rgba(0,156,129,.0)'
        ],
        borderColor: [
          '#009c81',
        ],
        borderWidth: 3
      }
      ]
    },
    {
    responsive: false,
    lineTension: 1,
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: true,
          padding: 5,
        }
      }]
    }
    })
  } 
}
</script>

<style>
</style>
