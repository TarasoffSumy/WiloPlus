<template>
<div>
    <h2 class="title-helper1">Помічник визначення 
        <el-popover
            placement="top-start"
            :title=dictionary[1].short_text
            width="200"
            trigger="hover"
            :content=dictionary[1].full_text>
            <el-button type="text" slot="reference">витрати насоса</el-button>
            </el-popover>
    </h2>                     
    <p class="sub-title">
        Вкажіть кількість точок водозбору
    </p>
    <el-row>
        <el-col :md="10" :offset="1" class="side-right">
            <p><span class="item"> <img :src="url+'assets/kitchen.svg'" alt=""> Мийка кухні/умивальник </span>    
                <el-input-number v-model="volumeFlow.Val1.val" @change="$emit('onInputFlowItems',volumeFlow.Val1.val, 1)" :precision="0" :min="0" ></el-input-number>
                од. 
            </p>
            <p><span class="item"> <img :src="url+'assets/bath.svg'" alt=""> Ванна/душова кабіна </span>   
                <el-input-number v-model="volumeFlow.Val2.val" @change="$emit('onInputFlowItems',volumeFlow.Val2.val, 2)" :precision="0"  :min="0" ></el-input-number>
                од. 
            </p>
            <p><span class="item"> <img :src="url+'assets/dishwasher.svg'" alt=""> Посудомийна машина </span>  
                <el-input-number v-model="volumeFlow.Val3.val" @change="$emit('onInputFlowItems',volumeFlow.Val3.val, 3)" :precision="0"  :min="0" ></el-input-number>
                од. 
            </p>
        </el-col>
        <el-col :md="10" :offset="1" class="side-right">
            <p><span class="item"> <img :src="url+'assets/washer.svg'" alt=""> Пральна машина</span>   
                <el-input-number v-model="volumeFlow.Val4.val" @change="$emit('onInputFlowItems', volumeFlow.Val4.val, 4)" :precision="0"  :min="0" ></el-input-number>
                од. 
            </p>
            <p><span class="item"> <img :src="url+'assets/bide.svg'" alt=""> Біде</span> 
                <el-input-number v-model="volumeFlow.Val5.val" @change="$emit('onInputFlowItems', volumeFlow.Val5.val, 5)" :precision="0"  :min="0" ></el-input-number>
                од. 
            </p>
            <p><span class="item"> <img :src="url+'assets/toilet.svg'" alt=""> Унітаз  </span>  
                <el-input-number v-model="volumeFlow.Val6.val" @change="$emit('onInputFlowItems', volumeFlow.Val6.val, 6)" :precision="0"  :min="0" ></el-input-number>
                од. 
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
                    :content=dictionary[2].full_text>
                    <el-button type="text" slot="reference"><span class="myTip">Додаткові витрати, якщо відомі</span></el-button>
                  </el-popover> 
                </span>  
                <el-input-number v-model="aditionalVolumeFlow" @change="$emit('onInputFlowItems', aditionalVolumeFlow, 7)" :precision="0"  :min="0" ></el-input-number>
                м<sup>3</sup>/ч              
            </p>
        </el-col>
    </el-row>
    <el-row justice="center" class="row-before-nav">
        <div class="computed-volumeFlow">
          <span class="label">Розрахована витрата</span>
          <span class="number"> {{compTotal | aroundNumber}}</span> м<sup>3</sup>/ч 
        </div>
        <span class="exeption-validation" v-if="!$v.volumeFlowValTotal.between">Нажаль серія насосів Actun SPU4 не може задовільнити ваші потреби, 
                 витрата не повинна перевищувати <strong>17 м<sup>3</sup>/ч</strong></span>   
    </el-row>  
</div>
</template>
<script>
import { required, minLength, between } from 'vuelidate/lib/validators';
  export default {
    props: ['modelFlowItems', 'url', 'dictionary'],
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