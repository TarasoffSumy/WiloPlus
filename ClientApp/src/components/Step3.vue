<template>
<div >
    <el-dialog
        title=""
        :visible.sync="dialogVisible"
        width="80%">
        <Step3-helper 
            :url="url"
            :paramOfSelectedPump="paramOfSelectedPump"
            :selectedAccessories="selectedAccessories"
            :dataChart="dataChart"
            :volumeFlow="volumeFlow"
            :deliveryHead="deliveryHead"
            :exchangeRates="exchangeRates"
            :dictionary="dictionary"
            @onSelectController="onSelectController"
            @onSelectCable="onSelectCable"
            @onSelectMufta="onSelectMufta"
            @onSelectVessel="onSelectVessel"
            @onSelectJecket="onSelectJecket"
            /> 
        <div slot="footer" class="dialog-footer">       
            <el-row class="navigation-footer">
            <el-col :span="24">
                <el-button type="primary" @click="onDialogAccept">Закрити<i class="el-icon-d-arrow-right el-icon-right"/></el-button>
            </el-col>
            </el-row>   
        </div>
    </el-dialog>

    <el-row>
        <div class="circle_number">
            <svg height="55" width="53" class="circle">
            <circle cx="26" cy="26" r="24" stroke="" stroke-width="2" fill="" />
            </svg> <span>3 </span>            
        </div>
        <h2 class="title">Підбір насоса та приладдя </h2>
    </el-row>
    
    <el-row>
    <div class="greyBoxes-container">
        <div class="greyBox" v-if="idPump">
                <el-row>
                    <h3>Підбраний насос <el-button @click="onDeletePump" type="text"><i style="font-size:22px" class="el-icon-refresh"></i></el-button> </h3>


                    <el-col  :span="4" >
                    
                    <img style="margin-left:-19px" width="150" :src="url+'assets/wilo-skvaginniy-nasos-actun-first-spu4.jpg'"/>   
                    </el-col>
                    <el-col  :offset="1"  :span="19" >
                    <el-card v-if="refresh">
                    FIRST SPU4. <el-autocomplete
                            class="inline-input"
                            v-model="itemSelect"
                            :fetch-suggestions="querySearch"
                            placeholder="введіть серію насосу"
                            :trigger-on-focus="false"
                            @select="handleSelect"
                        ></el-autocomplete>                        
                    </el-card>
                       <h4 style="margin: 10px 0 15px 0;">ACTUN {{objSelectedPump.shortName}}</h4>
                        <p>Тип живлення:</p>                
                                <div v-for="item in objPump" :value="item" :key="item.id" class="radio-item-phasa" >
                                    <el-radio v-model="idPump" :label="item.id" @change="handleChangePhase(item.id)">
                                                    <span  v-if="item.features.phase=='1'">
                                                        <el-popover
                                                            placement="top-start"
                                                            :title=dictionary[5].short_text
                                                            width="250"
                                                            trigger="hover"
                                                            :content=dictionary[5].full_text>
                                                            <el-button type="text"  slot="reference"><span class="myTip">однофазній</span></el-button>
                                                        </el-popover> 
                                                        </span>
                                                    <span v-if="item.features.phase=='3'">
                                                        <el-popover
                                                            placement="top-start"
                                                            :title=dictionary[6].short_text
                                                            width="250"
                                                            trigger="hover"
                                                            :content=dictionary[6].full_text>
                                                            <el-button type="text"  slot="reference"><span class="myTip">трихфазний</span></el-button>
                                                        </el-popover> 
                                                    </span>
                                    </el-radio>       
                                </div>
                                <p class="sub-title">Насосний агрегат: {{objSelectedPump.name}}</p> 
                                <p class="sub-title price">Ціна {{objSelectedPump.price}} грн. з ПДВ</p>
                                <el-collapse accordion> 
                                    <el-collapse-item>
                                        <template slot="title">
                                        <p class="sub-title">Конструкція</p><i class="header-icon el-icon-info"></i>
                                        </template>                                        
                                        <p>Багатоступеневий насос 4" із занурюваним двигуном, виконання з кожухом, для вертикальної або горизонтальної установки</p>
                                        <p><span class="sub-title">Номінальна потужність двигуна:</span> {{objSelectedPump.n_power}} kW </p>
                                        <p><span class="sub-title">Номінальний струм:</span> {{objSelectedPump.current}} A </p>                    
                                    </el-collapse-item>
                                </el-collapse>

                    </el-col>                
                </el-row>

                <el-row style="margin: 20px 0;">

                    <el-col :offset=1 :span="4">
                       
                        <p><span class="sub-title point"></span></p>                        
                        <p><span class="sub-title">Витрата</span></p> 
                        <p><span class="sub-title">Напір</span></p>   
                    </el-col>
                    <el-col :span="10">
                        
                        <p><span class="sub-title point">Робоча точка отримана від користувача:</span></p>                        
                        <p> {{volumeFlow}} м<sup>3</sup>/год</p> 
                        <p>{{deliveryHead}} м</p>                          
                    </el-col>
                    <el-col :span="6">
                        
                        <p><span class="sub-title point">Робоча точка фактична:</span></p>                        
                        <p> {{dataChart.CalcPoint[0].x | aroundNumber}} м<sup>3</sup>/год </p> 
                        <p> {{dataChart.CalcPoint[0].y | aroundNumber}} м</p>                          
                    </el-col>
                </el-row>
                <el-row>
                    <div id="print" style="margin-left:45px;position: relative; width:300px: top:20px">

                    <Chart :key="id" :dataChart="objDataChart"/>   
                    </div>                      
                </el-row>      
                 
                      
                 
            </div>
            <div v-else class="greyBox">
                Насос не знайден!
                Скорегуйте напор та витрату
            </div>
        <div class="greyBox last-box">
                 <font-awesome-icon icon="lightbulb" />
                 <p style="padding-top: 20px;">Підібрати приладдя до насосу</p>
                 <div class="container-button">
                 <el-button class="calc-btn" style="margin-top: -20px;"  type="primary" @click="dialogVisible = true"><img  width="20" :src="url+'assets/calc.png'">Підібрати</el-button>                                     
                 </div>
             
            <div  v-if="existAccessories" class="item-selected">
            <h3>Підібране приладдя</h3>
            <el-card  class="box-card" v-if="selectedAccessories.item1.selected">
                <h3>{{selectedAccessories.item1.title}}</h3>
                    <el-col :span="2" :offset="1"><el-button @click="onDeleteAccessories(1)" type="text"><i class="el-icon-circle-close-outline"></i></el-button> </el-col>
                    <el-col :span="20">
                        <div class="accessories">
                            <el-col :span="6">
                                <img :src="url+'assets/controller.jpg'" width="100px" alt="">
                            </el-col>
                            <el-col :span="17" :offset="1" class="text"></el-col>
                            <el-row>
                            <strong>{{selectedAccessories.item1.name}} </strong>
                                <p class="stronge-price">Ціна: {{selectedAccessories.item1.price}} грн з ПДВ</p>  
                                <p>Ток максимальний:<strong>{{selectedAccessories.item1.current_max}}</strong>  A </p>
                                <div class="expand-view">
                                <p><strong>Розміри:</strong> {{selectedAccessories.item1.dim}}  </p>
                                <p><strong>Тип пуску насоса:</strong> {{selectedAccessories.item1.start}}  </p> 
                                <p><strong>Управління:</strong> {{selectedAccessories.item1.operation}}  </p>                       
                                <p><strong>Захист від сухого ходу:</strong> {{selectedAccessories.item1.dry_running}}  </p> 
                                <a src="#">Завантажити інструкцію з експлуатаціЇ</a>  
                                </div>                                                          
                            </el-row>
                        </div>
                    </el-col>                  
            </el-card>
            <el-card   class="box-card" v-if="selectedAccessories.item2.selected"> 
                    <h3>
                    {{selectedAccessories.item2.title}}
                    </h3>
                    <el-col :span="2" :offset="1"><el-button @click="onDeleteAccessories(2)" type="text"><i class="el-icon-circle-close-outline"></i></el-button> 
                    </el-col>
                    <el-col :span="20">        
                        <div class="accessories">
                        <el-col :span="6">
                        <img :src="url+'assets/cable.jpg'" width="100px" alt="">
                        </el-col>
                        <el-col :span="17" :offset="1" class="text" v-html="selectedAccessories.item2.description"></el-col>
                        <el-row>
                        <p><strong>{{selectedAccessories.item2.name}} </strong></p>
                        <p class="stronge-price">Ціна: {{selectedAccessories.item2.price}} грн з ПДВ за 1м.п</p>  
                        <p>Довжина:<strong>{{selectedAccessories.item2.length}} </strong>  м</p>
                        <div class="expand-view"></div>
                        </el-row>
                        </div> 
                    </el-col>                                                          
                </el-card>
                <el-card   class="box-card"  v-if="selectedAccessories.item3.selected"> 
                <h3>{{selectedAccessories.item3.title}}</h3>  
                    <el-col :span="2" :offset="1"><el-button @click="onDeleteAccessories(3)" type="text"><i class="el-icon-circle-close-outline"></i></el-button> </el-col>
                    <el-col :span="20">
                    <div class="accessories">
                        <el-col :span="6">
                        <img v-if="selectedAccessories.item3.type=='coupling filler'" :src="url+'assets/mufta_zal.jpg'" width="90px" alt="">
                        <img v-else-if="selectedAccessories.item3.type=='coupling thermo'" :src="url+'assets/mufta_termo.jpg'" width="90px" alt="">
                        </el-col>
                        <el-col :span="17" :offset="1" class="text"></el-col>
                        <el-row>
                            <p><strong>{{selectedAccessories.item3.name}} </strong> </p>
                            <p class="stronge-price">Ціна: {{selectedAccessories.item3.price}} грн з ПДВ </p>  
                            <p>Перетин: <strong> {{selectedAccessories.item3.section}}</strong> мм<sup>2</sup></p>
                           
                            <div class="expand-view"></div>
                        </el-row>
                    </div> 
                    </el-col>                
                </el-card> 
                <el-card   class="box-card"  v-if="selectedAccessories.item4.selected"> 
                <h3>{{selectedAccessories.item4.title}}</h3>
                    <el-col :span="2" :offset="1"><el-button @click="onDeleteAccessories(4)" type="text"><i class="el-icon-circle-close-outline"></i></el-button> </el-col>
                    <el-col :span="20">
                    <div class="accessories">
                        <el-col :span="6">
                        <img :src="url+'assets/bak.jpg'" width="100px" alt="">
                        </el-col>
                        <el-col :span="17" :offset="1" class="text"></el-col>
                        <el-row>
                            <p><strong>{{selectedAccessories.item4.name}} </strong> </p>
                            <p class="stronge-price">Ціна: {{selectedAccessories.item4.price}} грн з ПДВ </p>  
                            <p>Об'єм: <strong>{{selectedAccessories.item4.volume}} </strong> літрів </p>
                            <div class="expand-view"> </div>
                        </el-row>
                    </div> 
                    </el-col>                
                </el-card>
                <el-card   class="box-card"  v-if="selectedAccessories.item5.selected"> 
                <h3>{{selectedAccessories.item5.title}}</h3>
                    <el-col :span="2" :offset="1"><el-button @click="onDeleteAccessories(5)" type="text"><i class="el-icon-circle-close-outline"></i></el-button> </el-col>
                    <el-col :span="20">
                    <div class="accessories">
                        <el-col :span="6">
                        <img :src="url+'assets/jeckets.jpg'" width="100px" alt="">
                        </el-col>
                        <el-col :span="17" :offset="1" class="text"></el-col>
                        <el-row>
                            <p><strong>{{selectedAccessories.item5.name}} </strong> </p>
                            <p class="stronge-price">Ціна: {{selectedAccessories.item5.price}} грн з ПДВ </p>                            
                            <p>Довжена: <strong>{{selectedAccessories.item5.length}} </strong> мм </p>
                            <div class="expand-view"></div>
                        </el-row>
                    </div> 
                    </el-col>                
                </el-card>  
        </div> 
        </div>      
    </div>
    </el-row> 
</div> 
</template>

<script>
import Axios from "axios";
export default {
  props: [
    "volumeFlow",
    "deliveryHead",
    "dataChart",
    "pump",
    "allPumps",
    "selectedPumpId",
    "url",
    "selectedAccessories",
    "exchangeRates",
    "dictionary"
  ],
  data() {
    return {
      id: 1 ,
      idPump: this.selectedPumpId,
      objPump:this.pump,
      objDataChart:this.dataChart,
      refresh:false,
      selectedAccessoriesRefresh:this.selectedAccessories,
      deliveryHeadInput: this.deliveryHead,
      deliveryHeadComputed: null,
      dialogVisible: false,
      itemSelect:'',
      paramOfSelectedPump: {
        phase: "",
        current: 0,
        cosf: 0,
        U: 0,
        H2: 0
      }
    };
    },
    filters: {
    aroundNumber: function (value) {
       value = Number(value).toFixed(2)
       return value
    }
    },
  mounted: function(){
       this.onSaveSelectedAccessories()
       console.log(this.selectedAccessories)
  },
  computed: {
    objSelectedPump: function() {
      let pumpsArr = [];
      let source = this.objPump;
      for (let key in source) {
        pumpsArr.push(source[key]);
      }
      let obj = {};
      for (let key in pumpsArr) {
        if (pumpsArr[key].id == this.idPump) {
          this.onSaveSelectedPumpId(pumpsArr[key].id);
          obj.name = pumpsArr[key].pump_name;
          obj.price = (pumpsArr[key].price*this.exchangeRates).toFixed(2);
          obj.id = pumpsArr[key].id;
          obj.current = pumpsArr[key].features.current;
          obj.shortName = obj.name.split("/")[0];
          obj.n_power = pumpsArr[key].features.n_power;
          obj.cosf = pumpsArr[key].features.cosf;
          obj.phase = pumpsArr[key].features.phase;
          obj.dim_H2 = pumpsArr[key].features.dim_H2;
        }
      }
      
        this.paramOfSelectedPump=obj
        this.paramOfSelectedPump.U = obj.phase == 1 ? 230 : 400;

      return obj;
    },
    existAccessories: function() {
      if (
        this.selectedAccessoriesRefresh.item1.selected != false ||
        this.selectedAccessoriesRefresh.item2.selected != false ||
        this.selectedAccessoriesRefresh.item3.selected != false ||
        this.selectedAccessoriesRefresh.item4.selected != false ||
        this.selectedAccessoriesRefresh.item5.selected != false
      )
        return true;
    }
  },
  
  methods: {
    onDeletePump(){  
        
        this.refresh=!this.refresh
          
    },
    handleSelect(itemSelect) {
        console.log(itemSelect.id);
        this.idPump=itemSelect.id
        this.postDataGetDetail(itemSelect.id)
        this.onSaveSelectedPumpId(itemSelect.id) 
        this.onClearAccessories()       
    },              
    querySearch(queryString, cb) {
        var links = this.allPumps;
        var results = queryString ? links.filter(this.createFilter(queryString)) : links;
        cb(results);
        },
    createFilter(queryString) {
        return (link) => {
        return (link.value.toLowerCase().indexOf(queryString.toLowerCase()) === 0);
        };
        },
    onSaveSelectedPumpId(id) {
      this.$emit("onSaveSelectedPumpId", id);
    },
    onRefreshDataPump(obj) {
      this.$emit("onRefreshDataPump", obj);
    },
    onClearItemAccessories() {
        this.selectedAccessoriesRefresh.item1.selected=false 
        this.selectedAccessoriesRefresh.item2.selected=false
        this.selectedAccessoriesRefresh.item3.selected=false
        
    },
    onClearAccessories() {
      if (  this.selectedAccessoriesRefresh.item1.selected != false ||
            this.selectedAccessoriesRefresh.item2.selected != false ||
            this.selectedAccessoriesRefresh.item3.selected != false)
         {
            this.$confirm('Обрані приладдя залежні від струму будуть видалені', 'Увага', {
                confirmButtonText: 'Згода',
                cancelButtonText: 'Cancel',
                type: 'warning'
                }).then(() => {
                this.$message({
                    type: 'info',
                    message: 'Обрані приладдя вилучені'
                });
                this.onClearItemAccessories()
                }).catch(() => {
                this.$message({
                    type: 'info',
                    message: 'Обрані приладдя залишились'
                });
                        
                });          
      }  
    },
    handleChangePhase(id) { 
      this.onSaveSelectedPumpId(id)
      this.onClearAccessories()
   
    },
    onSelectController(id, dataControlBox) {
      this.selectedAccessoriesRefresh.item1.idController = id;
      this.selectedAccessoriesRefresh.item1.name = dataControlBox[0].name;
      this.selectedAccessoriesRefresh.item1.price = (dataControlBox[0].price*this.exchangeRates).toFixed(2);
      this.selectedAccessoriesRefresh.item1.current_max = dataControlBox[0].features.current_max;
      this.selectedAccessoriesRefresh.item1.description = dataControlBox[0].features.description;
      this.selectedAccessoriesRefresh.item1.dim = dataControlBox[0].features.dim;
      this.selectedAccessoriesRefresh.item1.selected = true;
      this.onSaveSelectedAccessories()
    },
    onSelectCable(cable, id) {
      this.selectedAccessoriesRefresh.item2.idCable = id;
      this.selectedAccessoriesRefresh.item2.name = cable.name;
      this.selectedAccessoriesRefresh.item2.price = (cable.price*this.exchangeRates).toFixed(2);
      this.selectedAccessoriesRefresh.item2.length = cable.length;
      this.selectedAccessoriesRefresh.item2.selected = true;
      this.onSaveSelectedAccessories()
    },
    onSelectMufta(id, mufta) {
      this.selectedAccessoriesRefresh.item3.idMufta = id;
      this.selectedAccessoriesRefresh.item3.name = mufta[0].name;
      this.selectedAccessoriesRefresh.item3.price = (mufta[0].price*this.exchangeRates).toFixed(2);
      this.selectedAccessoriesRefresh.item3.type = mufta[0].features.type;
      this.selectedAccessoriesRefresh.item3.section = mufta[0].features.section;
      this.selectedAccessoriesRefresh.item3.selected = true;
      this.onSaveSelectedAccessories()
    },
    onSelectVessel(id, vessel) {
      this.selectedAccessoriesRefresh.item4.idVessel = id;
      this.selectedAccessoriesRefresh.item4.volume = vessel.features.volume;
      this.selectedAccessoriesRefresh.item4.name = vessel.name;
      this.selectedAccessoriesRefresh.item4.price = (vessel.price*this.exchangeRates).toFixed(2);
      this.selectedAccessoriesRefresh.item4.selected = true;
      this.onSaveSelectedAccessories()
    },
    onSelectJecket(id, jecket) {
      this.selectedAccessoriesRefresh.item5.idJecket = id;
      this.selectedAccessoriesRefresh.item5.length = jecket.features.length;
      this.selectedAccessoriesRefresh.item5.name = jecket.name;
      this.selectedAccessoriesRefresh.item5.price = (jecket.price*this.exchangeRates).toFixed(2);
      this.selectedAccessoriesRefresh.item5.selected = true;
      this.onSaveSelectedAccessories()
    },
    onSaveSelectedAccessories(){
      let obj=this.selectedAccessoriesRefresh
      this.$emit("onSaveSelectedAccessories", obj);
    },
    onDialogAccept() {
      this.dialogVisible = false;
    },
    onDeleteAccessories(id) {
      this.selectedAccessoriesRefresh['item'+id].selected = false;
    },
    postDataGetDetail: function(id) {
                const getPromise = Axios.post(this.url+'db/getDetails', {"id":id});
                getPromise.then(response => {
                    this.objPump = response.data;
                    if (this.objPump!=undefined) {
                    console.log(this.objPump)  
                     this.onRefreshDataPump(this.objPump)
                     this.$emit("onGetDataChart", this.objPump);  
                     this.id ++    
                                    
                }
                else {
                    this.refreshDataSearch=false 
                }
                // 
                });
    },
    open() {
      this.$alert("This is a message", "Title", {
        confirmButtonText: "OK",
        callback: action => {
          this.$message({
            type: "info",
            message: `action: ${action}`
          });
        }
      });
    }
  }
};
</script>

<style scoped>
.greyBox {
  text-align: left;
  min-height: 100px;
}
.greyBox p {
  margin: 5px;
}
.radio-item-phasa {
    display: inline-block;
    margin: 12px 0;
    padding-right: 10px;
}
.accessories img {
    padding-bottom: 30px
}
.item-selected {
    text-align: left;
}
.item-selected i {
    font-size: 20px;
}
.item-selected .expand-view {
    display: none
} 
.el-card.box-card.is-always-shadow {
    margin-bottom: 5px;
}
.sub-title {
    font-weight: 600
}
p.sub-title.price {
    margin: 15px 5px;
    font-size: 19px;
    color: #009c81;
}
span.sub-title.point {
    min-height: 40px;
    padding: 5px 0;
    display: block;
    margin-top: 0;
    border-bottom: solid 1px #c4c0c0;
}
</style>

