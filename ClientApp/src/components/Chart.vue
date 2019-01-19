
<script>
import { Line, Bar } from 'vue-chartjs'

export default {
  props: ['dataChart'],
  extends: Line,

  mounted () {
  this.renderChart({
      datasets: [
      {
        label: 'Напір насоса',
        radius: 1,
        tension: 0.4,
        backgroundColor: 'transparent',
        borderColor: '#ef9119',
        data: this.dataChart.Hnas,
      },
      {
        label: 'Напір системи',
        radius: 1,
        tension: 0.4,
        backgroundColor: 'transparent',
        borderColor: '#3283d5',
        data: this.dataChart.Hsis,
      },
      {
        label: 'Розрахована точка',
        backgroundColor: 'transparent',
        pointStyle: 'cross',
        radius: 10,
        borderColor: 'red',
        data: this.dataChart.WorkPoint,
        borderWidth: 3
      },
      {
        label: 'Фактична точка',
        backgroundColor: 'transparent',
        pointStyle: 'cross',
        radius: 10,
        borderColor: 'green',
        data:this.dataChart.CalcPoint,
        borderWidth: 3
      }
    ]
    },
    {
    responsive: false,
    layout: {
      padding: {
                left: 0,
                right: 0,
                top: 0,
                bottom: 0
            }
    },
    legend:{
        labels:{
          usePointStyle: true,
          fontSize: 11
      }
    },
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: true,
          padding: 5
        },
        scaleLabel: {
          display: true,
          labelString: 'Напiр, м'
        }
      }],
        xAxes: [{
                type: 'linear',
                beginAtZero: true,
                max: 50,
                position: 'bottom',
                scaleLabel: {
                  display: true,
                  labelString: 'Витрата, м3/год'
                }
            }]

    }
    })
  },
  created : function(){

  }
}
</script>

<style>
</style>
