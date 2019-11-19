<template>
<div>   
    <el-dialog
    title=""
    :visible.sync="dialogVisible"
    width="80%"
    >
    <Step1-helper 
                @onComputeVolumeFlow="onComputeVolumeFlow"
                @onInputFlowItems="onInputFlowItems" 
                :dictionary="dictionary"
                :modelFlowItems="modelFlowItems"
                :url="url"
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
    <div class="circle_number">
        <svg height="55" width="53" class="circle">
        <circle cx="26" cy="26" r="24" stroke="" stroke-width="2" fill="" />
        </svg> <span>1 </span>            
    </div>
    <h2 class="title">Витрата насоса</h2> 
    </el-row> 
    <el-row>
    <div class="greyBoxes-container">
            <div class="greyBox">
                 <!-- :precision="2" :min="0.5" :max="17" -->
                 <h3>Необхідна витрата насоса</h3>       
                 <p>Витрата  <el-input-number v-model="(volumeFlowInput)" :precision="2" @change="onInputVolumeFlow"></el-input-number>
                 м<sup>3</sup>/год
                 </p>
                 <p class="alert"><i type="info" class="el-icon-info"></i>
                 Витрата насоса повинна бути меншою за <el-popover
                    placement="top-start"
                    :title=dictionary[0].short_text
                    width="200"
                    trigger="hover"
                    :content=dictionary[0].full_text>
                    <el-button type="text"  slot="reference"><span class="myTip">продуктивність свердловини</span></el-button>
                  </el-popover>                 
                 </p>
            </div>
            <div class="greyBox last-box">
                 <font-awesome-icon icon="lightbulb" />
                 <p style="text-align:left">Невідома витрата? Скористайтесь послугами нашого помічника</p>
                 <div class="container-button"> 
                 <el-button class="calc-btn" type="primary" @click="dialogVisible = true"><img  width="20" :src="url+'assets/calc.png'">Розрахувати</el-button>                                     
                 </div>
            </div>
    </div>
    </el-row>        
</div>        
</template>

<script>
import Axios from 'axios';
import { required, minLength, between } from 'vuelidate/lib/validators';
  export default {
    props: ['volumeFlow', 'maxVolumeFlow', "modelFlowItems", "url", "dictionary"],
    data() {
      return {
        dic: this.dictionary.id1,
        volumeFlowInput: this.volumeFlow,
        volumeFlowComputed: null,
        helperStep1: false,
        dialogVisible: false,
        disabledAccept: true        
      };
    },
    validations: {
        volumeFlowInput: {
        required,
        between: between(0.5, 17)
        }
    },
    mounted() {
      console.log(this.dictionary)
    },
    created (){
        // this.postData(1)
        
         
    },
    methods: {
      dialogCancel() {
        this.dialogVisible=false 
      },
      onInputVolumeFlow(value) {
        // alert(String(value))
        this.$emit('onInputDataVolume', value)
         console.log(value)
      },
      onInputFlowItems(id, val){
        this.$emit('onInputFlowItems', id, val )
      },
      onSaveComputedValue(){
        this.$emit('onInputDataVolume', this.volumeFlowComputed)
        this.volumeFlowInput=this.volumeFlowComputed          
      },
      onDialogAccept() {
        this.onSaveComputedValue()
        this.dialogVisible=false       
      },
      onComputeVolumeFlow(value){          
          this.volumeFlowComputed=value
          this.onDisableButtonAccept()
      },
      onDisableButtonAccept(){
          if (this.volumeFlowComputed <= this.maxVolumeFlow) {
            this.disabledAccept=false      
          }
          else {
            this.disabledAccept=true 
          }
      },      
      open() {

      }
      }
    }
</script>

<style scoped>


.tolltip {
    font-size: 14px
}
</style>

