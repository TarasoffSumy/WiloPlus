<template>
<div>
    <h2 class="title-helper1">
        {{service_dictionary[15]}}
        <el-popover
            placement="top-start"
            width="200"
            trigger="hover"
            :content=service_dictionary[135]>
            <el-button type="text" slot="reference">{{service_dictionary[16]}}</el-button>
            </el-popover>
    </h2>                     
    <p class="sub-title">
        {{service_dictionary[17]}}
    </p>
    <el-row>
        <el-col :md="10" :offset="1" class="side-right">
            <p><span class="item"> <img :src="url+'assets/kitchen.svg'" alt=""> {{service_dictionary[18]}}</span>    
                <el-input-number v-model="volumeFlow.Val1.val" @change="$emit('onInputFlowItems',volumeFlow.Val1.val, 1)" :precision="0" :min="0" ></el-input-number>
                {{service_dictionary[29]}}
            </p>
            <p><span class="item"> <img :src="url+'assets/bath.svg'" alt=""> {{service_dictionary[19]}} </span>   
                <el-input-number v-model="volumeFlow.Val2.val" @change="$emit('onInputFlowItems',volumeFlow.Val2.val, 2)" :precision="0"  :min="0" ></el-input-number>
                 {{service_dictionary[29]}}
            </p>
            <p><span class="item"> <img :src="url+'assets/dishwasher.svg'" alt=""> {{service_dictionary[20]}} </span>  
                <el-input-number v-model="volumeFlow.Val3.val" @change="$emit('onInputFlowItems',volumeFlow.Val3.val, 3)" :precision="0"  :min="0" ></el-input-number>
                 {{service_dictionary[29]}} 
            </p>
        </el-col>
        <el-col :md="10" :offset="1" class="side-right">
            <p><span class="item"> <img :src="url+'assets/washer.svg'" alt=""> {{service_dictionary[21]}}</span>   
                <el-input-number v-model="volumeFlow.Val4.val" @change="$emit('onInputFlowItems', volumeFlow.Val4.val, 4)" :precision="0"  :min="0" ></el-input-number>
                 {{service_dictionary[29]}} 
            </p>
            <p><span class="item"> <img :src="url+'assets/bide.svg'" alt=""> {{service_dictionary[22]}}</span> 
                <el-input-number v-model="volumeFlow.Val5.val" @change="$emit('onInputFlowItems', volumeFlow.Val5.val, 5)" :precision="0"  :min="0" ></el-input-number>
                 {{service_dictionary[29]}} 
            </p>
            <p><span class="item"> <img :src="url+'assets/toilet.svg'" alt=""> {{service_dictionary[23]}}  </span>  
                <el-input-number v-model="volumeFlow.Val6.val" @change="$emit('onInputFlowItems', volumeFlow.Val6.val, 6)" :precision="0"  :min="0" ></el-input-number>
                 {{service_dictionary[29]}} 
            </p>
        </el-col>
    </el-row> 
    <el-row>
        <el-col :md="10" :offset="1" class="side-right">
            <p><span class="item" style="padding-left: 6px;">
                    <el-popover
                    placement="top-start"
                    width="200"
                    trigger="hover"
                    :content=service_dictionary[137]>
                    <el-button type="text" slot="reference"><span class="myTip">{{service_dictionary[24]}}</span></el-button>
                  </el-popover> 
                </span>  
                <el-input-number v-model="aditionalVolumeFlow" @change="$emit('onInputFlowItems', aditionalVolumeFlow, 7)" :precision="0"  :min="0" ></el-input-number>
                м<sup>3</sup>/ч              
            </p>
        </el-col>
    </el-row>
    <el-row justice="center" class="row-before-nav">
        <div class="computed-volumeFlow">
          <span class="label">{{service_dictionary[25]}}</span>
          <span class="number"> {{compTotal | aroundNumber}}</span> м<sup>3</sup>/ч 
        </div>
        <span class="exeption-validation" v-if="!$v.volumeFlowValTotal.between">{{service_dictionary[26]}} 
                <strong>17 м<sup>3</sup>/{{service_dictionary[7]}}</strong></span>   
    </el-row>  
</div>
</template>
<script>
import { required, minLength, between } from 'vuelidate/lib/validators';
export default {
    props: ['modelFlowItems', 'url', 'service_dictionary'],
    data() {
      return {
          volumeFlow: {
            Val1: {
                val: this.modelFlowItems.val1,
                constantQ: 0.504,
                label: 'Мийка кухні/умивальник'
                },
            Val2: {
                val: this.modelFlowItems.val2,
                constantQ: 1.080,
                label: 'Ванна/душова кабіна'               
            },
            Val3: {
                val: this.modelFlowItems.val3,
                constantQ: 0.252,
                label: 'Посудомийна машина'
            },                
            Val4: {
                val: this.modelFlowItems.val4,
                constantQ: 0.540,
                label: 'Пральна машина'
                },
            Val5: {
                val: this.modelFlowItems.val5,
                constantQ: 0.504,
                label: 'Биде'               
            },
            Val6: {
                val: this.modelFlowItems.val6,
                constantQ: 0.504,
                label: 'Унитаз'
            }                 
          },  
        aditionalVolumeFlow:this.modelFlowItems.aditionalFlow,       
        volumeFlowValTotal: 0,
        Qrez: 0
      }
    },
    validations: {
        volumeFlowValTotal: {
        required,
        between: between(0, 17)
        }
    },
    filters: {
        aroundNumber: function (value) {
        value = Number(value).toFixed(2)
        return value
        }
    },
    computed: {
        compTotal: function() {
            var source=Object.values(this.volumeFlow);
             let Qrez=0;
             for (let i in source){
                 Qrez=Qrez+source[i].val*source[i].constantQ
             }
            function getLog(y) {
                return Math.log(y) ;
            }
            if (Qrez <= 0.55) {
                this.volumeFlowValTotal=Qrez
            }
            else if ((Qrez > 0.55) && (Qrez <= 6.50)) {
                this.volumeFlowValTotal=0.937*getLog(Qrez)+0.7689
            }
            else if ((Qrez > 6.50) && (Qrez <= 15.00)) {
                this.volumeFlowValTotal=1.2291*getLog(Qrez)+0.2642
            }
            else if ((Qrez > 15.00) && (Qrez <= 50)) {
                this.volumeFlowValTotal=1.4844*getLog(Qrez)+0.4326
            }
            else if ((Qrez > 50.0) && (Qrez <= 150)) {
                this.volumeFlowValTotal=1.8644*getLog(Qrez)+0.4326
            }
            this.volumeFlowValTotal=this.volumeFlowValTotal+this.aditionalVolumeFlow
            this.$emit('onComputeVolumeFlow', this.volumeFlowValTotal)
            return this.volumeFlowValTotal
        }
    }
  };
</script>
<style scoped>
.row-before-nav {
    height: 100px;
}
.side-right .item {
    min-width: 220px;
    text-align: left;
    display: inline-table;
    margin: 5px 0 5px 0;
}
.left .item {
    min-width: 210px;
}
.computed-volumeFlow {
    font-size: 16px;
    padding: 35px 0 5px 0;
}
.computed-volumeFlow .label, .computed-volumeFlow .number {    
    font-weight: 600;
    font-size: 18px;
}
.computed-volumeFlow .number {
    border-bottom: 1px solid #b9b8b8;
    padding: 2PX 15px;
    font-size: 18px;
}
.el-dialog__body {
    padding: 0;
}
.el-dialog__body h2 {
    color: #009c82;
}
p.sub-title {
    text-align: left;
    padding-left: 94px;
    font-size: 16px;
    font-weight: 600;
}
.side-right p {
    text-align: center
}
.side-right img {
    vertical-align: middle;
    display: inline-block;
    width: 42px;
    height: 42px;
    margin-right: 10px;
    margin-bottom: 5px;
}
.additional-volume-flow {
    padding: 0 63px 0 64px
}
.additional-volume-flow button {
    color: #363640
}
.title-helper1 span .el-popover__reference  {
    font-weight: 600;
    font-size: 20px;
}
</style>