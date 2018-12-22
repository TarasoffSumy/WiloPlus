<template>
  <div id="content">
      <!-- <button
            @click="logContent"
        >
            log content
        </button> -->
      <button class="btn btn-primary pl-5 pr-5" @click="download">Download PDF</button>
      <div id="editor"></div>
      <div style="width: 1200px; margin: auto;">
        <el-row :gutter="20" >        
        <a href="#"  class="first" @click="step(1, $event)" ><stepTile title="Витрата насоса" number="1" :class="[{ active: current==1}]" /></a>        
        <a href="#" @click="step(2, $event)"><stepTile title="Напір насоса" number="2" :class="[{ active: current==2}]"/></a> 
        <a href="#" @click="step(3, $event)"><stepTile title="Підбір насоса та приладдя" number="3"  :class="[{ active: current==3}]"/></a>
        <a href="#" @click="step(4, $event)"><stepTile slot="first" title="Пропозиції" number="4" :class="[{ active: current==4}]"/></a>
        </el-row>
        <!-- <button @click="OnGet">Go</button> -->   
        <transition name="flip" mode="out-in">
        <Step1 v-if='current==1'  
                :volumeFlow="volumeFlow"
                :url="url"
                :modelFlowItems="modelFlowItems"
                :maxVolumeFlow="maxVolumeFlow"
                @onInputDataVolume="onInputDataVolume"
                @onInputFlowItems="onInputFlowItems"
                class="transition-box step1"/>              
        <Step2 v-else-if='current==2' 
                :url="url"
                :deliveryHead="deliveryHead"
                :modelHeadItems="modelHeadItems"
                @onInputDataHead="onInputDataHead"
                @onInputHeadItems="onInputHeadItems"
                class="transition-box step2"/>         
        <Step3 v-else-if='current==3'
                :url="url" 
                :pump="pump"
                :volumeFlow="volumeFlow"
                :deliveryHead="deliveryHead"
                :Hnas="Hnas"
                :WorkPoint="WorkPoint"
                :CalcPoint="CalcPoint"  
                :Hsis="Hsis" 
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
                url:'http://wiloexpert.com.ua/wilo/',
                currentPage: 0,
                pageCount: 0,
                posts:[],
                current: 1,
                showStep: 0,
                activeClass: 'active',
                errorClass: 'text-danger',
                isActive: false,
                helperStep1: false,
                deliveryHead: 30,
                volumeFlow: 1,
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
                    val1:0,
                    val2:0,
                    val3:0,
                    val4:0
                },
                pump:[],
                selectedPumpId: "",
                selectedPump:{},
                CalcPoint:'',
                Hnas:'',
                Hsis:'',
                WorkPoint:'',
                docDefinition : {
                        content: [
                            // if you don't need styles, you can use a simple string to define a paragraph
                            'This is a standard paragraph, using default style',

                            // using a { text: '...' } object lets you set styling properties
                            { text: 'This paragraph will have a bigger font', fontSize: 15 },

                            // if you set the value of text to an array instead of a string, you'll be able
                            // to style any part individually
                            {
                            text: [
                                'This paragraph is defined as an array of elements to make it possible to ',
                                { text: 'restyle part of it and make it bigger ', fontSize: 15 },
                                'than the rest.'
                            ]
                            }
                        ]
                        } 
            }
        },
        created: function() {
           // this.postDataPump(this.volumeFlow, this.deliveryHead);  
           this.onGetDataChart()                      
        },
        computed: {
            objSelectedPump: function() {
                let pumpsArr=[]
                let source=this.pump
                for (let key in source){
                        pumpsArr.push(source[key])                
                }
                let obj={}
                for (let key in pumpsArr){
                    if (pumpsArr[key].id==this.selectedPumpId) {
                        obj.name=pumpsArr[key].pump_name
                        obj.price=pumpsArr[key].price
                        obj.shortName=obj.name.split('/')[0]
                    }
                }
             return obj            
            }            
        },
        methods: {
             logContent() {
                let pdfName = 'test'; 
                var specialElementHandlers = {
                    '#editor': function (element, renderer) {
                        return true;
                    }
                };
                var doc = new jsPDF();
                doc.text(20, 20, 'Привет');
                var el=document.getElementById("content");
                doc.fromHTML(el, 20, 20, {
                        'width': 300,
                            'elementHandlers': specialElementHandlers
                    });
                
                doc.save(pdfName + '.pdf');
            },
            OnGet() {
                 let Qrez=2
                function getLog(y) {
                return Math.log(y) ;
                }
                console.log(0.937*getLog(Qrez)+0.7689)

            },  
            download () { 
            pdfMake.createPdf(this.docDefinition).download();
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
            fetchData: function() {
                const getPromise = Axios.get('http://www.wiloexpert.com.ua/wilo/db/getAllPumps');
                getPromise.then(response => {
                this.posts = response.data;
                });
                return getPromise;
                },
            postData: function() {
                const getPromise = Axios.post('http://www.wiloexpert.com.ua/wilo/db/getHelp', {"help_id" : 1});
                getPromise.then(response => {
                });
                },
            postDataPump: function(volumeFlow, deliveryHead) {
                const getPromise = Axios.post('http://www.wiloexpert.com.ua/wilo/db/pumpSelect', {'volumeFlow': volumeFlow, 'deliveryHead': deliveryHead});
                getPromise.then(response => {
                this.pump = response.data;
                this.OnGetFirstSelectedId()
                });
                },
            next () {
                if (this.current == 4) {
                    this.current = 1;
                } else {
                    this.current+= 1;
                    this.isActive=true
                    this.showStep=this.current
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
            },
            onGetvolumeFlow(value) {
                this.volumeFlow=value
            },
            onGetDataChart(){
            let Q=1.5
            let A=-16.76
            let B=-9.0825
            let C=64.506
            let Qmax=[0, Q/5, 2*Q/5, 3*Q/5, 5*Q/5]
            function Hn(d){
                return  A*Math.pow(d, 2)+B*d+C
            }
            let arrHn=[]
            for (let i=0; i <= Qmax.length-1; i++){
                let point={
                    x: Qmax[i].toFixed(2),
                    y: Hn(Qmax[i]).toFixed(2)
                }
                arrHn.push(point)
            }
            this.Hnas=arrHn
            let Ah=this.modelHeadItems.val1
            let Ch=this.modelHeadItems.val2
            let Bh=this.modelHeadItems.val3
            let deliveryHead=this.deliveryHead
            let volumeFlow=this.volumeFlow
            let Ksys=(deliveryHead-Ah-Ch)/Math.pow(volumeFlow, 2)
            let Deskr=Math.pow(B, 2)-4*(A-Ksys)*(C-Ah-Ch)
            let Flow=(-B-Math.sqrt(Deskr))/(2*(A-Ksys))
            let Head=(Ah+Ch)+Ksys*Math.pow(Flow, 2)
            this.CalcPoint=[{x: Flow.toFixed(1), y: Head.toFixed(1)}]
            this.WorkPoint=[{ x: volumeFlow.toFixed(1), y: deliveryHead.toFixed(1)}]

            let Qf=[0,  0.3*Flow, 0.6*Flow, 0.9*Flow, 1.2*Flow]
            function Hf(i) {
                return (Ah+Ch)+Ksys*Math.pow(i, 2)
            }
            let arr=[]
            for (let i=0; i<=Qf.length-1; i++) {
                let point= 
                {
                    x: Qf[i].toFixed(2),
                    y: Hf(Qf[i].toFixed(2))
                }
                arr.push(point)
            }
            this.Hsis=arr
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
/*
.transition-box .circle_numder {
    padding-top: 20px;
    margin: auto;
    width: 50px;
    height: 50px;
    float: left;
}}*/
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
</style>
