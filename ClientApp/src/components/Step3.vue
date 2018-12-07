<template>
<div>

    <el-dialog
    title=""
    :visible.sync="dialogVisible"
    width="80%"
    >
    <Step3-helper 

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

                /> 
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

