<template>
  <div> 
      <div class="container" >      
        <el-dialog
        :visible.sync="cokiesDialogVisible"
        width="100%"
        top='81vh'
        customClass='cookis-notify'
        center>
        <span class="dialog-text-cookis">Цей веб-сайт використовує файли cookie з функціональних, зручних та статистичних причин. Якщо ви приймаєте використання файлів cookie, натисніть кнопку "Я згоден" <a style="display: inline;"  class="download" href="http://www.wilo.com/en/legal/#.WbaDk9NJalM" target="_blank" title="legal information">legal information</a></span>
        <span class="dialog-button-cookis">
            <el-button type="primary" @click="onAgreeUseCookies">Згодні</el-button>
        </span>
        </el-dialog>

      <div v-loading="loading" >
          <!-- {{deliveryHead}}
          {{volumeFlow}}
          {{selectedPumpId}}
          {{pump}} -->
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
                :volumeFlow="volumeFlow"
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
                :qtyPump="qtyPump"
                :volumeFlow="volumeFlow"
                :deliveryHead="deliveryHead"
                :exchangeRates="exchangeRates"
                :selectedAccessories="selectedAccessories"
                :selectedPumpId="selectedPumpId"
                class="transition-box"/> 
        </transition>     
        <el-row class="navigation-footer">
        <el-col :span="12" >&nbsp;
             <el-button v-show="current != 1"  @click="back" type="primary" icon="el-icon-d-arrow-left">Назад </el-button>
        </el-col>
        <el-col :span="12" >&nbsp;
            <el-button v-show="current != 4"  @click="next" type="primary">Далі <i class="el-icon-d-arrow-right el-icon-right"></i></el-button>
        </el-col>
        </el-row>
    </div>   
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
                cokiesDialogVisible: false,
                url:'https://www.wiloexpert.com.ua/',
                exchangeRates: 28.5,
                current: 1,
                isActive: false,
                deliveryHead: 25,
                volumeFlow: 5,
                maxVolumeFlow: 17,
                modelFlowItems: {
                    val1:0,
                    val2:0,
                    val3:0,
                    val4:0,
                    val5:0,
                    val6:0,
                    aditionalFlow:0
                },
                modelHeadItems: {
                    val1:0,
                    val2:0,
                    val3:0,
                    val4:0
                },
                pump: [],
                allPumps: [],
                links: [],
                dictionary: '',
                step3:'',  
                step1:'', 
                selectedPumpId: 0,
                qtyPump: 0,
                dataChart: {
                    CalcPoint:'',
                    Hnas:'',
                    Hsis:'',
                    WorkPoint:''                                                
                },
                selectedAccessories: {
                    item1: {
                        title: "Прилад керування і захисту насоса",
                        article: '',
                        name: "",
                        img: "assets/controller.jpg",
                        price: "",
                        selected: false,
                        idController: undefined,
                        qty:0
                    },
                    item2: {
                        title: "Кабель",
                        article: '',
                        name: "",
                        img: "assets/cable.jpg",
                        price: 0,
                        length: 0,
                        selected: false,
                        idCable: undefined,
                    },
                    item3: {
                        title: "З’єднання насоса",
                        article: '',
                        name: "",
                        img: "assets/mufta.jpg",
                        price: "",
                        selected: false,
                        idMufta: undefined,
                        qty:0
                    },
                    item4: {
                        title: "Мембранний напірний бак",
                        article: '',
                        name: "",
                        volume:'',
                        img: "assets/bak.jpg",
                        price: "",
                        selected: false,
                        idVessel: undefined,
                        qty:0
                    },
                    item5: {
                        title: "Кожух",
                        name: "",
                        length: "",
                        img: "assets/jackets.jpg",
                        price: "",
                        selected: false,
                        typeInstallationJackets:0,
                        idJacket: undefined,
                        qty:0                    }
                }
            }
        },
        created: function() { 
            this.postDataDictionary()   
            // this.exchangeRates=this.get_cookie("currency")*1.2  
            // this.exchangeRates=this.get_cookie("currency")*1.2   
            // document.cookie = "existPumpOrAccessoreis=true; path=/; expires=" + date.toUTCString()
            // document.cookie = "idPump=343; path=/; expires=" + date.toUTCString()
            // document.cookie = "idController=440; path=/; expires=" + date.toUTCString()
            // document.cookie = "idCable=419; path=/; expires=" + date.toUTCString()
            // document.cookie = "idMufta=428; path=/; expires=" + date.toUTCString()
            // document.cookie = "idVessel=444; path=/; expires=" + date.toUTCString()
            // document.cookie = "idJacket=450; path=/; expires=" + date.toUTCString()
            // document.cookie = "pumpQty=3; path=/; expires=" + date.toUTCString()
            // document.cookie = "controllerQty=1; path=/; expires=" + date.toUTCString()
            // document.cookie = "cableQty=15; path=/; expires=" + date.toUTCString()
            // document.cookie = "muftaQty=2; path=/; expires=" + date.toUTCString()
            // document.cookie = "vesselQty=3; path=/; expires=" + date.toUTCString()
            // document.cookie = "jacketQty=1; path=/; expires=" + date.toUTCString()
            // document.cookie = "deliveryHead=30; path=/; expires=" + date.toUTCString()
            // document.cookie = "volumeFlow=3; path=/; expires=" + date.toUTCString()

            if (this.get_cookie('existPumpOrAccessoreis')) {
                
                    
                    this.deliveryHead=Number(this.get_cookie('deliveryHead'))
                    this.volumeFlow=Number(this.get_cookie('volumeFlow'))
                    if (this.get_cookie('idController')) {
                        this.postDataGetDetail(this.get_cookie('idController'), 'item1', this.get_cookie('controllerQty'))
                    }                    
                    if (this.get_cookie('idCable')) {
                        this.postDataGetDetail(this.get_cookie('idCable'), 'item2', this.get_cookie('cableQty')) 
                    }                    
                    if (this.get_cookie('idMufta')) {
                       this.postDataGetDetail(this.get_cookie('idMufta'), 'item3', this.get_cookie('muftaQty')) 
                    }
                    if (this.get_cookie('idVessel')) {
                        this.postDataGetDetail(this.get_cookie('idVessel'), 'item4', this.get_cookie('vesselQty')) 
                    }
                    if (this.get_cookie('idJacket')) {
                        this.postDataGetDetail(this.get_cookie('idJacket'), 'item5', this.get_cookie('jacketQty'))
                    }
                    if (this.get_cookie('idPump')) {
                        this.postDataGetDetail(this.get_cookie('idPump'), 'pump', this.get_cookie('pumpQty'))
                    }
                    this.deleteCookie('currency');              
            }
        },
        computed: {

        },
        mounted() {
             if  (!this.get_cookie('cookies')) { this.cokiesDialogVisible=true } 
            this.postDataAllPumps()                      
        },
        methods: {
            onAgreeUseCookies() {
                 document.cookie = "cookies=true"                
                 this.cokiesDialogVisible=false
            },
            get_cookie(cookie_name)
                {
                var results = document.cookie.match ( '(^|;) ?' + cookie_name + '=([^;]*)(;|$)' );
                if ( results ) {
                    return unescape ( results[2] )
                }               
            },
            deleteCookie(name) {
                    document.cookie.split(";").forEach(function(el) {
                    el = el.split("=")[0].trim();
                    if(!el.indexOf(name)) {
                    var date = new Date(0);
                    document.cookie = el + "=; path=/; expires=" + date.toUTCString();
                    }

                });
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
            postDataGetDetail: function(id, item, qty) {
                const getPromise = Axios.post(this.url+'db/getDetails', {"id":id});
                getPromise.then(response => {                   
                    let obj = response.data;
                    if (obj && item=='item1') {
                        this.selectedAccessories[item].idController = id;
                        this.selectedAccessories[item].name = obj[0].name;
                        this.selectedAccessories[item].article = obj[0].article;
                        this.selectedAccessories[item].qty = qty;
                        this.selectedAccessories[item].price = (obj[0].price*this.exchangeRates).toFixed(2);
                        this.selectedAccessories[item].current_max = obj[0].features.current_max;
                        this.selectedAccessories[item].description = obj[0].features.description;
                        this.selectedAccessories[item].img = obj[0].features.img;
                        this.selectedAccessories[item].selected = true;
                       this.deleteCookie('idController');
                        this.deleteCookie('controllerQty');         
                    }
                    if (obj && item=='item2') {
                        this.selectedAccessories[item].idCable = id;
                        this.selectedAccessories[item].name = obj[0].name;
                        this.selectedAccessories[item].article = obj[0].article;
                        this.selectedAccessories[item].price = (obj[0].price*this.exchangeRates).toFixed(2);
                        this.selectedAccessories[item].length = qty;
                        this.selectedAccessories[item].selected = true;
                        this.deleteCookie('idCable');
                        this.deleteCookie('cableQty');
                    }
                    if (obj && item=='item3') {
                       
                        this.selectedAccessories[item].idMufta = id;
                        this.selectedAccessories[item].name = obj[0].name;
                        this.selectedAccessories[item].article = obj[0].article;
                        this.selectedAccessories[item].price = (obj[0].price*this.exchangeRates).toFixed(2);
                        this.selectedAccessories[item].qty = qty;
                        this.selectedAccessories[item].type = obj[0].features.type
                        this.selectedAccessories[item].section = obj[0].features.section                        
                        this.selectedAccessories[item].selected = true;
                        this.deleteCookie('idMufta');
                        this.deleteCookie('muftaQty');
                    }
                    if (obj && item=='item4') {
                        this.selectedAccessories[item].idVessel = id;
                        this.selectedAccessories[item].name = obj[0].name;
                        this.selectedAccessories[item].volume = obj[0].features.volume;
                        this.selectedAccessories[item].article = obj[0].article;
                        this.selectedAccessories[item].price = (obj[0].price*this.exchangeRates).toFixed(2);
                        this.selectedAccessories[item].qty = qty;
                        this.selectedAccessories[item].selected = true;
                        this.deleteCookie('idVessel');
                        this.deleteCookie('vesselQty');
                    }
                    if (obj && item=='item5') {
                        this.selectedAccessories[item].idJacket = id;
                        this.selectedAccessories[item].name = obj[0].name;
                        this.selectedAccessories[item].length = obj[0].features.length;
                        this.selectedAccessories[item].description = obj[0].features.description;
                        this.selectedAccessories[item].typeInstallationJackets = obj[0].features.installation;                        
                        this.selectedAccessories[item].article = obj[0].article;
                        this.selectedAccessories[item].price = (obj[0].price*this.exchangeRates).toFixed(2);
                        this.selectedAccessories[item].qty = qty;
                        this.selectedAccessories[item].selected = true;
                        this.deleteCookie('idJacket');
                        this.deleteCookie('jacketQty');
                    }
                    if (obj && item=='pump') {
                             this.pump = obj;
                             if (this.pump!=undefined) {
                                this.selectedPumpId=this.pump[0].id  
                                this.qtyPump=qty;     
                                 this.onGetDataChart(this.pump)                    
                                    this.loading=false
                                    this.step3='ready'
                                    this.current=3
                                    this.deleteCookie('existPumpOrAccessoreis');  
                                    this.deleteCookie('idPump');
                                    this.deleteCookie('pumpQty');
                                 }
                    }         
                });
            },
            postDataDictionary: function() {
                this.loading=true
                const getPromise = Axios.post(this.url+'db/getHelp');                
                getPromise.then(response => {
                    this.dictionary=response.data
                    if (this.dictionary!=undefined) {
                    this.step1='ready'
                    this.loading=false                        
                    }

                     
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
                    this.allPumps=allPumps
                    
                });
                },
            postDataPump: function(volumeFlow, deliveryHead) {
                this.selectedPumpId=0
                this.loading=true
                const getPromise = Axios.post(this.url+'db/pumpSelect', {'volumeFlow': volumeFlow, 'deliveryHead': deliveryHead});
                getPromise.then(response => {
                this.pump = response.data;
                if (this.pump!=undefined) {
                    this.selectedPumpId=this.pump[0].id  
                    this.onGetDataChart(this.pump), 1000;                
                                           
                        this.loading=false
                        this.step3='ready'
                }
                })
                .catch(error => {
                    this.loading=false                   
                    this.pump=this.pump[0].status.type  
                    this.selectedPumpId=0                
                    this.step3='ready'
                    
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
            let Bh=this.modelHeadItems.val2
            let Ch=this.modelHeadItems.val3
            if (this.deliveryHead==0 && this.volumeFlow==0)
            {
               this.deliveryHead=getFloat(source[0].features.Hnom)
               this.volumeFlow=getFloat(source[0].features.Qnom)
            }

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
p {
    color: #363640;
    text-align: left;
    font-size: 14px;
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
    left: -39px;
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
    text-align: left;
    padding: 15px 20px 10px 50px;
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
.navigation-footer button.el-button.el-button--primary:hover {
    background: #009c82;
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
    width: 22px;
    padding: 4px 15px 8px 20px;
}
.el-input-number {
    width: 150px;
    margin: 0 5px;
}
.el-dialog__footer {
    text-align: center;
    padding: 20px;
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
.greyBox {
    padding: 20px 20px 0 20px;
    background: #f6f6f6;
    color: #212121;
    margin-right: 2%;
    min-height: 180px;
    margin-bottom: 20px;
}

.last-box{
    margin-right: 0;
    background: #f6f6f6;
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
    color: #009c82;
}
span.myTip {
    cursor: pointer;
    font-size: 14px;
    color: #545759;
    border-bottom: 1px dashed #4b4848;
    padding-left: 3px
}
button.el-button.el-button--text.el-popover__reference {
    padding: 4px 0;
}
.download {
    color: #009c81;
    display: block;
    margin: 15px 0;
    text-decoration: none;
    font-size: 13px;
}
.dialog-text-cookis, .dialog-text-cookis {
    display: inline-block;
    margin: auto
}
.dialog-text-cookis {
    width: 70%;
    padding: 0 20px;
}
 
span.dialog-footer-cookis {
    margin: 5px 10px;
}
.el-dialog.el-dialog--center.cookis-notify {
    margin: 0;
}
</style>
