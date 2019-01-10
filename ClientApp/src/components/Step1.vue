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
                 <p>Витрата  <el-input-number v-model="volumeFlowInput" @change="onInputVolumeFlow"></el-input-number>
                 м<sup>3</sup>/ч
                 </p>
                 <p class="alert"><i type="info" class="el-icon-info"></i>
                  Визначена витрата повинна бути меншою ніж <el-tooltip placement="top">
                  <div class="tolltip" slot="content">multiple lines<br/>second line</div> 
                  <el-button type="text">дебіт свердловини</el-button>
                 </el-tooltip>,
                  як мінімум на 0,5м3/год. 
                  В іншому випадку введіть витрату насосу рівною дебіту свердловину зменшеному на 0,5 м3/год
                 
                 </p>
            </div>
            <div class="greyBox last-box">
                 <font-awesome-icon icon="lightbulb" />
                 <p style="text-align:left">Якщо необхідно розрахувати витрату, скористайтесь послугами нашого помічника</p>
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
    props: ['volumeFlow', 'maxVolumeFlow', "modelFlowItems", "url"],
    data() {
      return {
        volumeFlowInput: this.volumeFlow,
        volumeFlowComputed: null,
        helperStep1: false,
        dialogVisible: false,
        disabledAccept: true,
        dictionary:''
      };
    },
    validations: {
        volumeFlowInput: {
        required,
        between: between(0.5, 17)
        }
    },
    created (){
        // this.postData(1)
    },
    methods: {
      dialogCancel() {
        this.dialogVisible=false 
      },
      onInputVolumeFlow(value) {
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
        this.postData(1)
        console.log(this.dictionary)

        this.$alert(this.dictionary.full_text, this.dictionary.short_text, {
          dangerouslyUseHTMLString: true,
          confirmButtonText: 'OK',
        });
      }
      }
    }
</script>

<style scoped>

button.el-button.el-button--text {
    text-decoration: underline;
    font-size: 15.5px;
    color: #50b9f0;
    padding: 0;
}
.tolltip {
    font-size: 14px
}
</style>

