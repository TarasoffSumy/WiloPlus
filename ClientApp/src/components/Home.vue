<template>
  <div> 
      <el-card  v-loading="loading" style="width: 100%">
      <button class="btn btn-primary pl-5 pr-5" @click="makePdf">Download PDF  </button>
     {{deliveryHead}} - {{volumeFlow}}
     {{pump}}  
     {{selectedPumpId}}
      <div style="width: 1200px; margin: auto;">
        <el-row :gutter="20" >        
        <a href="#"  class="first" @click="step(1, $event)" ><stepTile title="Витрата насоса" number="1" :class="[{ active: current==1}]" /></a>        
        <a href="#" @click="step(2, $event)"><stepTile title="Напір насоса" number="2" :class="[{ active: current==2}]"/></a> 
        <a href="#" @click="step(3, $event)"><stepTile title="Підбір насоса та приладдя" number="3"  :class="[{ active: current==3}]"/></a>
        <a href="#" @click="step(4, $event)"><stepTile slot="first" title="Пропозиції" number="4" :class="[{ active: current==4}]"/></a>
        </el-row>
    
        <transition name="flip" mode="out-in" >
        <Step1 v-if='current==1'
                :url="url" 
                :volumeFlow="volumeFlow"
                :modelFlowItems="modelFlowItems"
                :maxVolumeFlow="maxVolumeFlow"
                @onInputDataVolume="onInputDataVolume"
                @onInputFlowItems="onInputFlowItems"
                class="transition-box"/>              
        <Step2 v-else-if='current==2' 
                :url="url" 
                :deliveryHead="deliveryHead"
                :modelHeadItems="modelHeadItems"
                @onInputDataHead="onInputDataHead"
                @onInputHeadItems="onInputHeadItems"
                class="transition-box"/>         
        <Step3 v-else-if="current==3 && step3=='ready'"
                :url="url" 
                :pump="pump"
                :selectedPumpId="selectedPumpId"
                :volumeFlow="volumeFlow"
                :deliveryHead="deliveryHead"
                :dataChart="dataChart" 
                @onSaveSelectedPumpId="onSaveSelectedPumpId"
                class="transition-box"/>
        <Step4 v-else-if='current==4' 
                :url="url"
                class="transition-box"/> 
        </transition>     
    
        <el-row class="navigation-footer">
        <el-col :span="12" style="width:50%">
             <el-button :disabled="current == 1"  @click="back" type="primary" icon="el-icon-d-arrow-left">Назад </el-button>
        </el-col>
        <el-col :span="12" style="width:50%">
            <el-button :disabled="current == 4"  @click="next" type="primary">Далі <i class="el-icon-d-arrow-right el-icon-right"></i></el-button>
        </el-col>
        </el-row>       
    </div>
    </el-card>        
  </div>
</template>

<script>
import Axios from 'axios';
export default {
  name: 'Home',
  props: {
    msg: String
  },
  data () {
        return {
                loading: false,
                url:'http://www.wiloexpert.com.ua/wilo/',
                current: 1,
                refreshDataSearch:false,
                isActive: false,
                deliveryHead: 30,
                volumeFlow: 0.5,
                maxVolumeFlow: 17,
                modelFlowItems: {
                    val1:0,
                    val2:0,
                    val3:0,
                    val4:0,
                    val5:0,
                    val6:0,
                    val7:0
                },
                modelHeadItems: {
                    val1:10,
                    val2:0,
                    val3:0,
                    val4:0
                },
                pump:[],
                step3:'',   
                selectedPumpId: 0,
                dataChart: {
                    CalcPoint:'',
                    Hnas:'',
                    Hsis:'',
                    WorkPoint:''                                                
                }
            }
        },
        created: function() {     
        },
        computed: {
        },
        methods: {
             makePdf() {
                // Get the element.
                var element = document.getElementById('print');
                // Generate the PDF.
                html2pdf().from(element).set({
                margin: 1,
                filename: 'test.pdf',
                html2canvas: { scale: 2 },
                jsPDF: {orientation: 'portrait', unit: 'in', format: 'letter', compressPDF: true}
                }).save();
            },   
            onInputDataVolume(val) {
                this.volumeFlow=val
            },
            onInputFlowItems(id, val){
                this.modelFlowItems['val'+id]=val;
            },
            onInputHeadItems(id, val){
                this.modelHeadItems['val'+id]=val;
            },
            onInputDataHead(val) {
                this.deliveryHead=val
            },
            onSaveSelectedPumpId(val){
                this.selectedPumpId=val 
            },
            postData: function() {
                const getPromise = Axios.post(this.url+'db/getHelp', {"help_id" : 1});
                getPromise.then(response => {
                });
                },                
            postDataCableSelect: function() {
                const getPromise = Axios.post(this.url+'db/cableSelect', {"section":"1,5"});
                getPromise.then(response => {
                // console.log(response.data)
                });
                },
            postDataGetDetail: function() {
                const getPromise = Axios.post(this.url+'db/getDetails', {"id":"311"});
                getPromise.then(response => {
                // console.log(response.data)
                });
                },
            postDataControllers: function(current) {
                const getPromise = Axios.post(this.url+'db/controlSelect', {"current" : '11'});
                getPromise.then(response => {        
                // console.log(response.data);
                })
                .catch(error => {
                    });
                },
            postDataPump: function(volumeFlow, deliveryHead) {
                this.loading=true
                const getPromise = Axios.post(this.url+'db/pumpSelect', {'volumeFlow': volumeFlow, 'deliveryHead': deliveryHead});
                getPromise.then(response => {
                this.pump = response.data;
                if (this.pump!=undefined) {
                    this.selectedPumpId=this.pump[0].id                  
                    this.onGetDataChart()                       
                        this.loading=false
                        this.step3='ready'
                }
                else {
                    this.refreshDataSearch=false 
                }
                })
                .catch(error => {
                    console.log('error')
                });
                },
            next () {
                if  (this.current == 3) {                    
                    this.postDataPump(this.volumeFlow, this.deliveryHead);
                } 
                if (this.current == 4) {
                    this.current = 1;
                } else {
                    this.current+= 1;
                    this.isActive=true
                }
            },
            back () {
                if (this.current == 0) {
                    this.current = 0;
                } else {
                    this.current -= 1;
                }
            },
            step (n) {
               this.current = n
                if  (this.current == 3) {                    
                    this.postDataPump(this.volumeFlow, this.deliveryHead);                 
                }            
            },
            onGetDataChart(){
            let source=this.pump          
            function getFloat(value){
                return parseFloat(value .replace(/,/, '.'));
                }
            let Q=getFloat(source[0].features.Qmax)
            let A=getFloat(source[0].features.Ax2)
            let B=getFloat(source[0].features.Bx)
            let C=getFloat(source[0].features.C)
           
            let Qmax=[0, Q/5, 2*Q/5, 3*Q/5, 4*Q/5, 5*Q/5]
            
            function Hn(d){
                return  (A*Math.pow(d, 2)+B*d+C).toFixed(4)
            }
            let arrHn=[]
            for (let i=0; i <= Qmax.length-1; i++){
                let point={
                    x: Qmax[i].toFixed(4),
                    y: Hn(Qmax[i])
                }
                arrHn.push(point)
            }
            this.dataChart.Hnas=arrHn
            let Ah=this.modelHeadItems.val1
            let Ch=this.modelHeadItems.val2
            let Bh=this.modelHeadItems.val3
            let deliveryHead=this.deliveryHead
            let volumeFlow=this.volumeFlow
            let Ksys=(deliveryHead-Ah-Ch)/Math.pow(volumeFlow, 2)
            let Deskr=Math.pow(B, 2)-4*(A-Ksys)*(C-Ah-Ch)
            let Flow=(-B-Math.sqrt(Deskr))/(2*(A-Ksys))
            let Head=(Ah+Ch)+Ksys*Math.pow(Flow, 2)
            this.dataChart.CalcPoint=[{x: Flow.toFixed(4), y: Head.toFixed(4)}]
            this.dataChart.WorkPoint=[{ x: volumeFlow.toFixed(4), y: deliveryHead.toFixed(4)}]

            let Qf=[0,  0.3*Flow, 0.6*Flow, 0.9*Flow, 1.2*Flow]
            function Hf(i) {
                return (Ah+Ch)+Ksys*Math.pow(i, 2).toFixed(4)
            }
            let arr=[]
            for (let i=0; i<=Qf.length-1; i++) {
                let point= 
                {
                    x: (Qf[i]).toFixed(4),
                    y: Hf(Qf[i])
                }
                arr.push(point)
            }
            this.dataChart.Hsis=arr 
            }
        }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>
.el-message-box {
    width: 800px;
}
.el-message-box__title {
    font-weight: 600;
}
p {
    color: #363640;
}
h1, h2, h3 {
    color: #363640;
    text-align: center;
}
h4 {
    font-size: 19px;
    color: #009c81;
}
span {
    font-family: 'Open Sans', sans-serif;
}
.first .rect::after {
    display: none
}
.exeption-validation{
    color: #f16262;
    font-size: 14px;
}
.rect:after {
    width: 20px;
    height: 10px;
    content: "\E613";
    display: block;
    top: -84px;
    left: -47px;
    position: relative;
    font-family: element-icons;
    font-size: 33px;
    color: #555;
}

  .transition-box {
    margin-bottom: 10px;
    width: 100%;
    border-radius: 4px;
    background-color: #ffffff;
    text-align: center;
    padding: 20px 20px;
    box-sizing: border-box;
    margin-right: 20px;
  }

.flip-enter{}
.flip-enter-active {
  animation: flipInX 0.3s linear ;
}
.flip-leave{}
.flip-leave-active {
  animation: flipOutX 0.3s linear ;
}

@keyframes flipInX {
  from {transform: rotateX(90deg);}
  to {transform: rotateX(0deg);}  
}

@keyframes flipOutX {
  from {transform: rotateX(0deg);}
  to {transform: rotateX(90deg);}  
}

button.el-button.el-button--primary {
    border-radius: 0;
    min-width: 135px;
    font-size: 14px;
}
button.el-button.el-button--success {
    background-color: #009c82;
    border-radius: 0;
}
.navigation-footer button.el-button.el-button--primary, .navigation-footer button.el-button.el-button--default  {
    background: #363640;
    color: #fff;
    border-radius: 0;
    font-size: 16px;
}
i.el-icon-info, i.el-icon-question {
    color: #fbc002;
    padding: 0 5px;
    font-size: 20px;
}

svg.svg-inline--fa.fa-lightbulb.fa-w-11 {
    float: left;
    font-size: 34px;
    color: #febf00;
    height: 50px;
    padding: 12px 15px;
}
.el-input-number {
    width: 150px;
    margin: 0 5px;
}
.el-dialog__body {
    padding: 0
}
.el-dialog__footer {
    text-align: center;
    padding: 20px 0
}
 .transition-box .title {
    float: left;
    padding: 15px;
}

.transition-box .circle {
    fill: #009c81;
    stroke: transparent
}
.transition-box .circle_numder {
    float: left;
}
.transition-box .circle_numder span {
    color: #fff
}
.greyBox {
    padding: 20px;
    background: #f6f6f6;
    display: block;
    color: #212121;
    margin: 20px;
    min-height: 225px;
}
.alert {
    padding: 10px;
    text-align: left;
    font-size: 13px;
    margin-top: 35px;
} 
ul li {
   list-style: none;    
}
ul li:before {
    font-family: 'wilo-icons';
    font-size: 22px;
    margin-left: -26px;
    color: #009c82;
    content: "\192";
    width: 26px;
    display: inline-table;
    position: relative;
    top: 2px;
    font-weight: bold;
}

.my-font::before {
    font-family: 'wilo-icons';
    font-style: normal;
    line-height: 135%;
    word-wrap: break-word;
    font-size: 50px;
    margin: 0px;
    padding: 0px;
    color: #009c82;
   content: "ƒ"; 
   vertical-align: middle;
}
.stronge-price {
    font-weight: bold;
    font-size: 16px;
    padding-left: 40px;
}
</style>
