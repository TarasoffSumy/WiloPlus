<template>
<div>
    <el-dialog
        title=""
        :visible.sync="dialogVisible"
        width="80%">
        <Step3-helper 
            :url="url"
            :selectedPumpCurrent="selectedPumpCurrent"
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
            <div class="greyBox">
            <h3>Підбраний насос</h3>
            {{selectedPumpCurrent}}
            <div v-if="selectedPumpId">
                <img width="150" src="https://mediadatabase.wilo.com/marsWilo/scr/cache/4831334v3tv3/WILO112831-actun-spu-4-pic-01-1710.jpg"/>
                <p>{{objSelectedPump.shortName}}</p>
                {{objSelectedPump.current}}
                    <div v-for="item in pump" :value="item" :key="item.id" >
                        <el-radio v-model="selectedPumpId" :label="item.id">
                                        <span v-if="item.features.phase=='1'">однофазный</span>
                                        <span v-if="item.features.phase=='3'">трехфазный</span>
                        </el-radio>       
                    </div>
                    <p>Напор {{deliveryHead}} м</p>
                    <p>Расход {{volumeFlow}} м<sup>3</sup>/ч </p>
                    <p> 
                    Цена {{objSelectedPump.price}} грн 
                    </p>
                    <p>
                    {{objSelectedPump.name}}
                    </p>
                    <div id="print" style="margin-left:45px;position: relative; width:300px">
                        <Chart 
                            :Hnas="Hnas"
                            :WorkPoint="WorkPoint"
                            :CalcPoint="CalcPoint"  
                            :Hsis="Hsis"   
                        />   
                    </div>
     
            </div>
            <div v-else>
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
        </el-col>
    </el-row> 
        <Step3-accessoreis v-if="existAccessories"
            :url="url"
            :selectedAccessories="selectedAccessories.item1"
             @onSelectController="onSelectController"
        /> 
</div> 
</template>

<script>
import Axios from 'axios';
  export default {
    props: ['volumeFlow', 'deliveryHead','modelHeadItems', 'url',"Hnas", "WorkPoint", "CalcPoint", "Hsis", "selectedPumpId", 'pump'],
    data() {
      return {
        deliveryHeadInput: this.deliveryHead,
        deliveryHeadComputed: null,
        helperStep1: false,
        dialogVisible: false,
        minDeliveryHead: 20,
        maxDeliveryHead: 200,
        disabledAccept: true,
        selectedPumpCurrent: '',
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
                current_min: "",
                current_max: "'"                    
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
        // this.postDataPump(this.volumeFlow, this.deliveryHead);
        console.log("exist"+this.selectedAccessories.item1.idController)
        
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
                        obj.current=pumpsArr[key].features.current
                        obj.shortName=obj.name.split('/')[0]
                    }
                }
                this.selectedPumpCurrent=obj.current               
             return obj            
        },
        existAccessories: function() {
            console.log("exist"+this.selectedAccessories.item1.idController)
            if ( this.selectedAccessories.item1.idController!=undefined)
            return true
        }                   
        },
    methods: {
    onSelectController(val, dataControlBox){
        console.log(dataControlBox)
        this.selectedAccessories.item1.idController=val
        this.selectedAccessories.item1.name=dataControlBox[0].name
        this.selectedAccessories.item1.price=dataControlBox[0].price
        this.selectedAccessories.item1.features.current_min=dataControlBox[0].features.current_min
        this.selectedAccessories.item1.features.current_max=dataControlBox[0].features.current_max
        this.selectedAccessories.item1.selected=true
    },
    onGetDataController(val) {

    },
    // OnGetFirstSelectedId(){
    //             let pumpsArr=[]
    //             let source=this.pump
    //             for (let key in source){
    //                     pumpsArr.push(source[key].id)
    //             }
    //             this.selectedPumpId= pumpsArr[0]
    //         }, 
    // postDataPump: function(volumeFlow, deliveryHead) {
    //             const getPromise = Axios.post('http://www.wiloexpert.com.ua/wilo/db/pumpSelect', {'volumeFlow': volumeFlow, 'deliveryHead': deliveryHead});
    //             getPromise.then(response => {
    //             this.pump = response.data;
    //              console.log(this.pump );
    //             this.OnGetFirstSelectedId()
    //             })
    //             .catch(error => {
    //             });
    //             },
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

</style>

