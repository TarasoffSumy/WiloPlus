<template>
<div>   
    <el-dialog
      title=""
      :visible.sync="dialogVisible"
      width="85%"
      top="5vh"
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
              <el-button type="primary" @click="onDialogAccept">Підтвердити <i class="el-icon-d-arrow-right el-icon-right"/></el-button>
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
    <el-tabs class="mobile"  v-model="activeTab">
        <el-tab-pane label="Необхідна витрата насоса" name="first">
             <h3>Необхідна витрата насоса</h3>       
                 <el-row justify="center">Витрата  <el-input-number v-model="(volumeFlowInput)" :precision="2" @change="onInputVolumeFlow"></el-input-number>
                 м<sup>3</sup>/год
                 </el-row>
                 <p><i type="info" class="el-icon-info"></i>
                 Витрата насоса повинна бути меншою за <el-popover
                    placement="bottom"
                    :title=dictionary[0].short_text
                    width="200"
                    trigger="hover"
                    :content=dictionary[0].full_text>
                    <el-button type="text"  slot="reference"><span class="myTip">продуктивність</span></el-button>
                  </el-popover>
                  <el-popover
                    placement="bottom"
                    :title=dictionary[0].short_text
                    width="200"
                    trigger="hover"
                    :content=dictionary[0].full_text>
                    <el-button type="text"  slot="reference"><span class="myTip">свердловини</span></el-button>
                  </el-popover>                   
                 </p>
        </el-tab-pane>
        <el-tab-pane label="Розрахувати" name="second">
          <span  slot="label"><img class="calc-bg" width="20" :src="url+'assets/calc.png'"> Розрахувати</span>
          <Step1-helper 
              @onComputeVolumeFlow="onComputeVolumeFlow"
              @onInputFlowItems="onInputFlowItems" 
              :dictionary="dictionary"
              :modelFlowItems="modelFlowItems"
              :url="url"
              />
          <el-row class="navigation-footer">
            <el-col :span="12">
                <el-button @click="dialogCancel"  icon="el-icon-d-arrow-left">Назад</el-button>
            </el-col>
            <el-col :span="12">
                <el-button type="primary" @click="onDialogAccept">Підтвердити <i class="el-icon-d-arrow-right el-icon-right"/></el-button>
            </el-col>
          </el-row>
        </el-tab-pane>
    </el-tabs> 
    <div class="desktop">
      <div class="greyBoxes-container">
              <div class="greyBox">
                  <h3>Необхідна витрата насоса</h3>       
                  <el-row justify="center">Витрата  <el-input-number v-model="(volumeFlowInput)" :min="0" :precision="2" @change="onInputVolumeFlow"></el-input-number>
                  м<sup>3</sup>/год
                  </el-row>
                  <p>
                  Витрата насоса повинна бути меншою за
                    <el-popover
                      placement="bottom"
                      width="200"
                      trigger="hover"
                      :content=dictionary[0].full_text>
                      <el-button type="text"  slot="reference"><span class="myTip">продуктивність свердловини</span></el-button>
                    </el-popover>                   
                  </p>
              </div>
              <div class="greyBox last-box">
                  <font-awesome-icon icon="lightbulb" />
                  <h3 style="text-align:left">Невідома витрата? </h3>
                  <p>Скористайтесь послугами нашого помічника!</p>
                  <div class="container-button"> 
                  <el-button class="calc-btn" type="primary" @click="dialogVisible = true"><img  width="20" :src="url+'assets/calc.png'">Розрахувати</el-button>                                     
                  </div>
              </div>
      </div>
    </div>
    </el-row>        
</div>        
</template>

<script>
import Axios from 'axios';
export default {
    props: ['volumeFlow', "modelFlowItems", "url", "dictionary"],
    data() {
      return {
        activeTab:'first',
        dic: this.dictionary.id1,
        volumeFlowInput: this.volumeFlow,
        volumeFlowComputed: 0,
        dialogVisible: false,
        disabledAccept: true,     
      };
    },
    methods: {
      dialogCancel() {
        this.dialogVisible=false 
        },
      onInputVolumeFlow(value) {
        this.$emit('onInputDataVolume', value)
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
        this.activeTab='first'   
        console.log(this.activeTab)
        },
      onComputeVolumeFlow(value){          
        this.volumeFlowComputed=value
        },
      onDisableButtonAccept(){
            this.disabledAccept=true 
        }
      }
}
</script>
