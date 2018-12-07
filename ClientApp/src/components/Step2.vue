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
    <div class="circle_numder">
        <svg height="55" width="53" class="circle">
        <circle cx="26" cy="26" r="24" stroke="" stroke-width="2" fill="" />
        </svg> <span>2 </span>            
    </div>
    <h2 class="title">Напір насоса</h2> 
    </el-row> 
    <el-row>
        <el-col :span="12">
             <div class="greyBox">
                 <h3>Необхідний напір насоса</h3>                
                 <p>Напір  
                     <el-input-number v-model="deliveryHeadInput" @change="onInputDeliveryHead"  ></el-input-number>
                 м<sup>3</sup>/ч 
                 </p>
                 <p class="alert"><i type="info" class="el-icon-info"></i>
                 Як необхідно розраховувати витрату насоса. Беремо напір 
                 <el-button type="text" @click="open">констативний</el-button>, та множимо на число
                 </p>
             </div>
        </el-col>
        <el-col :span="12">
                 <div class="greyBox">
                  <font-awesome-icon icon="lightbulb" />
                 <p style="text-align:left">Якщо необхідно розрахувати напір, скористайтесь послугами нашого помічника</p>
                 <div class="container-button">
                 <el-button type="primary" @click="dialogVisible = true">Розрахувати</el-button>                                     
                 </div>
             </div>
        </el-col>
    </el-row>        
</div>           
</template>
<script>
  export default {
    props: ['deliveryHead', 'modelHeadItems'],
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
    //   ActiveHelperStep1() {
    //       this.helperStep1=!this.helperStep1
    //   },       
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
.title {
    display: inline-block;
    float: left;
    padding: 15px;
}
.circle {
    fill: #009c81;
    stroke: transparent
}
.circle_numder {
    padding-top: 20px;
    margin: auto;
    width: 50px;
    height: 50px;
    float: left;
}
.circle_numder span {
    position: relative;
    top: -53px;
    left: 0px;
    font-size: 25px;
    color: #fff
}
.greyBox {
    padding: 20px;
    background: #f6f6f6;
    display: block;
    color: #212121;
    margin: 20px;
    min-height: 185px;
}
.alert {
    padding: 10px;
    text-align: left;
    line-height: 1.2;
    font-size: 13px;
}
button.el-button.el-button--text {
    text-decoration: underline;
    font-size: 15.5px;
    color: #50b9f0;
    padding: 0;
}
.container-button {
    text-align: right;
    padding: 35px 20px 10px;
}
</style>

