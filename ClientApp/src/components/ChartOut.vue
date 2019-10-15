
<script>
import { Line, Bar } from 'vue-chartjs'

export default {
  props: ['dataOut', "service_dictionary"],
  extends: Line,

  mounted () {
  this.renderChart({
      datasets: [
      {
        label:  this.service_dictionary[126],
        radius: 1,
        tension: 0.4,
        backgroundColor: 'transparent',
        borderColor: '#ef9119',
        data: [
            {x:	0.5	, y:	20	},
            {x:	0.5	, y:	210	},
            {x:	1	, y:	200	},
            {x:	1.5	, y:	290	},
            {x:	2	, y:	280	},
            {x:	2.5	, y:	270	},
            {x:	3	, y:	270	},
            {x:	3.5	, y:	260	},
            {x:	4	, y:	250	},
            {x:	4.5	, y:	240	},
            {x:	5	, y:	230	},
            {x:	5.5	, y:	210	},
            {x:	6	, y:	200	},
            {x:	6.5	, y:	190	},
            {x:	7	, y:	170	},
            {x:	7.5	, y:	170	},
            {x:	8	, y:	170	},
            {x:	8.5	, y:	160	},
            {x:	9	, y:	160	},
            {x:	9.5	, y:	160	},
            {x:	10	, y:	150	},
            {x:	10.5	, y:	150	},
            {x:	11	, y:	140	},
            {x:	11.5	, y:	130	},
            {x:	12	, y:	120	},
            {x:	12.5	, y:	120	},
            {x:	13	, y:	120	},
            {x:	13.5	, y:	120	},
            {x:	14	, y:	110	},
            {x:	14.5	, y:	110	},
            {x:	15	, y:	110	},
            {x:	15.5	, y:	110	},
            {x:	16	, y:	110	},
            {x:	16.5	, y:	100	},
            {x:	17	, y:	100	},
            {x:	17	, y:	50	},
            {x:	17	, y:	20	},
            {x:	17	, y:	20	},
            {x:	0.5	, y:	20	}        
          
        ],
      },
      {
        label:  this.service_dictionary[125],
        backgroundColor: 'transparent',
        pointStyle: 'cross',
        radius: 10,
        borderColor: '#009c81',
        data: [ { x: this.dataOut.x, y: this.dataOut.y }],
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
          labelString:  this.service_dictionary[124],
        }
      }],
        xAxes: [{
                type: 'linear',
                beginAtZero: true,
                max: 50,
                position: 'bottom',
                scaleLabel: {
                  display: true,
                  labelString:  this.service_dictionary[125],
                }
            }]
    }
    })
  }
}
</script>