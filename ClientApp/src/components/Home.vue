<template>
  <div style="width:1200px; margin:auto"> 
    
      <div v-loading="loading" >
      <button class="btn btn-primary pl-5 pr-5" @click="makePdf">Download PDF  </button>
      <!-- {{deliveryHead}} - {{volumeFlow}}
     {{pump}}  
     {{selectedPumpId}}  -->

        <HeaderPart />
        <el-row :gutter="20" >        
        <a href="#"  class="first" @click="step(1, $event)" ><stepTile title="Витрата насоса" number="1" :class="[{ active: current==1}]" /></a>        
        <a href="#" @click="step(2, $event)"><stepTile title="Напір насоса" number="2" :class="[{ active: current==2}]"/></a> 
        <a href="#" @click="step(3, $event)"><stepTile title="Підбір насоса та приладдя" number="3"  :class="[{ active: current==3}]"/></a>
        <a href="#" @click="step(4, $event)"><stepTile slot="first" title="Пропозиція" number="4" :class="[{ active: current==4}]"/></a>
        </el-row>
    
        <transition name="flip" mode="out-in" >
        <Step1 v-if="current==1 && step1=='ready'"
                :url="url" 
                :dictionary="dictionary"
                :volumeFlow="volumeFlow"
                :modelFlowItems="modelFlowItems"
                :maxVolumeFlow="maxVolumeFlow"
                @onInputDataVolume="onInputDataVolume"
                @onInputFlowItems="onInputFlowItems"
                class="transition-box"/>              
        <Step2 v-else-if='current==2' 
                :url="url" 
                :deliveryHead="deliveryHead"
                :dictionary="dictionary"
                :modelHeadItems="modelHeadItems"
                @onInputDataHead="onInputDataHead"
                @onInputHeadItems="onInputHeadItems"
                class="transition-box"/>         
        <Step3 v-else-if="current==3 && step3=='ready'"
                :url="url" 
                :pump="pump"
                :allPumps="allPumps"
                :dictionary="dictionary"
                :selectedPumpId="selectedPumpId"
                :volumeFlow="volumeFlow"
                :deliveryHead="deliveryHead"
                :dataChart="dataChart"
                :exchangeRates="exchangeRates"
                :selectedAccessories="selectedAccessories"
                @onSaveSelectedPumpId="onSaveSelectedPumpId"
                @onRefreshDataPump="onRefreshDataPump"
                @onSaveSelectedAccessories="onSaveSelectedAccessories"
                @onGetDataChart="onGetDataChart"
                class="transition-box"/>
        <Step4 v-else-if='current==4' 
                :url="url"
                :pump="pump"
                :exchangeRates="exchangeRates"
                :selectedAccessories="selectedAccessories"
                :selectedPumpId="selectedPumpId"
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
                exchangeRates: 28.5,
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
                pump: [],
                allPumps: [],
                links: [],
                dictionary: '',
                dic: '',
                step3:'',  
                step1:'', 
                selectedPumpId: 0,
                dataChart: {
                    CalcPoint:'',
                    Hnas:'',
                    Hsis:'',
                    WorkPoint:''                                                
                },
                selectedAccessories: {
                    item1: {
                        title: "Прилад керування і захисту насоса",
                        name: "",
                        img: "assets/controller.jpg",
                        price: "",
                        current_max: "",
                        dim: "",
                        selected: false,
                        idController: undefined
                    },
                    item2: {
                        title: "Кабель",
                        name: "",
                        img: "assets/cable.jpg",
                        price: 0,
                        length: 0,
                        selected: false,
                        idCable: undefined
                    },
                    item3: {
                        title: "З’єднання насоса",
                        name: "",
                        img: "assets/mufta.jpg",
                        price: "",
                        selected: false,
                        idMufta: undefined
                    },
                    item4: {
                        title: "Мембранний напірний бак",
                        name: "",
                        img: "assets/bak.jpg",
                        price: "",
                        selected: false,
                        idVessel: undefined
                    },
                    item5: {
                        title: "Кожух",
                        name: "",
                        length: "",
                        img: "assets/jeckets.jpg",
                        price: "",
                        selected: false,
                        idJecket: undefined
                    }
                }
            }
        },
        created: function() {  
            this.postDataDictionary()    
            this.get_cookie("currency")
             
        },
        computed: {
        },
        mounted() {
            this.postDataAllPumps()                      
        },
        methods: {
            get_cookie( cookie_name )
                {
                // document.cookie="currency=28.55"
                var results = document.cookie.match ( '(^|;) ?' + cookie_name + '=([^;]*)(;|$)' );
                if ( results ) {
                    this.exchangeRates=unescape ( results[2] )
                }               
            },
             makePdf() {
                // Get the element.
                var element = document.getElementById('print');
                // Generate the PDF.
                var bodySend=html2pdf().from(element).set({
                margin: 1,
                filename: 'test.pdf',
                html2canvas: { scale: 2 },
                jsPDF: {orientation: 'portrait', unit: 'in', format: 'letter', compressPDF: true}
                }).save();
                
                var xhr = new XMLHttpRequest();
                xhr.open("POST", url+"/db/printPumpDatasheet");
                xhr.setRequestHeader('Content-Type', 'multipart/form-data; boundary=' + boundary);
                xhr.send(bodySend);
            },
            onClearSelectedAccessories()  {
                for (let i=1; i<=5;i++) {
                    this.selectedAccessories['item'+i].selected = false;
                }  
            },  
            onInputDataVolume(val) {
                this.onClearSelectedAccessories()
                this.volumeFlow=val
            },
            onInputFlowItems(id, val){
                this.modelFlowItems['val'+id]=val;
            },
            onInputHeadItems(id, val){
                this.modelHeadItems['val'+id]=val;
            },
            onInputDataHead(val) {
                this.onClearSelectedAccessories()
                this.deliveryHead=val
            },
            onSaveSelectedPumpId(val){
                this.selectedPumpId=val 
            },
            onRefreshDataPump: function(obj) {
                this.pump=obj
            },
            onSaveSelectedAccessories(obj){
                this.selectedAccessories=obj 
            },
            postDataDictionary: function() {
                this.loading=true
                const getPromise = Axios.post(this.url+'db/getHelp');                
                getPromise.then(response => {
                    this.dictionary=response.data
                    this.step1='ready'
                    this.loading=false
                     
                });
                },                
            postDataCableSelect: function() {
                const getPromise = Axios.post(this.url+'db/cableSelect', {"section":"1,5"});
                getPromise.then(response => {
                // 
                });
                },
            postDataAllPumps: function() {
                const getPromise = Axios.post(this.url+'db/getAllPumps');                
                getPromise.then(response => {
                    let source=response.data
                    let allPumps=[]
                    for(let i=0; i<source.length; i++){
                        let obj={}
                        obj.value=source[i].pump_name.split(".")[1]
                        obj.id=source[i].pump_id
                        allPumps.push(obj)
                    }
                    console.log(allPumps)
                    this.allPumps=allPumps
                    
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
                    this.onGetDataChart(this.pump)                       
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
                if  (this.current == 2) {                    
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
                if  (this.current == 4) {                    
                    this.postDataPump(this.volumeFlow, this.deliveryHead);                 
                } 
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
            onGetDataChart(obj){
                console.log('emitchart')
            let source=obj         
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
}
h4 {
    font-size: 19px;
    color: #009c81;
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
    width: calc(100% - 40px);
    background-color: #ffffff;
    text-align: center;
    padding: 20px 0;
    box-sizing: border-box;
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
.container-button {
    text-align: right;
    padding: 35px 20px 10px;
}
button.el-button.el-button--primary {
    border-radius: 0;
    min-width: 135px;
    font-size: 14px;
}
button.el-button.calc-btn.el-button--primary {
    font-size: 16px;
}
button.el-button.calc-btn.el-button--primary img
{
    padding-right: 10px;vertical-align: middle;
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
.transition-box .circle_number {
    float: left;
}
.transition-box .circle_number span {
    color: #fff
}
.greyBoxes-container {
    display: flex;
    flex-direction: row;
}
.greyBox {
    padding: 20px;
    background: #f6f6f6;
    color: #212121;
    margin-right: 2%;
    min-height: 225px;
    width: 46%;
}
.last-box{
    margin-right: 0;
}
.alert {
    padding: 10px;
    text-align: left;
    font-size: 15px;
    margin-top: 35px;
} 
ul li {
   list-style: none;    
}
.el-collapse-item__content ul li:before {
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
}
span.myTip {
    cursor: pointer;
    font-size: 15.5px;
    color: #545759;
    border-bottom: 1px dashed #4b4848;
}
button.el-button.el-button--text.el-popover__reference {
    padding: 4px 0;
}
</style>
