<template>
<div v-loading="loading">
    <h2>Підбір приладдя до свердловинного насосу</h2>
    <el-row class="accesorias-top">
        <el-col :span="10" :offset="2" class="side-left-helper">
            
            <el-button  v-for="item in accessories" @click="onFocusInput(item.id)" :key='item.id' :class="['circle_number number_'+item.id, {green: focusInput==item.id}]" type="text">                   
                    <svg height="36" width="36" class="circle" >
                    <circle cx="17" cy="17" r="17" stroke="" stroke-width="2" fill="" />
                    </svg><div class="symbolInCircle">{{item.id}}</div>
                    <div :class="[{active: focusInput==item.id}]"></div>                            
            </el-button>
        <img class="pos-img" :src="url+'assets/accessories.jpg'" width="450" alt="">
        </el-col>
        <el-col :span="10" :offset="2" class="side-right-helper">
            <div v-for="item in accessories" class="row-item" :key='item.id' :class="[{activeLeftCircle: accessoriesIsChecked['item'+item.id]==true}]">
                    <el-button type="text" @click="onFocusInput(item.id)"> 
                    <span class="item" >
                        <div class="circle_number">                   
                            <svg height="36" width="36" class="circle">
                            <circle cx="17" cy="17" r="17" stroke="" stroke-width="2" fill="" />
                            </svg><div class="symbolInCircle">{{item.id}} </div>  
                        </div><div v-show="focusInput==item.id" class="checked"></div>
                        <span style="font-weight: 600;">{{item.title}}</span></span></el-button> 
                       
                              
            </div>           
        </el-col>
    </el-row> 
    <el-row>
        <h4>{{activeAccessories}}</h4>
        <el-row v-if="focusInput==1" >   
            <Step3-helperController
                :selectedAccessories="selectedAccessories"
                :url="url"
                :controllers="controllers"
                :paramOfSelectedPump="paramOfSelectedPump"
                @ClearControllerSelect="ClearControllerSelect"
                @handleChange="handleChang"
            />
            <el-row class="accesorias-item" :gutter="20">
                <div v-for="item in controllers" :key="item.id">                
                <el-col v-if="!(paramOfSelectedPump.phase==3 && item.features.phase==1)">            
                    <el-card style="min-width:300px">                                   
                                <div style="float:right">
                                    <img v-if="item.features.class=='Економ'" :src="url+'assets/econom.jpg'" width="70px" alt="">
                                    <img v-if="item.features.class=='Стандарт'" :src="url+'assets/standart.jpg'" width="70px" alt="">
                                    <img v-if="item.features.class=='Преміум'" :src="url+'assets/premium.jpg'" width="70px" alt="">
                                </div> 
                                <img :src="url+'assets/'+item.features.img"  class="image"> 
                            <p class="stronge-price">{{item.name}}</p>                        
                            <el-collapse accordion> 
                            <el-collapse-item name="1">
                                <template slot="title">
                                Більше<i class="header-icon el-icon-info"></i>
                                </template>
                            <p class="text" v-html="item.features.description"></p>
                            <p><strong>Максимальний струм:</strong> {{item.features.current_max}} A </p>
                            <p><strong>Розміри:</strong> {{item.features.dim}}  </p>
                            <p><strong>Тип пуску насоса:</strong> {{item.features.start}}</p>
                            <p>
                              <strong>Управління:</strong> {{item.features.operation}}    
                            </p>                                                  
                            <p><el-popover
                                placement="top-start"
                                width="250"
                                trigger="hover"
                                :content=dictionary[7].full_text>
                                <el-button type="text"  slot="reference"><span class="myTip">Захист від сухого ходу:</span></el-button>
                                </el-popover> 
                                {{item.features.dry_running}}</p> 
                                
                                <a class="download" :href="url+'assets/'+item.features.OM+'.pdf'" download><i class="el-icon-document"></i> Завантажити інструкцію з експлуатації</a>
                                                                                        
                            </el-collapse-item>
                            </el-collapse>
                            <p >Ціна <span class="stronge-price">{{item.price*exchangeRates | aroundPrice}}</span>грн з пдв</p> 
                            <el-radio-group  v-model="selectedAccessories.item1.idController" @change="handleChange(item.id)">
                                <el-radio-button v-show="item.id!=selectedAccessories.item1.idController" type="primary" :label="item.id">Вибрати</el-radio-button>
                            </el-radio-group> 
                            <el-button v-show="item.id==selectedAccessories.item1.idController" type="primary" @click="ClearControllerSelect()">Відмінити</el-button>  
                    </el-card>
                </el-col>
                </div> 
            </el-row> 
        </el-row>
        <!-- //Cable-->
        <el-row class="accesorias-item" v-if="focusInput==2" >
            
                <el-card>            
                        <img style="" :src="url+'assets/cable.jpg'" width="120" alt="">
                        <el-row justify="center">
                           <span class="detail-title">Довжина<el-input-number v-model="cable.length" @change="handleChangeCableLength(cable.length)" :min="1"></el-input-number>м </span> 
                            <div v-if="computedCableSection">
                                   
                                    <el-collapse accordion> 
                                    <el-collapse-item name="1">
                                        <template slot="title">
                                        Більше<i class="header-icon el-icon-info"></i>
                                        </template>
                                        <p v-html="cable.description"></p> 
                                    </el-collapse-item>
                                    </el-collapse>
                                    <p class="detail-title"> Переріз <span> 4 х {{computedCableSection}} мм<sup>2</sup></span></p>                            
                                    <p>Ціна <span class="stronge-price">{{(cable.price*exchangeRates) | aroundPrice}}</span>грн з пдв за 1м.п.</p>                       
                            </div>                         
                        </el-row>                       

                    <el-checkbox-button v-show="!cable.checked"  type="primary" checkbox-group="false" @change="onCheckCable()" v-model="cable.checked">Вибрати</el-checkbox-button>                
                    <el-button v-show="cable.checked" type="primary" @click="ClearCableSelect()">Відмінити</el-button>  
                </el-card>                
            
            <el-collapse-transition name="el-fade-in-linear">
            <el-col v-if="computedCableSection" :md="12" :sm="24">               
                        <div class="accesorias-item-mufts" v-for="item in mufts" :key="item.id">
                            <el-card >
                                    <div style="float:right">
                                        <img v-if="item.features.class=='Економ'" :src="url+'assets/econom.jpg'" width="70px" alt="">
                                        <img v-if="item.features.class=='Стандарт'" :src="url+'assets/standart.jpg'" width="70px" alt="">
                                        <img v-if="item.features.class=='Преміум'" :src="url+'assets/premium.jpg'" width="70px" alt="">
                                    </div>
                                    <img v-if="item.features.type=='coupling filler'" :src="url+'assets/mufta_zal.jpg'"  class="image">
                                    <img v-else-if="item.features.type=='coupling thermo'" :src="url+'assets/mufta_termo.jpg'"   class="image">                        
                                        <p class="stronge-price">{{item.name}}</p>                   
                                        <el-collapse accordion> 
                                        <el-collapse-item name="1">
                                            <template slot="title">
                                            Більше<i class="header-icon el-icon-info"></i>
                                            </template>
                                            <p class="text" v-html="item.features.description"></p>
                                            <a  v-if="item.features.type=='coupling filler'"  class="download" :href="url+'assets/'+item.features.OM+'.pdf'" download><i class="el-icon-document"></i> Завантажити інструкцію з експлуатації</a>
                                        </el-collapse-item>
                                        </el-collapse>
                                        <p>Ціна <span class="stronge-price">{{item.price*exchangeRates | aroundPrice}}</span>грн з пдв</p>   
                                        <el-radio-group v-model="selectedAccessories.item3.idMufta"  @change="handleChangeMufta(item.id)">
                                        <el-radio-button v-show="item.id!=selectedAccessories.item3.idMufta" type="primary" :label="item.id">Вибрати</el-radio-button>                                        
                                        </el-radio-group>
                                        <el-button v-show="item.id==selectedAccessories.item3.idMufta" type="primary" @click="ClearMuftaSelect()">Відмінити</el-button> 
                            </el-card>            
                    </div>                         
            </el-col>
            </el-collapse-transition >  
            <!-- // MUFTA-->

        </el-row>
        <!-- // VESSEL-->
        <div v-if="focusInput==3" >
            <el-row class="accesorias-item">
                <el-col :md="3" :sm="24">
                    <img style="" :src="url+'assets/bak.jpg'" width="150" alt="">
                </el-col>
                <el-col :offset="1" :md="8" :sm="24">                    
                    <p class="name-item">{{vessels[computedVesselId].name}}</p>
                            <el-collapse accordion> 
                            <el-collapse-item name="1">
                                <template slot="title">
                                Більше<i class="header-icon el-icon-info"></i>
                                </template>
                                    <p>Тиск: <strong>{{vessels[computedVesselId].features.pressure}}</strong> Бар </p>
                                    <p>Діаметр: <strong>{{vessels[computedVesselId].features.dim_diam}}</strong>  мм</p>
                                    <p>Висота:<strong>{{vessels[computedVesselId].features.dim_height}}</strong>  мм</p>
                                    <p>Вага: <strong>{{vessels[computedVesselId].features.weight}}</strong>  кг</p>
                                    <p>Діаметр з’єднання:  <strong>{{vessels[computedVesselId].features.dim_connection}}</strong>" </p>   
                                <p v-html="vessels[computedVesselId].features.description"></p>
                                <!-- <a class="download" :href="url+'assets/'+vessels[computedVesselId].features.OM+'.pdf'" download><i class="el-icon-document"></i> Завантажити інструкцію з експлуатації</a> -->
                            </el-collapse-item>
                            </el-collapse>
                    <p>Ціна <span class="stronge-price">{{vessels[computedVesselId].price*exchangeRates | aroundPrice}}</span>грн з пдв</p>   
                    <p>   <el-popover
                            placement="top-start"
                            width="250"
                            trigger="hover"
                            content='Рекомендуєм об’єм бака для зменшення кількості включень насоса. Допускається зменшення об‘єму бака у 2 рази при використанні Преміум прилада керування'>
                            <span type="text" class="myTip" slot="reference">Рекомендований ВІЛО об'єм</span>
                        </el-popover><strong> {{computedVessel}} л</strong>
                    </p>                       
                    <el-dropdown split-button @command="handleCommand">
                        <span class="el-dropdown-link">
                        <strong>{{vessels[computedVesselId].features.volume}}</strong> л 
                        </span>
                    <el-dropdown-menu slot="dropdown" >                
                        <el-dropdown-item :command="index" v-for="(item, index) in vessels" :key="item.id">{{item.features.volume}}</el-dropdown-item>
                    </el-dropdown-menu>
                    </el-dropdown>
                    <div style="margin-left:10px; display: inline-block;">
                        <el-checkbox-button v-if="!selectedAccessories.item4.selected"  type="primary"  checkbox-group="false" @change="onSelectVessel()" v-model="selectedAccessories.item4.selected">Вибрати</el-checkbox-button> 
                        <el-button v-else  type="primary" @click="ClearVesselSelect()">Відмінити</el-button>   
                    </div>
  
                </el-col>
            </el-row>
        </div>
        <!-- // JacketS-->
        <div v-if="focusInput==4" class="accesorias-item">
                <el-col :md="5" :sm="24"> 
                    <img  :src="url+'assets/jackets.jpg'" width="250" alt="">                    
                </el-col>
                <el-col :md="11" :sm="24">
                        <div class="radio-jackets">
                            <el-radio class="radio-jackets" v-model="typeInstallationJackets"  @change="handleChangeTypeJackets()" label="vertical">
                            <el-popover
                                placement="top-start"
                                width="250"
                                trigger="hover"
                                :content=dictionary[11].full_text>
                                <span class="myTip" slot="reference">Для монтажу в свердловині</span>
                            </el-popover> 
                            </el-radio>                            
                        </div>
                        <div class="radio-jackets">
                            <el-radio class="radio-jackets" v-model="typeInstallationJackets"  @change="handleChangeTypeJackets()" label="horizontal"> 
                                <el-popover
                                placement="top-start"
                                width="250"
                                trigger="hover"
                                :content=dictionary[12].full_text>
                                <span class="myTip" slot="reference">Для монтажу в резервуарі </span>
                            </el-popover>
                            </el-radio>                            
                        </div>

                    <div v-show="typeInstallationJackets =='vertical'">
                        
                          <el-alert v-if="computedJacketsNotNeeded"
                            title="Кожух охолодження не потрібен"
                            type="warning"
                            description="Вкажіть дійсний діаметр свердловини для розрахування охолоджуючого кожуху"
                            show-icon>
                        </el-alert>
                                       
                        <div v-else-if="diametrSkvagina!=0">
                            <p class="name-item">{{computedJackets.name}}</p>
                            <p>Довжина <strong>{{computedJackets.features.length}}</strong> мм</p>
                            <p>Ціна <span class="stronge-price">{{computedJackets.price*exchangeRates | aroundPrice}}</span>грн з пдв</p>
                            
                            <el-collapse accordion> 
                            <el-collapse-item name="1">
                                <template slot="title">
                                Більше<i class="header-icon el-icon-info"></i>
                                </template>
                                <p v-html="computedJackets.features.description"></p>
                                <a class="download" :href="url+'assets/'+computedJackets.features.OM+'.pdf'" download><i class="el-icon-document"></i> Завантажити інструкцію з експлуатації</a>
                            </el-collapse-item>
                            </el-collapse>                            
                        </div>
                        <p>
                            Діаметр  <el-input-number v-show="typeInstallationJackets =='vertical'" @change="changeDiameterSkvagina()"  v-model="diametrSkvagina" :min="110"></el-input-number> мм 
                        </p>
                        <div style="margin-top:10px">
                            <el-checkbox-button v-if="!selectedAccessories.item5.selected" :disabled="computedJacketsNotNeeded"  checkbox-group="false" @change="onSelectJacket()" v-model="selectedAccessories.item5.selected">Вибрати</el-checkbox-button>
                            <el-button v-else type="primary" @click="ClearJecketSelect()">Відмінити</el-button> 
                        </div>
 
                    </div>
                    <div v-if="typeInstallationJackets =='horizontal'">               
                        <p class="name-item">{{computedJackets.name}}</p>
                        <p>Довжина <strong>{{computedJackets.features.length}}</strong> мм</p>
                        <p>Ціна <span class="stronge-price">{{computedJackets.price*exchangeRates | aroundPrice}}</span>грн з пдв</p>
                            <el-collapse accordion> 
                            <el-collapse-item name="1">
                                <template slot="title">
                                Більше<i class="header-icon el-icon-info"></i>
                                </template>
                                <p v-html="computedJackets.features.description"></p>
                                <a class="download" :href="url+'assets/'+computedJackets.features.OM+'.pdf'" download><i class="el-icon-document"></i> Завантажити інструкцію з експлуатації</a>
                            </el-collapse-item>
                            </el-collapse>
                        <div style="margin-top:10px">
                        <el-checkbox-button v-if="!selectedAccessories.item5.selected" type="primary" checkbox-group="false" @change="onSelectJacket()" v-model="selectedAccessories.item5.selected">Вибрати</el-checkbox-button> 
                        <el-button v-else type="primary" @click="ClearJecketSelect()">Відмінити</el-button> 
                        </div>
         
                    </div>                    
                </el-col>
        </div>
    </el-row>
    <div>
    <div class="steps-nav">        
        <div class="steps-bottom">
            
                <div v-for="item in accessories" class="row-item" :key='item.id' :class="[{activeLeftCircle: accessoriesIsChecked['item'+item.id]==true}]">
                    <el-col :span="5" :offset="1">
                        <el-button type="text" @click="onFocusInput(item.id)">
                        <span class="item" >
                            <div class="circle_number">                   
                                <svg height="36" width="36" class="circle">
                                <circle cx="17" cy="17" r="17" stroke="" stroke-width="2" fill="" />
                                </svg><div class="symbolInCircle">{{item.id}} </div>  
                            </div>
                        </span></el-button>
                        <el-collapse-transition>
                                <div v-show="focusInput==item.id" class="bottom-checked"></div>
                        </el-collapse-transition>
                        <div class="step-title" @click="onFocusInput(item.id)">{{item.title}}</div>                                            
                    </el-col>       
                </div>
                
        </div>
        <el-row class="navigation-footer">
            <el-col :xs="8" :sm="8" :md="12" :lg="12" :xl="12">
                <el-button :disabled="!(focusInput>1)" type="primary" class="nextAccssorias" @click="back"><i class="el-icon-d-arrow-left el-icon-left"></i> Назад</el-button>
            </el-col>
            <el-col :xs="8" :sm="8" :md="6" :lg="6" :xl="6"> 
                <el-button v-show="(focusInput<4)" type="primary" class="nextAccssorias" @click="next">Далі <i class="el-icon-d-arrow-right el-icon-right"></i></el-button>
            </el-col>
            <el-col :xs="8" :sm="8" :md="6" :lg="6" :xl="6"> 
                <el-button v-show="focusInput>=1" type="primary" class="nextAccssorias" @click="close">Закрити <i class="el-icon-close el-icon-right"></i></el-button>
            </el-col>
        </el-row>
        <el-row>
        
        </el-row> 
    </div>
    </div>
</div>
</template>

<script>
import Axios from 'axios';
  export default {
    props: ['url', "dictionary", "selectedAccessories", "paramOfSelectedPump", "volumeFlow", "deliveryHead", "dataChart", "exchangeRates"],
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
                title: 'Занурювальний кабель та з’єднання',
                checked: false
            },
            item3: {
                id:3,
                title: 'Мембранний напірний бак',
                checked: false
            },
            item4: {
                id:4,
                title: 'Кожух охолодження',
                checked: false
            }
        },
        loading: false,
        focusInput: 1,
        activeAccessories: 'Прилад керування і захисту насоса',
        controllers: '',
        idController: this.selectedAccessories.item1.idController,
        cable:
            {
                description:'',
                price:'',
                section:'',
                name:'',
                id:'',
                length: this.selectedAccessories.item2.length,
                checked: this.selectedAccessories.item2.selected
            },
        realSectionCable: 0,    
        computedCableSection: "",    
        mufts:'',
        idMufta:'',
        vessels:'',
        computedVessel:'',
        realNeedVessel:'',
        computedVesselId: 0,   
        typeInstallationJackets: this.selectedAccessories.item5.typeInstallationJackets,        
        jackets:
            {
                horizontal:[],
                vertical: []
            },
        velosityFlow:0,
        computedJackets:
            {
                id:'',
                name: this.selectedAccessories.item5.name,
                price: this.selectedAccessories.item5.price,
                features: {
                    description: this.selectedAccessories.item5.description,
                    installation:'',                
                    length: this.selectedAccessories.item5.length,
                    type:'',
                    OM: ''
                }  
            },
        realNeedJacket: 0,
        computedJacketsId:0,
        diametrSkvagina: 110,
        computedJacketsNotNeeded: false
      }
    },
    filters: {
    aroundPrice: function (value) {
        let val = (value/1).toFixed(0)
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")+',- '
        }
    },
    mounted: function () {
    },
    computed: {
        accessoriesIsChecked (){
            let obj={}
            if (this.selectedAccessories.item1.selected==true) {
                obj.item1=true
            } 
            if (this.selectedAccessories.item2.selected==true) {
                obj.item2=true
            }
            else {
                this.cable.checked=false
                obj.item2=false                
            }
            // if (this.selectedAccessories.item2.selected==false) {
            //     this.cable.checked=false
            //     obj.item2=false
            // }
            if (this.selectedAccessories.item4.selected==true)  {
                obj.item3=true
                // let vessel=this.vessels[this.computedVesselId]
                // let id= vessel.id
                // this.$emit('onSelectVessel', id, vessel) 
            }            
            else  {
                obj.item4=false
            }
            if (this.selectedAccessories.item5.selected==true)  {
                obj.item4=true
               
            }
            return obj
        },
            allAccessoriesSelected: function() {
            if (
                    this.selectedAccessories.item1.selected  &&
                    this.selectedAccessories.item2.selected  &&
                    this.selectedAccessories.item4.selected  &&
                    this.selectedAccessories.item5.selected 
                ) 
                {
                    //this.onDialogAccept()
                    return true;
                }
        }
    },
    created:  function() {
        this.loading=true
         this.realNeedVessel=330*this.dataChart.CalcPoint[0].x*this.dataChart.Hnas[0]['y']/(20*(this.dataChart.Hnas[0]['y']-this.dataChart.CalcPoint[0].y))
         this.postDataJackets()
         this.postDataControllers(this.paramOfSelectedPump.current+'A')
         this.postDataVessels()
    },
    methods: {
 
    next() {
        if (this.focusInput++ > 3) this.focusInput = 1;
        this.onFocusInput(this.focusInput)
      },
    back() {
        if (this.focusInput-- < 3) this.focusInput = 1;
        this.onFocusInput(this.focusInput)
      },
    close() {
        this.$emit('onCloseHelper', 1)      
      },
    //*******Begin cablese logics
    postDataCables: function(section) {            
            const getPromise = Axios.post(this.url+'db/cableSelect', {"section" : section});
            getPromise.then(response => {
            let dataArray=[]
            this.cable.id= response.data[0].id;
            this.cable.name= response.data[0].name;
            this.cable.price= response.data[0].price;
            this.cable.article= response.data[0].article;
            this.cable.description= response.data[0].features.description;
            this.cable.section= response.data[0].features.section;
            let muftsLocal=response.data;
            this.onSaveSelectCable(this.cable, this.cable.id)
            for (let i=1; i < muftsLocal.length;  i++) {
                dataArray.push(muftsLocal[i]);
            }
            this.mufts=dataArray     
            })
            .catch(error => {
            });
    },
    onSaveSelectCable(id, cable){
        this.$emit('onSelectCable', id, cable)        
    },
    handleChangeCableLength(value){
        this.cable.checked=false
    },
    onComputeCableSection(value){
        function getFloat(val){
            return parseFloat(val .replace(/,/, '.'));
        }
        let S=[1.5, 2.5, 4, 6, 10, 16.0, 25, 35, 50, 70, 95]
        this.realSectionCable=3.1*value*getFloat(this.paramOfSelectedPump.current)*getFloat(this.paramOfSelectedPump.cosf)/(this.paramOfSelectedPump.U*3)
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
    onCheckCable(val) {        
        this.cable.selected=!this.cable.selected  
        this.onComputeCableSection(this.cable.length)
    },
    //*******Jackets
     handleChangeTypeJackets() {
        this.selectedAccessories.item5.selected=false
        this.onComputeJacket()
    },
    changeDiameterSkvagina() {
        this.selectedAccessories.item5.selected=false
        this.onComputeJacket()
    },
    onComputeJacket(){
        if (this.typeInstallationJackets=='horizontal')
        {
            let realNeedJacketHeight= this.paramOfSelectedPump.dim_H2+50
            if (realNeedJacketHeight <= this.jackets.horizontal[0].features.length)
            {
                this.computedJackets =this.jackets.horizontal[0]
            }
            else {
                this.computedJackets = this.jackets.horizontal[1]
            } 
        }
        else {
            this.velosityFlow=this.volumeFlow/((Math.pow(this.diametrSkvagina*0.001, 2)-Math.pow(98*0.001, 2))*Math.PI/4)/3600
            if (this.velosityFlow <= 0.08)
            {
                this.computedJacketsNotNeeded=false
                if (this.realNeedJacketHeight <= this.jackets.vertical[0].features.length)
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
    },
    onSelectJacket(){
        this.selectedAccessories.item5.selected=true
        this.$emit('onSelectJacket', this.computedJackets.id, this.computedJackets, this.typeInstallationJackets)
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
    },        
    handleCommand(command) {
        this.computedVesselId=command  
        this.selectedAccessories.item4.selected=false
      },
    handleChange(id){
        this.idController=id        
        this.onSelectController(id)
    },
    ClearControllerSelect(){
        this.selectedAccessories.item1.idController=undefined
        this.selectedAccessories.item1.selected=false
    },
    ClearCableSelect() {
        this.selectedAccessories.item2.idCable=undefined
        this.selectedAccessories.item2.selected=false
    },
    ClearMuftaSelect(){
        this.selectedAccessories.item3.idMufta=undefined
        this.selectedAccessories.item3.selected=false
    },
    ClearVesselSelect(){
        this.selectedAccessories.item4.idVessel=undefined
        this.selectedAccessories.item4.selected=false
    },
    ClearJecketSelect() {
        this.selectedAccessories.item5.idJacket=undefined
        this.selectedAccessories.item5.selected=false
    },
    handleChangeMufta(id){
        this.idMufta=id
        this.onSelectMufta(id)
    },
    onFocusInput(value) {
        this.focusInput=value  
        this.activeAccessories=this.accessories['item'+value].title    
    },
    onSelectController(id){
        let sourse=this.controllers
        let dataControlBox=sourse.filter( function(el) {
              return el.id==id
            }
        )
        this.$emit('onSelectController', id, dataControlBox )
    },
    onSelectMufta(id){
        let sourse=this.mufts
        let dataMufta=sourse.filter( function(el) {
              return el.id==id
            }
        )
        this.$emit('onSelectMufta', id, dataMufta )        
    },
    onSelectVessel(val) {
            this.selectedAccessories.item4.selected==true
            let obj=this.vessels[this.computedVesselId]
            let id=obj.id
            this.$emit('onSelectVessel', id, obj)   
     
        // }
        // else {
        //     this.selectedAccessories.item4.selected==false
        // }   
    },
    postDataControllers: function(current) {        
        const getPromise = Axios.post(this.url+'db/controlSelect', {"current" : current});
        getPromise.then(response => {
        this.controllers = response.data;
        let sourse=this.controllers
        this.loading=false
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
        function find (array, value){
            let obj={}
            if (value <= array[0]) {
                obj.index=0
                obj.val=array[0]
                return obj
            }
            else {
                for (var i = 0; i < array.length; i++) {
                    if ((value > array[i]) && (value <= array[i+1])) {
                        obj.index=i+1
                        obj.val=array[i+1]
                        return obj;
                    } 
                    
                } 
                if (value > array[array.length-1]) return obj='out'               
            }
        }
            for(let i=0; i<sourse.length; i++){
                let v=sourse[i].features.volume
                vesselsV.push(Number(v))           
            }
            let additionalVessels= [750, 1000, 1250, 1500, 2000, 2500, 3000]
            if (find(vesselsV, this.realNeedVessel)!= 'out') {
                this.computedVessel=find(vesselsV, this.realNeedVessel).val
                this.computedVesselId=find(vesselsV, this.realNeedVessel).index
            }
            else {
                this.computedVessel=find(additionalVessels, this.realNeedVessel).val
                this.computedVesselId=vesselsV.length-1
            }
              
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
.pos-img {
    margin-left: 8%;
    margin-top: -20px;
    text-align: left;
    position: absolute;
    left: 54px;
}
p.detail-title {
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
 .activeLeftCircle .circle, .side-left-helper .green .circle   {
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
.side-right-helper{
    padding-top: 20px;
    height: 370px;
}
.row-item {
    padding: 0;
    height: 60px;
    text-align: left;
    margin-left: 15px;
}
.circle {
    fill: #febf00;
    stroke: transparent;
}
.circle_number {
    padding-top: inherit;
    margin-top: -10px;
   
}
.circle_number .symbolInCircle {
    position: relative;
    top: -30px;
    left: 12px;
    font-size: 20px;
    color: #fff;
    z-index: 6;
}
.side-left-helper .circle_number {
    padding-top: 45px;
    margin-top: -40px;
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
}
span.name-item, .name-item {
    font-size: 18px;
    font-weight: 600;
    color: #222;
}
.image {
    display: block;
    height: 100px;
    padding: 0 0 0 14%;
    margin: 0 auto;
  }
.checked {
    border-bottom: 2px solid #009c82;
    position: relative;
    top: 21px;
    left: 49px;
}
.bottom-checked {
    position: relative;
    top: -24px;
    left: 2px;
    width: 200px;
    height: 2px;
    background: #009c82;

}
/* .checked::before {
    font-family: 'wilo-icons';
    font-size: 22px;
    margin-left: -20px;
    color: #009c82;
    content: "\2021";
    width: 23px;
    display: inline-table;
    position: relative;
    top: 8px;
    font-weight: bold;
} */

.step-title{
    width: 150px;
    margin-top: -76px;
    margin-left: 44px;
    margin-right: 34px;
    cursor: pointer;
}
.steps-bottom {
    background: #f7f7f7;
    padding-top: 14px;
    margin: 15px 0;
}
.steps-bottom .row-item {
    display: inline-block
}
span.detail-title {
    margin-bottom: 8px;
    display: block;
}
</style>

