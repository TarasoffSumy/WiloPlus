
<script>
import { Line, Bar } from 'vue-chartjs'

export default {
  props: ['WorkPoint', 'CalcPoint', 'Hnas', 'Hsis'],
  extends: Line,
  mounted () {
  this.renderChart({  
      type: 'line',
      datasets: [
      { 
        label: 'Напір насоса',
        backgroundColor: 'transparent',
        borderColor: '#ef9119',
        data: this.Hnas,
      },
      { 
        label: 'Напір системи',
        backgroundColor: 'transparent',
        borderColor: '#3283d5',
        data: this.Hsis,
      },
      {
        label: 'Фактична точка',
        backgroundColor: 'transparent', 
        pointStyle: 'star',
        radius: 10,
        borderColor: 'red',
        data: this.WorkPoint,
        borderWidth: 3
      },
      {
        label: 'Розрахована точка',
        backgroundColor: 'transparent', 
        pointStyle: 'rectRot',
        radius: 15,
        borderColor: 'green',
        data:this.CalcPoint,
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
    lineTension: 1,
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: true,
          padding: 5,
        }
      }],
        xAxes: [{
                type: 'linear',
                beginAtZero: true,
                max: 50,
                position: 'bottom'
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
