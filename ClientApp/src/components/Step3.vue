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
            @onSelectController="onSelectController"
            @onSelectCable="onSelectCable"
            @onSelectMufta="onSelectMufta"
            @onSelectVessel="onSelectVessel"
            @onSelectJecket="onSelectJecket"
            /> 
        <span slot="footer" class="dialog-footer">       
            <el-row class="navigation-footer">
            <!-- <el-col :span="12">
                <el-button @click="dialogCancel"  icon="el-icon-d-arrow-left">Назад</el-button>
            </el-col> -->
            <el-col :span="12">
                <el-button type="primary" @click="onDialogAccept">Закрити<i class="el-icon-d-arrow-right el-icon-right"/></el-button>
            </el-col>
            </el-row>   
        </span>
    </el-dialog>

    <el-row>
        <div class="circle_numder">
            <svg height="55" width="53" class="circle">
            <circle cx="26" cy="26" r="24" stroke="" stroke-width="2" fill="" />
            </svg> <span>3 </span>            
        </div>
        <h2 class="title">Підбір насоса та приладдя </h2>
    </el-row>
    <el-row>
        <el-col :span="12" >
            <div class="greyBox" v-if="idPump">
                <el-col  :span="8" >
                  <img width="150" :src="url+'assets/wilo-skvaginniy-nasos-actun-first-spu4.jpg'"/>   
                </el-col>
                <el-col  :span="16" >
                    <h3>Підбраний насос </h3>
                    <p>ACTUN {{objSelectedPump.shortName}}</p>                
                            <div v-for="item in pump" :value="item" :key="item.id" class="radio-item-phasa" >
                                <el-radio v-model="idPump" :label="item.id" @change="handleChange(item.id)">
                                                <span v-if="item.features.phase=='1'">однофазный</span>
                                                <span v-if="item.features.phase=='3'">трехфазный</span>
                                </el-radio>       
                            </div>
                            <p>Насосний агрегат:</p> 
                            <p>{{objSelectedPump.name}}</p>
                            <p>Ціна {{objSelectedPump.price}} грн. з ПДВ</p>
                </el-col>        
                    <p>Конструкція</p>
                    <p>Багатоступеневий насос 4" із занурюваним двигуном, виконання з кожухом, для вертикальної або горизонтальної установки</p>
                    <p>Потужність двигуна: {{objSelectedPump.n_power}} kW </p>
                    <p>Номінальний струм: {{objSelectedPump.current}} A </p>
                    <div>
                        Робоча точка отримана від користувача:
                        <p>Витрата: {{volumeFlow}} м<sup>3</sup>/ч </p> 
                        <p>Напір: {{deliveryHead}} м</p>                           
                    </div>
                    <div>
                        Робоча точка фактична:
                        <p>Витрата: {{dataChart.CalcPoint[0].x}} м<sup>3</sup>/ч </p> 
                        <p>Напір: {{dataChart.CalcPoint[0].y}} м</p>                           
                    </div>
                    <div id="print" style="margin-left:45px;position: relative; width:300px">
                    <Chart  :dataChart="dataChart"   />   
                    </div>                    
            </div>
            <div v-else class="greyBox">
                Насос не знайден!
                Скорегуйте напор та витрату
            </div>
        </el-col>
        <el-col :span="12">
                 <div class="greyBox">
                 <font-awesome-icon icon="lightbulb" />
                 <p style="text-align:left">Підібрати приладдя до насосу</p>
                 <div class="container-button">
                 <el-button type="primary" @click="dialogVisible = true">Підібрати</el-button>                                     
                 </div>
             </div>
        <div  v-if="existAccessories" class="item-selected">
            <h2>Підібране приладдя</h2>
                <el-row  v-if="selectedAccessories.item1.selected"> 
                <h3>{{selectedAccessories.item1.title}}</h3>
                    <el-col :span="2" :offset="1"><el-button @click="onDeleteController()" type="text"><i class="el-icon-circle-close-outline"></i></el-button> </el-col>
                    <el-col :span="20">
                        <div class="accessories">
                            <el-col :span="5">
                                <img :src="url+'assets/controller.jpg'" width="100px" alt="">
                            </el-col>
                            <el-col :span="17" :offset="2" class="text"></el-col>
                            <el-row>
                            <strong>{{selectedAccessories.item1.name}} </strong>
                                <p><strong>Ціна: {{selectedAccessories.item1.price}} грн з ПДВ </strong></p>  
                                <p><strong>Ток максимальний:</strong> {{selectedAccessories.item1.current_max}} A </p>
                                <p><strong>Розміри:</strong> {{selectedAccessories.item1.dim}}  </p>
                                <div class="expand-view">
                                <p><strong>Тип пуску насоса:</strong> {{selectedAccessories.item1.start}}  </p> 
                                <p><strong>Управління:</strong> {{selectedAccessories.item1.operation}}  </p>                       
                                <p><strong>Захист від сухого ходу:</strong> {{selectedAccessories.item1.dry_running}}  </p> 
                                <a src="#">Завантажити інструкцію з експлуатаціЇ</a>  
                                </div>                                                          
                            </el-row>
                        </div>
                    </el-col>                   
                </el-row> 
                <el-row v-if="selectedAccessories.item2.selected"> 
                    <h3>
                    {{selectedAccessories.item2.title}}
                    </h3>
                    <el-col :span="2" :offset="1"><el-button @click="onDeleteCable()" type="text"><i class="el-icon-circle-close-outline"></i></el-button> 
                    </el-col>
                    <el-col :span="20">        
                        <div class="accessories">
                        <el-col :span="5">
                        <img :src="url+'assets/cable.jpg'" width="100px" alt="">
                        </el-col>
                        <el-col :span="17" :offset="2" class="text" v-html="selectedAccessories.item2.description"></el-col>
                        <el-row>
                        <p><strong>Ціна: {{selectedAccessories.item2.price}} грн з ПДВ </strong></p>  
                        <p><strong>{{selectedAccessories.item2.name}} </strong> </p>
                        <div class="expand-view"></div>
                        </el-row>
                        </div> 
                    </el-col>                                                          
                </el-row>
                <el-row v-if="selectedAccessories.item3.selected"> 
                <h3>{{selectedAccessories.item3.title}}</h3>  
                    <el-col :span="2" :offset="1"><el-button @click="onDeleteMufta()" type="text"><i class="el-icon-circle-close-outline"></i></el-button> </el-col>
                    <el-col :span="20">
                    <div class="accessories">
                        <el-col :span="5">
                        <img :src="url+'assets/mufta.jpg'" width="100px" alt="">
                        </el-col>
                        <el-col :span="17" :offset="2" class="text"></el-col>
                        <el-row>
                            <p><strong>Ціна: {{selectedAccessories.item3.price}} грн з ПДВ </strong></p>  
                            <p><strong>{{selectedAccessories.item3.name}} </strong> </p>
                            <div class="expand-view"></div>
                        </el-row>
                    </div> 
                    </el-col>                
                </el-row> 
                <el-row v-if="selectedAccessories.item4.selected"> 
                <h3>{{selectedAccessories.item4.title}}</h3>
                    <el-col :span="2" :offset="1"><el-button @click="onDeleteVessel()" type="text"><i class="el-icon-circle-close-outline"></i></el-button> </el-col>
                    <el-col :span="20">
                    <div class="accessories">
                        <el-col :span="5">
                        <img :src="url+'assets/bak.jpg'" width="100px" alt="">
                        </el-col>
                        <el-col :span="17" :offset="2" class="text"></el-col>
                        <el-row>
                            <p>Ціна:<strong> {{selectedAccessories.item4.price}} </strong>грн з ПДВ </p>  
                            <p><strong>{{selectedAccessories.item4.name}} </strong> </p>
                            <p>Об'єм: <strong>{{selectedAccessories.item4.volume}} </strong> літрів </p>
                            <div class="expand-view"> </div>
                        </el-row>
                    </div> 
                    </el-col>                
                </el-row>
                <el-row v-if="selectedAccessories.item5.selected"> 
                <h3>{{selectedAccessories.item5.title}}</h3>
                    <el-col :span="2" :offset="1"><el-button @click="onDeleteJecket()" type="text"><i class="el-icon-circle-close-outline"></i></el-button> </el-col>
                    <el-col :span="20">
                    <div class="accessories">
                        <el-col :span="5">
                        <img :src="url+'assets/jeckets.jpg'" width="100px" alt="">
                        </el-col>
                        <el-col :span="17" :offset="2" class="text"></el-col>
                        <el-row>
                            <p>Ціна:<strong> {{selectedAccessories.item5.price}} </strong>грн з ПДВ </p>  
                            <p><strong>{{selectedAccessories.item5.name}} </strong> </p>
                            <p>Длина: <strong>{{selectedAccessories.item5.length}} </strong> мм </p>
                            <div class="expand-view"></div>
                        </el-row>
                    </div> 
                    </el-col>                
                </el-row>  
        </div>       
        </el-col>
    </el-row> 
</div> 
</template>

<script>
import Axios from "axios";
export default {
  props: [
    "volumeFlow",
    "deliveryHead",
    "modelHeadItems",
    "dataChart",
    "pump",
    "selectedPumpId",
    "url"
  ],
  data() {
    return {
      idPump: this.selectedPumpId,
      pumpStep3: this.pump,
      deliveryHeadInput: this.deliveryHead,
      deliveryHeadComputed: null,
      helperStep1: false,
      dialogVisible: false,
      minDeliveryHead: 20,
      maxDeliveryHead: 200,
      disabledAccept: true,
      paramOfSelectedPump: {
        phase: "",
        current: 0,
        cosf: 0,
        U: 0,
        H2: 0
      },
      selectedAccessories: {
        item1: {
          id: 1,
          title: "Прилад керування і захисту насоса",
          name: "",
          img: "assets/controller.jpg",
          price: "",
          current_max: "",
          dim: "",
          description: "",
          selected: false,
          idController: undefined
        },
        item2: {
          id: 2,
          title: "Кабель",
          name: "",
          img: "assets/cable.jpg",
          price: "",
          selected: false,
          idCable: undefined
        },
        item3: {
          id: 3,
          title: "З’єднання насоса",
          name: "",
          img: "assets/mufta.jpg",
          price: "",
          selected: false,
          idMufta: undefined
        },
        item4: {
          id: 4,
          title: "Мембранний напірний бак",
          name: "",
          volume: "",
          img: "assets/bak.jpg",
          price: "",
          selected: false,
          idVessel: undefined
        },
        item5: {
          id: 5,
          title: "Кожух",
          name: "",
          length: "",
          img: "assets/jeckets.jpg",
          price: "",
          selected: false,
          idJecket: undefined
        }
      }
    };
  },
  created: function() {
    console.log(this.pump);
  },
  computed: {
    objSelectedPump: function() {
      let pumpsArr = [];
      let source = this.pumpStep3;
      for (let key in source) {
        pumpsArr.push(source[key]);
      }
      let obj = {};
      for (let key in pumpsArr) {
        if (pumpsArr[key].id == this.idPump) {
          this.onSaveSelectedPumpId(pumpsArr[key].id);
          obj.name = pumpsArr[key].pump_name;
          obj.price = pumpsArr[key].price;
          obj.current = pumpsArr[key].features.current;
          obj.shortName = obj.name.split("/")[0];
          obj.n_power = pumpsArr[key].features.n_power;
          obj.cosf = pumpsArr[key].features.cosf;
          obj.phase = pumpsArr[key].features.phase;
          obj.dim_H2 = pumpsArr[key].features.dim_H2;
        }
      }
      this.paramOfSelectedPump.phase = obj.phase;
      this.paramOfSelectedPump.current = obj.current;
      this.paramOfSelectedPump.cosf = obj.cosf;
      this.paramOfSelectedPump.U = obj.phase == 1 ? 230 : 400;
      this.paramOfSelectedPump.dim_H2 = obj.dim_H2;
      return obj;
    },
    existAccessories: function() {
      console.log("exist" + this.selectedAccessories.item5.idJecket);
      if (
        this.selectedAccessories.item1.idController != undefined ||
        this.selectedAccessories.item2.idMufta != undefined ||
        this.selectedAccessories.item3.idCable != undefined ||
        this.selectedAccessories.item4.idVessel != undefined ||
        this.selectedAccessories.item5.idJecket != undefined
      )
        return true;
    }
  },
  methods: {
    onSaveSelectedPumpId(id) {
      this.$emit("onSaveSelectedPumpId", id);
    },
    handleChange(id) {
      this.onSaveSelectedPumpId(id);
    },
    onSelectController(val, dataControlBox) {
      this.selectedAccessories.item1.idController = val;
      this.selectedAccessories.item1.name = dataControlBox[0].name;
      this.selectedAccessories.item1.price = dataControlBox[0].price;
      this.selectedAccessories.item1.current_max =
        dataControlBox[0].features.current_max;
      this.selectedAccessories.item1.description =
        dataControlBox[0].features.description;
      this.selectedAccessories.item1.dim = dataControlBox[0].features.dim;
      this.selectedAccessories.item1.selected = true;
    },
    onSelectCable(cable, id) {
      this.selectedAccessories.item2.idCable = id;
      this.selectedAccessories.item2.name = cable.name;
      this.selectedAccessories.item2.price = cable.price;
      this.selectedAccessories.item2.selected = true;
    },
    onSelectMufta(id, mufta) {
      this.selectedAccessories.item3.idMufta = id;
      this.selectedAccessories.item3.name = mufta[0].name;
      this.selectedAccessories.item3.price = mufta[0].price;
      this.selectedAccessories.item3.selected = true;
    },
    onSelectVessel(id, vessel) {
      this.selectedAccessories.item4.idVessel = id;
      this.selectedAccessories.item4.volume = vessel.features.volume;
      this.selectedAccessories.item4.name = vessel.name;
      this.selectedAccessories.item4.price = vessel.price;
      this.selectedAccessories.item4.selected = true;
    },
    onSelectJecket(id, jecket) {
      this.selectedAccessories.item5.idJecket = id;
      this.selectedAccessories.item5.length = jecket.features.length;
      this.selectedAccessories.item5.name = jecket.name;
      this.selectedAccessories.item5.price = jecket.price;
      this.selectedAccessories.item5.selected = true;
    },
    onGetDataController(val) {},
    dialogCancel() {
      this.dialogVisible = false;
    },
    onDialogAccept() {
      this.dialogVisible = false;
    },
    onDeleteController() {
      this.selectedAccessories.item1.selected = false;
    },
    onDeleteCable() {
      this.selectedAccessories.item2.selected = false;
    },
    onDeleteMufta() {
      this.selectedAccessories.item3.selected = false;
    },
    onDeleteVessel() {
      this.selectedAccessories.item4.selected = false;
    },
    onDeleteJecket() {
      this.selectedAccessories.item5.selected = false;
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
  margin-right: 15px;
}
</style>

