<template>
<div>
    <h2>Підбір приладдя до свердловинного насосу</h2>
    <el-row>
        <el-col :span="12" class="side-left-helper">
            
            <el-button  v-for="item in accessories" @click="onFocusInput(item.id)" :key='item.id' :class="['circle_number number_'+item.id, {green: focusInput==item.id}]" type="text">                   
                    <svg height="36" width="36" class="circle" >
                    <circle cx="17" cy="17" r="17" stroke="" stroke-width="2" fill="" />
                    </svg><div class="symbolInCircle">{{item.id}}</div>
                    <div :class="[{active: focusInput==item.id}]"></div>                            
            </el-button>
        <img style="margin-top:-20px;text-align: left; position: absolute; left: 54px;" :src="url+'assets/accessories.jpg'" width="450" alt="">
        </el-col>
        <el-col :span="10" class="side-right-helper">
            <div v-for="item in accessories" class="row-item" :key='item.id' :class="[{activeLeftCircle: focusInput==item.id}]">
                
                        <div class="circle_number">                   
                            <svg height="36" width="36" class="circle">
                            <circle cx="17" cy="17" r="17" stroke="" stroke-width="2" fill="" />
                            </svg><div class="symbolInCircle">{{item.id}} </div>  
                        </div>  <div v-show="item.checked" class="checked"></div>
                    <el-button type="text"><span class="item"  @click="onFocusInput(item.id)">{{item.title}}</span></el-button>         
            </div>           
        </el-col>
    </el-row> 
    <el-row>
        <h4>{{activeAccessories}}</h4>
        <div v-if="focusInput==1" class="block-accessoreis"  v-for="item in controllers" :key="item.id">
            <el-row v-if="!(paramOfSelectedPump.phase==3 && item.features.phase==1)">                                       
                    <el-col :span="1" style="padding-top:30px">

                        <!-- <el-radio  v-model="idController"  @change="handleChange(item.id)" :label="item.id">
                        <span > </span></el-radio>                                 -->
                    </el-col>
                    <el-col :span="4">                           
                            <img :src="url+'assets/controller.jpg'" width="100px" alt="">
                                <svg height="80" width="80" class="circle" >
                                <circle cx="40" cy="40" r="40" stroke="" stroke-width="2" fill="" />
                                </svg><div class="lable-class">{{item.features.class}}</div>  
                    </el-col>
                    <el-col :span="17" :offset="2" >
                            <div class="accessories">
                            <p class="name-item">{{item.name}}</p>
                            <el-collapse accordion> 
                            <el-collapse-item name="1">
                                <template slot="title">
                                Детальніше<i class="header-icon el-icon-info"></i>
                                </template>
                                <p class="text" v-html="item.features.description"></p>
                            </el-collapse-item>
                            </el-collapse>
                            <p><strong>Ток максимальний:</strong> {{item.features.current_max}} A </p>
                            <p><strong>Розміри:</strong> {{item.features.dim}}  </p>
                            <div class="expand-view">
                            <p><strong>Тип пуску насоса:</strong> {{item.features.start}}  </p> 
                            <p><strong>Управління:</strong> {{item.features.operation}}  </p>                       
                            <p><strong>Захист від сухого ходу:</strong> {{item.features.dry_running}}  </p> 
                            <a src="#">Завантажити інструкцію з експлуатаціЇ</a>
                            <p class="stronge-price">Ціна: {{item.price*exchangeRates | aroundPrice}} грн з ПДВ </p> 
                            <el-radio-group  v-model="idController" @change="handleChange(item.id)">
                                <el-radio-button  :label="item.id">Вибрати</el-radio-button>
                            </el-radio-group>   
                            </div></div>                               
                    </el-col> 
                </el-row>               
        </div>
        <div  v-if="focusInput==2" >
            <el-row>
                <el-col :offset="7"  :span="3">
                    <img style="" :src="url+'assets/cable.jpg'" width="150" alt="">
                </el-col>
                <el-col  :span="8" class="accessorie">
                    <p>Довжина кабелю <el-input-number v-model="cable.length" @change="handleChangeCableLength(cable.length)" :min="0" ></el-input-number> м</p>
                    <el-row v-if="computedCableSection">
                        <div class="" >
                            <p class="detail-title"> Перетин кабелю <span>4 х {{computedCableSection}} мм<sup>2</sup></span>  </p>
                            <el-collapse accordion> 
                            <el-collapse-item name="1">
                                <template slot="title">
                                Детальніше<i class="header-icon el-icon-info"></i>
                                </template>
                                <div v-html="cable.description"></div> 
                            </el-collapse-item>
                            </el-collapse>
                            
                            <p class="stronge-price">{{cable.price*exchangeRates | aroundPrice}} грн з ПДВ за 1м.п.</p> 
                        </div>                
                    </el-row>                 
                </el-col>
            </el-row>
            <el-row v-if="computedCableSection">
            <h4>З’єднувальна муфта для кабеля</h4>
        <div class="block-accessoreis"  v-for="item in mufts" :key="item.id">
            <el-row>                                       
                    <el-col :span="1" style="padding-top:30px">                     
                    </el-col>
                    <el-col :span="6">
                        <img v-if="item.features.type=='coupling filler'" :src="url+'assets/mufta_zal.jpg'" width="120px" alt="">
                        <img v-else-if="item.features.type=='coupling thermo'" :src="url+'assets/mufta_termo.jpg'" width="120px" alt="">
                                <svg height="80" width="80" class="circle" >
                                <circle cx="40" cy="40" r="40" stroke="" stroke-width="2" fill="" />
                                </svg><div class="lable-class">{{item.features.class}}</div>  
                    </el-col>
                    <el-col :span="15" :offset="2" >                        
                            <div class="accessories">
                            <p class="name-item">{{item.name}}</p>                           
                            <el-collapse accordion> 
                            <el-collapse-item name="1">
                                <template slot="title">
                                Детальніше<i class="header-icon el-icon-info"></i>
                                </template>
                                <p class="text" v-html="item.features.description"></p>
                            </el-collapse-item>
                            </el-collapse>
                            <p>Перетин  {{item.features.section}} мм<sup>2</sup></p>
                            <p class="stronge-price">Ціна: {{item.price*exchangeRates | aroundPrice}} грн з ПДВ </p> 
                            <el-radio-group  v-model="idMufta"  @change="handleChangeMufta(item.id)">
                                <el-radio-button  :label="item.id">Вибрати</el-radio-button>
                            </el-radio-group>  
                            
                            </div>                            
                    </el-col> 
            </el-row>               
        </div>
        </el-row>
        </div>
        <div v-if="focusInput==3" class="">
            <el-row>
                <el-col :offset="7"  :span="3">
                    <img style="" :src="url+'assets/bak.jpg'" width="150" alt="">
                </el-col>
                <el-col  :span="8" class="accessorie">                    
                    <p class="name-item">{{vessels[computedVesselId].name}}</p>
                            <el-collapse accordion> 
                            <el-collapse-item name="1">
                                <template slot="title">
                                Детальніше<i class="header-icon el-icon-info"></i>
                                </template>
                                <p v-html="vessels[computedVesselId].features.description"></p>
                            </el-collapse-item>
                            </el-collapse>
                    <p class="stronge-price">Ціна: {{vessels[computedVesselId].price*exchangeRates | aroundPrice}} грн з ПДВ</p>
                    <p>Об'єм: <strong>{{vessels[computedVesselId].features.volume}}</strong> л</p>
                    <p>Тиск: <strong>{{vessels[computedVesselId].features.pressure}}</strong> Па </p>
                    <p>Диаметр: <strong>{{vessels[computedVesselId].features.dim_diam}}</strong>  мм</p>
                    <p>Висота:<strong>{{vessels[computedVesselId].features.dim_height}}</strong>  мм</p>
                    <p>Вага: <strong>{{vessels[computedVesselId].features.weight}}</strong>  кг</p>
                    <p>Диаметр з’єднання:  <strong>{{vessels[computedVesselId].features.dim_connection}}</strong>" </p>    
                    <el-dropdown size="medium" split-button type="primary" @command="handleCommand"  >
                    Обрати інший бак
                    <el-dropdown-menu slot="dropdown" >                
                        <el-dropdown-item :command="index" v-for="(item, index) in vessels" :key="item.id">{{item.name}}</el-dropdown-item>
                    </el-dropdown-menu>
                    </el-dropdown>                     
                </el-col>
            </el-row>
        </div>
        <div v-if="focusInput==4" class="">
                <el-col :offset="5"  :span="3">
                    <img style="" :src="url+'assets/jeckets.jpg'" width="250" alt="">                    
                </el-col>
                <el-col :offset="2" :span="8" class="accessorie">
                    <p>
                        <el-radio  v-model="typeInstallationJeckets"  @change="handleChangeTypeJeckets()" label="vertical">Для монтажу в свердловині </el-radio>
                        <el-radio  v-model="typeInstallationJeckets"  @change="handleChangeTypeJeckets()" label="horizontal">Для монтажу в резервуарі </el-radio>                     
                    </p>
                    <div v-show="typeInstallationJeckets =='vertical'">
                        Вкажіть діаметр скважини  <el-input-number v-show="typeInstallationJeckets =='vertical'" @change="changeDiameterSkvagina()"  v-model="diametrSkvagina" :min="110"></el-input-number> мм                
                        <p v-if="computedJacketsNotNeeded">Кожух не потрібен</p>
                        <div v-else-if="diametrSkvagina!=0">
                            <p class="name-item">{{computedJackets.name}}</p>
                            <p>Довжина <strong>{{computedJackets.features.length}}</strong> мм</p>
                            <p class="stronge-price">Ціна {{computedJackets.price*exchangeRates | aroundPrice}} грн з ПДВ</p>
                            <el-collapse accordion> 
                            <el-collapse-item name="1">
                                <template slot="title">
                                Детальніше<i class="header-icon el-icon-info"></i>
                                </template>
                                <p v-html="computedJackets.features.description"></p>
                            </el-collapse-item>
                            </el-collapse>
                            
                        </div>
                    </div>
                    <div v-if="typeInstallationJeckets =='horizontal'">               
                        <p class="name-item">{{computedJackets.name}}</p>
                        <p>Довжина <strong>{{computedJackets.features.length}}</strong> мм</p>
                        <p class="stronge-price">Ціна {{computedJackets.price*exchangeRates | aroundPrice}} грн з ПДВ</p>
                            <el-collapse accordion> 
                            <el-collapse-item name="1">
                                <template slot="title">
                                Детальніше<i class="header-icon el-icon-info"></i>
                                </template>
                                <p v-html="computedJackets.features.description"></p>
                            </el-collapse-item>
                            </el-collapse>
                    </div>                   
                </el-col>
        </div>
    </el-row>
</div>
</template>

<script>
import Axios from 'axios';
  export default {
    props: ['url', "selectedAccessories", "paramOfSelectedPump", "volumeFlow", "deliveryHead", "dataChart", "exchangeRates"],
    data() {
      return {
        accessories: {
            item1: {
                id:1,
                title: 'Прилад керування і захисту насоса',
                checked: false
            },
            item2: {
                id:2,
                title: 'Кабель та З’єднання насоса',
                checked: false
            },
            item3: {
                id:3,
                title: 'Мембранний напірний бак',
                checked: false
            },
            item4: {
                id:4,
                title: 'Кожух',
                checked: false
            }
        },
        dataTest:4.56465,
        focusInput: 1,
        activeAccessories: '',
        controllers: '',
        idController: this.selectedAccessories.item1.idController,
        cable:
            {
                description:'',
                price:'',
                section:'',
                name:'',
                id:'',
                length: 0
            },
        realSectionCable: 0,    
        computedCableSection: undefined,    
        mufts:'',
        idMufta:'',
        vessels:'',
        computedVessel:'',
        realNeedVessel:'',
        computedVesselId: 0,   
        typeInstallationJeckets: 0,        
        jackets:
            {
                horizontal:[],
                vertical: []
            },
        computedJackets:
            {
                id:'',
                name:'',
                price:'',
                features: {
                    description:'',
                    installation:'',                
                    length:'',
                    type:''
                }  
            },
        realNeedJacket: 0,
        computedJacketsId:0,
        diametrSkvagina: Number(this.paramOfSelectedPump.dim_H2)+10,
        computedJacketsNotNeeded: false
      }
    },
    filters: {
    aroundPrice: function (value) {
       value = Number(value).toFixed(2)
       return value
    }
    },
    computed: {
        selectedAccessoriesItem1 (){
            if (this.selectedAccessories.item1.selected==true) {
                return true
            } 
        }
    },
    created:  function() {
         this.realNeedVessel=330*this.volumeFlow*this.dataChart.Hnas[0]['y']/(20*(this.dataChart.Hnas[0]['y']-this.deliveryHead))
         this.realNeedJacket=Number(this.paramOfSelectedPump.dim_H2)+50     
         this.postDataJackets()
         this.postDataControllers(this.paramOfSelectedPump.current+'A')
         this.postDataVessels()
    },
    methods: {
    handleChangeTypeJeckets() {
        this.onComputeJacket()
    },
    changeDiameterSkvagina() {
        this.onComputeJacket()
    },
    onComputeJacket(){
        if (this.typeInstallationJeckets=='horizontal')
        {
            if (this.realNeedJacket <= this.jackets.horizontal[0].features.length)
            {
                this.computedJackets =this.jackets.horizontal[0]
            }
            else {
                this.computedJackets = this.jackets.horizontal[1]
            }           
        }
        else {
            let velosityFlow=this.volumeFlow/((Math.pow(this.diametrSkvagina*0.001, 2)-Math.pow(this.paramOfSelectedPump.dim_H2*0.001, 2))*Math.PI/4)/3600
            console.log(velosityFlow)
            if (velosityFlow <= 0.08)
            {
                this.computedJacketsNotNeeded=false
                if (this.realNeedJacket <= this.jackets.vertical[0].features.length)
                {
                    this.computedJackets =this.jackets.vertical[0]
                }
                else {
                    this.computedJackets = this.jackets.vertical[1]
                    }  
            }
            else {
                this.computedJacketsNotNeeded=true
            }            
        }
        this.$emit('onSelectJecket', this.computedJackets.id, this.computedJackets)
        this.accessories.item4.checked=true
    },        
    handleCommand(command) {
        this.computedVesselId=command        
        let obj=this.vessels[this.computedVesselId]
        let id=obj.id
        this.$emit('onSelectVessel', id, obj)
      },
    handleChange(id){
        this.idController=id
        this.onSelectController(id)
    },
    handleChangeMufta(id){
        this.idMufta=id
        this.onSelectMufta(id)
    },
    handleChangeCableLength(value){
        function getFloat(value){
        return parseFloat(value .replace(/,/, '.'));
        }

        let S=[1.5, 2.5, 4, 6, 10, 16.0, 25, 35, 50, 70, 95]
        this.realSectionCable=3.1*value*getFloat(this.paramOfSelectedPump.current)*getFloat(this.paramOfSelectedPump.cosf)/this.paramOfSelectedPump.U
        if (this.realSectionCable <= S[0]) {
                this.computedCableSection=S[0];
            }
            else {
                for(let i=0; i<= S.length; i++) {
                    if ((this.realSectionCable > S[i]) && (this.realSectionCable <= S[i+1])) 
                    {
                        this.computedCableSection=S[i+1];                        
                    }
            }
        }   
        this.cable.length=value
        let strData=String(this.computedCableSection)
        this.postDataCables(strData.replace('.', ','))       
    },
    onFocusInput(value) {
        this.focusInput=value  
        this.activeAccessories=this.accessories['item'+value].title
        if (value==3) {
        let obj=this.vessels[this.computedVesselId]
        let id=obj.id
        this.$emit('onSelectVessel', id, obj)
        this.accessories.item3.checked=true
        }
        if (value==1) {
            //  this.onSelectController(this.idController)
        }
       
    },
    onSelectCable(id, cable){
        this.$emit('onSelectCable', id, cable)
        this.accessories.item2.checked=true
    },
    onSelectController(id){
        let sourse=this.controllers
        let dataControlBox=sourse.filter( function(el) {
              return el.id==id
            }
        )
        this.$emit('onSelectController', id, dataControlBox )
        this.accessories.item1.checked=true
    },
    onSelectMufta(id){
        let sourse=this.mufts
        let dataMufta=sourse.filter( function(el) {
              return el.id==id
            }
        )
        this.$emit('onSelectMufta', id, dataMufta )
        
    },
    postDataControllers: function(current) {
        const getPromise = Axios.post(this.url+'db/controlSelect', {"current" : current});
        getPromise.then(response => {
        this.controllers = response.data;
        let sourse=this.controllers
        // let standartSelected= sourse.filter( function(el) {
        //       return el.features.class=="Економ"
        //     }
        // )
        // this.idController=standartSelected[0].id
        // this.onSelectController(this.idController)
        })
        .catch(error => {
        });
    },
    postDataVessels: function(current) {
        const getPromise = Axios.post(this.url+'db/getAllVessels');
        getPromise.then(response => {
        this.vessels = response.data;
        let sourse=this.vessels
        let vesselsV=[]
        for(let i=0; i<sourse.length; i++){
            let v=sourse[i].features.volume
            vesselsV.push(Number(v))
            }
            if (this.realNeedVessel <= vesselsV[0]) {
                this.computedVessel=vesselsV[0];
                this.computedVesselId=0
                }
                else {
                    for(let i=1; i< vesselsV.length; i++) {
                        if ((this.realNeedVessel > vesselsV[i]) && (this.realNeedVessel <= vesselsV[i+1])) 
                            {
                                this.computedVessel=vesselsV[i+1];  
                                this.computedVesselId=i+1                     
                            }
                    }
                }   
                })
                .catch(error => {
                });
    },
    postDataCables: function(section) {
            const getPromise = Axios.post(this.url+'db/cableSelect', {"section" : section});
            getPromise.then(response => {
            let dataArray=[]
            console.log(response.data)
            this.cable.id= response.data[0].id;
            this.cable.name= response.data[0].name;
            this.cable.price= response.data[0].price;
            this.cable.description= response.data[0].features.description;
            this.cable.section= response.data[0].features.section;
            let muftsLocal=response.data;
            this.onSelectCable(this.cable, this.cable.id)
            for (let i=1; i < muftsLocal.length;  i++) {
                dataArray.push(muftsLocal[i]);
            }
            this.mufts=dataArray 
            // let sourse=this.mufts
            
            // let standartSelected= sourse.filter( function(el) {
            // return el.features.class=="Економ"
            // })
            // this.idMufta=standartSelected[0].id
            // this.onSelectMufta(standartSelected[0].id)        
            })
            .catch(error => {
            });
    },
    postDataJackets: function() {
                const getPromise = Axios.post(this.url+'db/getAllJackets');
                getPromise.then(response => {
                let sourse=response.data;
                this.jackets.vertical=sourse.slice(0,2)
                this.jackets.horizontal=sourse.slice(2)  
                })
                .catch(error => {
                });
    }
    }
  };
</script>
<style scoped>
@-webkit-keyframes pulse1 {
    0% {
        opacity: 1;
        -webkit-transform: scale(1);
        transform: scale(1);
    }
    50% {
        opacity: 0;
        -webkit-transform: scale(1.5);
        transform: scale(1.5);
    }
    100% {
        opacity: 0;
        -webkit-transform: scale(1.5);
        transform: scale(1.5);
    }
}

@keyframes pulse1 {
    0% {
        opacity: 1;
        -webkit-transform: scale(1);
        transform: scale(1);
    }
    50% {
        opacity: 0;
        -webkit-transform: scale(1.5);
        transform: scale(1.5);
    }
    100% {
        opacity: 0;
        -webkit-transform: scale(1.5);
        transform: scale(1.5);
    }
}
p.detail-title {
    font-size: 18px;
    font-weight: 600;
}
.detail-title span {
    background: #eee;
    padding: 6px 14px;
}
.circle_number.number_1, .circle_number.number_2, .circle_number.number_3, .circle_number.number_4 {
    position: relative; 
    z-index: 6;    
}
.side-left-helper  .active {
    position: relative;
    top: -65px;
    z-index: 1;
    background: #fff;
    width: 20px;
    padding: 12px;
    height: 20px;
    border-radius: 50%;
    left: 0.5px;
    -webkit-animation: pulse1 2s linear infinite;
    -moz-animation: pulse1 2s linear infinite;
    animation: pulse1 2s linear infinite;
}
.side-right-helper .activeLeftCircle .circle, .side-left-helper .green .circle   {
    fill: #009c82;
    z-index: 5;
    position: relative;
}
.side-right-helper .circle_number {
    overflow: hidden;
}
.circle_number.number_1 {
    top: 132px;
    left: 116px;
}
.circle_number.number_2 {
    top: 214px;
    left: 101px;
}
.circle_number.number_3 {
    top: 90px;
    left: 263px;
}
.circle_number.number_4 {
    top: 392px;
    left: -20px;
}
.pos-img {
    position: relative;
    top: -27px;
}
.side-right-helper{
    padding-top: 20px;
    height: 340px;
}
.row-item {
    padding: 0;
    height: 60px;
    text-align: left;
}
.circle {
    fill: #febf00;
    stroke: transparent;
}
.circle_number {
    padding-top: inherit;
    margin-top: 10px;
}
.circle_number .symbolInCircle {
    position: relative;
    top: -34px;
    left: 12px;
    font-size: 20px;
    color: #fff;
    z-index: 6;
}

.side-left-helper .circle_number .symbolInCircle
{
    top: -33px;
    left: -1px;
}
.item {
    text-align: left;
    margin: 4px 5px 15px 0px;
    vertical-align: middle;
    float: left;
    color: #222;
    font-weight: 600;
}
.additional-volume-flow {
    display: inline-table;
    padding: 17px 55px 0 0px;
    text-align: left;
    margin-left: 78px;
}
.additional-volume-flow .link{
    color: #222222;
}
.computed-deliveryHead {
    font-size: 20px;
    text-align: left;
    margin-left: 121px;
    margin-top: 17px;
    color: #171717;
    padding: 15px;
}
.computed-deliveryHead .label {    
    font-weight: 600;
    padding-right: 25px;
    margin-left: 16px;
}
.computed-deliveryHead .number {
    border-bottom: 1px solid #b9b8b8;
    padding: 2px 15px;
}
.el-dialog__body {
    padding: 0;
}
.el-dialog__body h2 {
    color: #009c82;
}
p.sub-title {
    text-align: left;
    padding-left: 94px;
    font-size: 16px;
    font-weight: 600;
}
.side-side1-helper p {
    text-align: center
}
.block-accessoreis {
    display: inline-block;
    padding: 20px;
    text-align: left;
    max-width: 420px;
    font-size: 14px;
    margin: 0 20px;
    vertical-align: top;
}
.block-accessoreis p {
    text-align: left    
}
span.name-item, .name-item {
    font-size: 18px;
    font-weight: 600;
    color: #222;
}
.block-cabels {
    text-align: left;
    display: flex;
    justify-content: flex-start;
}
.accessorie {
    text-align: left;
}
.lable-class {
    position: relative;
    top: -53px;
    left: 0px;
    font-size: 12px;
    width: 80px;
    text-align: center;
    color: #fff;
    text-transform: uppercase;
    letter-spacing: 1px;
}
.checked {
    display: inline-block;
    position: relative;
    left: -62px;
    top: -9px;
}
.checked::before {
    font-family: 'wilo-icons';
    font-size: 22px;
    margin-left: -20px;
    color: #009c82;
    content: "\2021";
    width: 23px;
    display: inline-table;
    position: relative;
    top: 0px;
    font-weight: bold;
}
.el-radio-button:first-child:last-child .el-radio-button__inner {
    border-radius: 0;
}
</style>

