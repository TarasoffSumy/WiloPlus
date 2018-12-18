<template>
<div>

    <el-dialog
    title=""
    :visible.sync="dialogVisible"
    width="80%"
    >
    <Step3-helper 
        :url="url"
        :selectedPumpCurrent="selectedPumpCurrent"
        @onSelectController="onSelectController"
                /> 
    <span slot="footer" class="dialog-footer">       
        <el-row class="navigation-footer">
        <el-col :span="12">
            <el-button @click="dialogCancel"  icon="el-icon-d-arrow-left">Назад</el-button>
        </el-col>
        <el-col :span="12">
            <el-button :disabled="disabledAccept" type="primary" @click="onDialogAccept">Підтвердити <i class="el-icon-d-arrow-right el-icon-right"/></el-button>
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
        <el-col :span="12">
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
                <Chart  />       
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
        <Step3-accessoreis 
            :url="url"
            :selectedControllerId="selectedControllerId"
        /> 
</div> 
</template>

<script>
import Axios from 'axios';
  export default {
    props: ['volumeFlow', 'deliveryHead','modelHeadItems', 'url'],
    data() {
      return {
        deliveryHeadInput: this.deliveryHead,
        deliveryHeadComputed: null,
        helperStep1: false,
        dialogVisible: false,
        minDeliveryHead: 20,
        maxDeliveryHead: 200,
        disabledAccept: true,
        pump:'',
        selectedPumpId: '',
        selectedPumpCurrent: '',
        selectedControllerId: ''
      };
    },
    created: function() {
        this.postDataPump(this.volumeFlow, this.deliveryHead);
        
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
                console.log(this.selectedPumpCurrent +'step3')
               
             return obj            
            }           
        },
    methods: {
    onSelectController(val){
        this.selectedControllerId=val
        console.log('emit'+val)
        },
    OnGetFirstSelectedId(){
                let pumpsArr=[]
                let source=this.pump
                for (let key in source){
                        pumpsArr.push(source[key].id)
                }
                this.selectedPumpId= pumpsArr[0]
            }, 
    postDataPump: function(volumeFlow, deliveryHead) {
                const getPromise = Axios.post('http://www.wiloexpert.com.ua/wilo/db/pumpSelect', {'volumeFlow': volumeFlow, 'deliveryHead': deliveryHead});
                getPromise.then(response => {
                this.pump = response.data;
                 console.log(this.pump );
                this.OnGetFirstSelectedId()
                })
                .catch(error => {
                    console.log(error);
                });
                },
    dialogCancel() {
        this.dialogVisible=false 
    },
    onDialogAccept() {
        this.onSaveComputedHead()
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

