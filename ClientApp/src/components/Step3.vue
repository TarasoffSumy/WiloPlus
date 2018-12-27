<template>
<div>
    <el-dialog
        title=""
        :visible.sync="dialogVisible"
        width="80%">
        <Step3-helper 
            :url="url"
            :paramOfSelectedPump="paramOfSelectedPump"
            :selectedAccessories="selectedAccessories"
            @onSelectController="onSelectController"
            /> 
        <span slot="footer" class="dialog-footer">       
            <el-row class="navigation-footer">
            <el-col :span="12">
                <el-button @click="dialogCancel"  icon="el-icon-d-arrow-left">Назад</el-button>
            </el-col>
            <el-col :span="12">
                <el-button type="primary" @click="onDialogAccept">Підтвердити <i class="el-icon-d-arrow-right el-icon-right"/></el-button>
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
            <div>
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
                
                        <p>
                            Потужність двигуна: {{objSelectedPump.n_power}} kW
                        </p>
                        <p>
                            Номінальний струм: {{objSelectedPump.current}} A
                        </p>
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
                        <p> 
                        
                        </p>
                        <p>
                        
                        </p>
                        <div id="print" style="margin-left:45px;position: relative; width:300px">
                            <Chart 
                                :dataChart="dataChart" 
                            />   
                        </div>
                    
            </div>
            <div v-else class="greyBox">
                Насос не знайден!
                Скорегуйте напор та витрату
            </div>

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
        <Step3-accessoreis v-if="existAccessories"
            :url="url"
            :selectedAccessories="selectedAccessories.item1"
             @onSelectController="onSelectController"
        />              
        </el-col>
    </el-row> 

</div> 
</template>

<script>
import Axios from 'axios';
  export default {
    props: ['volumeFlow', 'deliveryHead','modelHeadItems', 'url',"dataChart", 'pump', 'selectedPumpId', 'url'],
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
            phase:'',
            current: '',
            cosf:'',
            U:'',            
        },
        selectedAccessories: {
            item1: {
                id:1,
                title: 'Прилад керування і захисту насоса',
                name:'',
                img:'assets/controller.jpg',
                price: '45',
                selected:false,
                idController: this.selectedControllerId,
                features: {
                    current_max: "",
                    dim:''                    
                }
            },
            item2: {
                id:2,
                title: 'Кабель',
                img:'assets/cable.jpg',
                price: '2500 грн',
                selected:false,
                idController: "this.selectedControllerId"
            },
            item3: {
                id:3,
                title: 'З’єднання насоса',
                img:'assets/mufta.jpg',
                price: '2500 грн',
                selected:false,
                idController: "this.selectedControllerId"
            },
            item4: {
                id:4,
                title: 'Мембранний напірний бак',
                img:'assets/bak.jpg',
                price: '2500 грн',
                selected:false,
                idController: "this.selectedControllerId"
            }
        },
        }
    },
    created: function() {
        
    },
    computed: {
        objSelectedPump: function() {
                let pumpsArr=[]
                let source=this.pumpStep3
                for (let key in source){
                        pumpsArr.push(source[key])                
                }
                let obj={}
                for (let key in pumpsArr){
                    if (pumpsArr[key].id==this.idPump) {
                        this.onSaveSelectedPumpId(pumpsArr[key].id)
                        obj.name=pumpsArr[key].pump_name
                        obj.price=pumpsArr[key].price
                        obj.current=pumpsArr[key].features.current
                        obj.shortName=obj.name.split('/')[0]
                        obj.n_power=pumpsArr[key].features.n_power
                        obj.cosf=pumpsArr[key].features.cosf
                        obj.phase=pumpsArr[key].features.phase
                        
                    }
                }
                this.paramOfSelectedPump.phase=obj.phase
                this.paramOfSelectedPump.current=obj.current 
                this.paramOfSelectedPump.cosf=obj.cosf
                this.paramOfSelectedPump.U=(obj.phase==1 ? 230 : 400)
             return obj            
        },
        existAccessories: function() {
            console.log("exist"+this.selectedAccessories.item1.idController)
            if ( this.selectedAccessories.item1.idController!=undefined)
            return true
        }                   
        },
    methods: {
    onSaveSelectedPumpId(id){
        this.$emit('onSaveSelectedPumpId', id)       
      },
    handleChange(id){
        this.onSaveSelectedPumpId(id)
    },
    onSelectController(val, dataControlBox){
        console.log(dataControlBox)
        this.selectedAccessories.item1.idController=val
        this.selectedAccessories.item1.name=dataControlBox[0].name
        this.selectedAccessories.item1.price=dataControlBox[0].price
        this.selectedAccessories.item1.features.current_max=dataControlBox[0].features.current_max
        this.selectedAccessories.item1.features.dim=dataControlBox[0].features.dim
        this.selectedAccessories.item1.selected=true
    },
    onGetDataController(val) {

    },
    dialogCancel() {
        this.dialogVisible=false 
    },
    onDialogAccept() {
        this.dialogVisible=false       
    },        
    open() {
        this.$alert('This is a message', 'Title', {
          confirmButtonText: 'OK',
          callback: action => {
            this.$message({
              type: 'info',
              message: `action: ${ action }`
            });
          }
        });
      }
      }
    }
</script>

<style scoped>
.greyBox {
    text-align: left;
    min-height: 100px
}
.greyBox p {
    margin: 5px;
}
.radio-item-phasa {
    display: inline-block;
    margin-right: 15px;
}

</style>

