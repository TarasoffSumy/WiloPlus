<template>
<div>
    <h2>Помічник визначення напору насоса</h2>
    <el-row>
        <el-col :span="12" class="side-left-helper">
            <div v-for="item in helperHead" :key="item.id" class="row-item" :class="[{ activeLeftCircle: focusInput==item.id}]">
                <div class="circle_number">                   
                    <svg height="36" width="36" class="circle">
                    <circle cx="17" cy="17" r="17" stroke="" stroke-width="2" fill="" />
                    </svg><div class="symbolInCircle">{{item.letter}} </div> 
                    <div ></div>    
                </div>
                <span v-html="item.title" class="item"></span>    
                <el-input-number @focus="onFocusInput(item.id)" v-model="item.valueHead" @change="handleChange(item.valueHead, item.id)"  :precision="2" :min="0" ></el-input-number>
                м 
            </div>
            <div class="row-item"><div class="additional-volume-flow">
                  <el-popover
                    placement="top-start"
                    :title=dictionary[4].short_text
                    width="150"
                    trigger="hover"
                    :content=dictionary[4].full_text>
                    <el-button type="text" slot="reference"><span class="myTip">Додатковий напір</span></el-button>
                  </el-popover>                
                <i type="info" class="el-icon-question"></i></div>  
                <el-input-number @focus="onFocusInput(0)" v-model="additionalHead"  @change="handleChange(additionalHead, 4)"  :precision="2" :min="0"></el-input-number>
                м             
            </div>
            <div class="row-item">
                <div class="computed-deliveryHead">
                <span class="label">Розрахований напір</span>
                <span class="number"> {{compTotal}}</span> м 
                </div> 
                <span class="exeption-validation" v-if="!$v.HeadValTotal.between">
                 діапазон <strong>20м - 200м</strong></span>                
            </div>
        </el-col>
        <el-col :span="10" class="side-right-helper">
            <el-button  v-for="item in helperHead" @click="onFocusInput(item.id)" :key='item.id' :class="['circle_number number_'+item.letter, {green: focusInput==item.id}]" type="text">                   
                    <svg height="36" width="36" class="circle" >
                    <circle cx="17" cy="17" r="17" stroke="" stroke-width="2" fill="" />
                    </svg><div class="symbolInCircle">{{item.letter}}</div>
                    <div :class="[{ active: focusInput==item.id}]"></div>                            
            </el-button>
            <img class="pos-img" :src="url+'assets/head_scheme.jpg'" alt="">
        </el-col>
    </el-row> 
    <el-row >    
    </el-row> 
</div>
</template>
<script>
import { required, minLength, between } from 'vuelidate/lib/validators';
  export default {
    props: ['modelHeadItems', 'url', 'dictionary'],
    data() {
      return {
        helperHead: {
            item_A: {
                id:1,
                letter: 'A',
                title: 'Висота від землі до рівня води в свердловині',
                valueHead: this.modelHeadItems.val1
            },
            item_B: {
                id:2,
                letter: 'B',
                title: 'Висота від землі до <span class="myTip" title="Рівень води при роботі насосу на дебіті.">динамічного рівня</span> води в свердловині',
                valueHead: this.modelHeadItems.val2
            },
            item_C: {
                id:3,
                letter: 'C',
                title: 'Висота від землі до рівня води в свердловині',
                valueHead: this.modelHeadItems.val3
            }
        },
        additionalHead: this.modelHeadItems.val4,
        HeadValTotal: 0,
        focusInput: 0
      }
    },
    validations: {
        HeadValTotal: {
        between: between(20, 290)
        }
    },
    computed: {
        compTotal: function() {
            let sum=this.helperHead.item_A.valueHead
                         +this.helperHead.item_B.valueHead
                         +this.helperHead.item_C.valueHead
                         +this.additionalHead+18
            this.HeadValTotal=sum
            this.$emit('onComputeDeliveryHead', this.HeadValTotal)
            return sum
        }
    },
    created:  function(){
    },
    methods: {
      handleChange(value, id) {
       this.focusInput=id  
       this.$emit('onInputHeadItems', id, value)
      },
      onFocusInput(value) {
        this.focusInput=value  
        console.log(this.focusInput)
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
  };
</script>
<style scoped>
.transition-box .circle_number {
    float: none;
}
@-webkit-keyframes pulse1 {
    0% {
        opacity: 1;
        -webkit-transform: scale(1);
        transform: scale(1);
    }
    50% {
        opacity: 0;
        -webkit-transform: scale(1.5);
        transform: scale(1.5);
    }
    100% {
        opacity: 0;
        -webkit-transform: scale(1.5);
        transform: scale(1.5);
    }
}

@keyframes pulse1 {
    0% {
        opacity: 1;
        -webkit-transform: scale(1);
        transform: scale(1);
    }
    50% {
        opacity: 0;
        -webkit-transform: scale(1.5);
        transform: scale(1.5);
    }
    100% {
        opacity: 0;
        -webkit-transform: scale(1.5);
        transform: scale(1.5);
    }
}
.circle_number.number_A, .circle_number.number_B, .circle_number.number_C {
    position: relative; 
    z-index: 6;    
}
.side-right-helper .active {
    position: relative;
    top: -65px;
    z-index: 1;
    background: #fff;
    width: 20px;
    padding: 12px;
    height: 20px;
    border-radius: 50%;
    left: 0.5px;
    -webkit-animation: pulse1 2s linear infinite;
    -moz-animation: pulse1 2s linear infinite;
    animation: pulse1 2s linear infinite;
}
.side-left-helper .activeLeftCircle .circle, .side-right-helper .green .circle   {
    fill: #009c82;
    z-index: 5;
    position: relative;
}
.circle_number.number_A {
    top: 355px;
    left: -176px;
}
.circle_number.number_B {
    top: 344px;
    left: -34px;
}
.circle_number.number_C {
    top: 237px;
    left: 44px;
}
.pos-img {
    position: relative;
    top: -27px;
}
.row-item {
    padding: 0;
    height: 100px;
}
.circle {
    fill: #febf00;
    stroke: transparent;
}
.circle_number {
    padding-top: 20px;
    margin: auto;
    width: 50px;
    height: 50px;
    display: inline-table;
    vertical-align: middle;
}
.circle_number .symbolInCircle {
    position: relative;
    top: -32px;
    left: -2px;
    font-size: 20px;
    color: #fff;
    z-index: 6;
}

.side-left-helper .circle_number .symbolInCircle
{
    top: -32px;
    left: -1px;
}
.item {
    width: 250px;
    text-align: left;
    display: inline-table;
    margin: 0 5px 15px 10px;
    vertical-align: middle;
}
.additional-volume-flow {
    display: inline-table;
    padding: 17px 80px 0 0px;
    text-align: left;
    margin-left: 78px;
}
.additional-volume-flow .link{
    color: #222222;
}
.computed-deliveryHead {
    font-size: 20px;
    text-align: left;
    margin-left: 121px;
    margin-top: 17px;
    color: #171717;
    padding: 15px;
}
.computed-deliveryHead .label {    
    font-weight: 600;
    padding-right: 25px;
    margin-left: 16px;
}
.computed-deliveryHead .number {
    border-bottom: 1px solid #b9b8b8;
    padding: 2px 15px;
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
.side-side1-helper p {
    text-align: center
}
</style>

