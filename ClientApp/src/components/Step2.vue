<template>
<div>
    <el-dialog
        title=""
        :visible.sync="dialogVisible"
        width="85%"
        top="5vh"
        >
        <Step2-helper @onComputeDeliveryHead="onComputeDeliveryHead"
            @onInputHeadItems="onInputHeadItems" 
            :modelHeadItems="modelHeadItems"
            :service_dictionary="service_dictionary"
            :volumeFlow="volumeFlow"
            :url="url"
        /> 
        <span slot="footer" class="dialog-footer">       
            <el-row class="navigation-footer">
            <el-col :span="12">
                <el-button @click="dialogVisible = false">{{service_dictionary[27]}}</el-button>
            </el-col>
            <el-col :span="12">
                <el-button type="primary" @click="onDialogAccept">{{service_dictionary[28]}}</el-button>
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
        <h2 class="title">{{service_dictionary[2]}}</h2> 
    </el-row> 
    <el-row>
        <el-tabs class="mobile"  v-model="activeTab">
            <el-tab-pane :label=service_dictionary[6] name="first">
                    <h3>{{service_dictionary[6]}}</h3>                
                    <el-row justify="center">{{service_dictionary[65]}} 
                        <el-input-number v-model="deliveryHeadInput" @change="onInputDeliveryHead" :precision="1" :min="0"></el-input-number> м
                    </el-row >
            </el-tab-pane>
            <el-tab-pane label="Розрахувати" name="second">
            <span slot="label"><img class="calc-bg" width="20" :src="url+'assets/calc.png'">  Розрахувати</span>
                    <Step2-helper @onComputeDeliveryHead="onComputeDeliveryHead"
                                @onInputHeadItems="onInputHeadItems" 
                                :modelHeadItems="modelHeadItems"
                                :service_dictionary="service_dictionary"
                                :volumeFlow="volumeFlow"
                                :url="url"
                    /> 
            <el-row class="navigation-footer">
            <el-col :span="12">
                 <el-button @click="dialogVisible = false">{{service_dictionary[27]}}</el-button>
            </el-col>
            <el-col :span="12">
                <el-button type="primary" @click="onDialogAccept">{{service_dictionary[28]}}</el-button>
            </el-col>
            </el-row>
            </el-tab-pane>
        </el-tabs> 
        <div class="desktop">
            <div class="greyBoxes-container">
                <div class="greyBox">
                        <h3>{{service_dictionary[30]}}</h3>                
                        <el-row justify="center">{{service_dictionary[65]}} 
                            <el-input-number v-model="deliveryHeadInput" @change="onInputDeliveryHead" :precision="1" :min="0"></el-input-number> м
                        </el-row >
                </div>
                <div class="greyBox last-box">
                        <font-awesome-icon icon="lightbulb" />
                        <h3 style="text-align:left">{{service_dictionary[31]}} </h3>
                        <p>{{service_dictionary[12]}}</p>
                        <div class="container-button">
                        <el-button class="calc-btn" type="primary" @click="dialogVisible = true"><img  width="20" :src="url+'assets/calc.png'">{{service_dictionary[13]}}</el-button>                                     
                        </div>
                </div>
            </div>
        </div>
    </el-row>        
</div>           
</template>
<script>
  export default {
    props: ['deliveryHead', 'modelHeadItems', 'url', "service_dictionary", 'volumeFlow'],
    data() {
      return {
        activeTab:'first',
        deliveryHeadInput: this.deliveryHead,
        deliveryHeadComputed: null,
        dialogVisible: false,
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
            this.activeTab='first'      
            }, 
        onComputeDeliveryHead(value){      
            this.deliveryHeadComputed=value
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

