<template>
<div>
    <el-dialog
    title=""
    :visible.sync="dialogVisible"
    width="80%"
    >
    <Step2-helper @onComputeDeliveryHead="onComputeDeliveryHead"
                  @onInputHeadItems="onInputHeadItems" 
                  :modelHeadItems="modelHeadItems"
                  :dictionary="dictionary"
                  :url="url"
    /> 
    <span slot="footer" class="dialog-footer">       
        <el-row class="navigation-footer">
        <el-col :span="12">
            <el-button @click="dialogVisible = false">Назад</el-button>
        </el-col>
        <el-col :span="12">
            <el-button :disabled="disabledAccept" type="primary" @click="onDialogAccept">Підтвердити</el-button>
        </el-col>
        </el-row>   
    </span>
    </el-dialog>

    <el-row>
    <div class="circle_number">
        <svg height="55" width="53" class="circle">
        <circle cx="26" cy="26" r="24" stroke="" stroke-width="2" fill="" />
        </svg> <span>2 </span>            
    </div>
    <h2 class="title">Напір насоса</h2> 
    </el-row> 
    <el-row>
    <div class="greyBoxes-container">
             <div class="greyBox">
                 <h3>Необхідний напір насоса</h3>                
                 <p>Напір 
                     <el-input-number v-model="deliveryHeadInput" @change="onInputDeliveryHead" :precision="2" :min="20" :max="290"></el-input-number>
                 м
                 </p>
             </div>

                 <div class="greyBox last-box">
                  <font-awesome-icon icon="lightbulb" />
                 <p style="text-align:left">Якщо необхідно розрахувати напір, скористайтесь послугами нашого помічника</p>
                 <div class="container-button">
                 <el-button class="calc-btn" type="primary" @click="dialogVisible = true"><img  width="20" :src="url+'assets/calc.png'">Розрахувати</el-button>                                     
                 </div>
             </div>
    </div>
    </el-row>        
</div>           
</template>
<script>
  export default {
    props: ['deliveryHead', 'modelHeadItems', 'url', 'dictionary'],
    data() {
      return {
        deliveryHeadInput: this.deliveryHead,
        deliveryHeadComputed: null,
        helperStep1: false,
        dialogVisible: false,
        minDeliveryHead: 20,
        maxDeliveryHead: 200,
        disabledAccept: true
      };
    },
    methods: {
    dialogCancel() {
        this.dialogVisible=false 
    },
    onInputDeliveryHead(value) {
        this.$emit('onInputDataHead', value)     
    },
    onInputHeadItems(id, value){
        this.$emit('onInputHeadItems', id, value )
    },
    onSaveComputedHead(){
        this.$emit('onInputDataHead', this.deliveryHeadComputed)
        this.deliveryHeadInput=this.deliveryHeadComputed        
    },
    onDialogAccept() {
        this.onSaveComputedHead()
        this.dialogVisible=false       
    }, 
    onComputeDeliveryHead(value){        
        this.onDisableButtonAccept(value) 
        this.deliveryHeadComputed=value
      }, 
    onDisableButtonAccept(value){
        if ((value <= this.maxDeliveryHead) && (value > this.minDeliveryHead)) {
            this.disabledAccept=false      
        }
        else {
            this.disabledAccept=true 
        }
          console.log(this.disabledAccept)
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

button.el-button.el-button--text {
    text-decoration: underline;
    font-size: 15.5px;
    color: #50b9f0;
    padding: 0;
}

</style>

