<template>
<div>
    <h2>Помічник визначення напору насоса</h2>
    <el-row>
        <el-col  :md="12" :sm="24" class="side-left-helper">
            <div v-for="item in helperHead" :key="item.id" class="row-item" :class="[{ activeLeftCircle: focusInput==item.id}]">
                <div class="circle_number">                   
                    <svg height="36" width="36" class="circle">
                    <circle cx="17" cy="17" r="17" stroke="" stroke-width="2" fill="" />
                    </svg><div class="symbolInCircle">{{item.letter}} </div> 
                    <div ></div>    
                </div>
                <span v-if="item.id==1" class="item">Висота від землі до 
                    <el-popover
                    placement="top-start"
                    width="150"
                    trigger="hover"
                    :content=dictionary[3].full_text>
                    <el-button type="text" slot="reference"><span class="myTip">динамічного рівня</span></el-button>
                  </el-popover>
                  води в свердловині 
                </span>  
                <span v-else-if="item.id==2 || item.id==3" v-html="item.title" class="item"></span>
                <span class="wrap-input ">
                <el-input-number @focus="onFocusInput(item.id)" v-model="item.valueHead" @change="handleChange(item.valueHead, item.id)"  :precision="2" :min="0" ></el-input-number>
                м 
                </span>
            </div>
            <div class="row-item"><div class="additional-volume-flow">
                  <el-popover
                    placement="top-start"
                    width="150"
                    trigger="hover"
                    :content=dictionary[4].full_text>
                    <el-button type="text" slot="reference"><span class="myTip">Додатковий напір, якщо відомий</span></el-button>
                  </el-popover>                
                </div>  
                <el-input-number @focus="onFocusInput(0)" v-model="additionalHead"  @change="handleChange(additionalHead, 4)"  :precision="2" :min="0"></el-input-number>
                м             
            </div>
            <div class="row-item">
                <p style="text-align:center">
                    <el-popover
                    placement="top-start"
                    width="150"
                    trigger="hover"
                    :content=dictionary[13].full_text>
                    <el-button type="text" slot="reference"><span class="myTip">Рекомендований діаметр</span></el-button>
                    </el-popover> трубопроводів для вашої витрати 
                    <span v-if='compDiametr.equally'>дорівнює  <strong>DN{{compDiametr.max_around}}</strong>  </span>
                    <span v-else>від <strong>DN{{compDiametr.min_around}}</strong>  до <strong>DN{{compDiametr.max_around}}</strong> </span>
                </p>
                <div class="computed-deliveryHead">
                    <span class="label">Розрахований напір</span>
                    <span class="number"> {{compTotal}}</span> м 
                </div> 
            </div>
        </el-col>
        <el-col :md="12" :sm="24" class="side-right-helper">
            <div class="numbers">
                <el-button  v-for="item in helperHead" @click="onFocusInput(item.id)" :key='item.id' :class="['circle_number number_'+item.letter, {green: focusInput==item.id}]" type="text">                   
                        <svg height="36" width="36" class="circle" >
                        <circle cx="17" cy="17" r="17" stroke="" stroke-width="2" fill="" />
                        </svg><div class="symbolInCircle">{{item.letter}}</div>
                        <div :class="[{ active: focusInput==item.id}]"></div>                            
                </el-button>
            </div>            
        </el-col>
    </el-row> 
</div>
</template>
<script>
import { required, minLength, between } from 'vuelidate/lib/validators';
  export default {
    props: ['modelHeadItems', 'url', 'dictionary', 'volumeFlow'],
    data() {
      return {
        helperHead: {
            item_A: {
                id:1,
                letter: 'A',
                title: 'Висота від землі до <span class="myTip" title="Рівень води при роботі насосу на дебіті.">динамічного рівня</span> води в свердловині',
                valueHead: this.modelHeadItems.val1
            },
            item_B: {
                id:2,
                letter: 'B',
                title: 'Відстань від свердловини до будинку',
                valueHead: this.modelHeadItems.val2
            },
            item_C: {
                id:3,
                letter: 'C',
                title: 'Висота від землі до найвищої точки водоспоживання',
                valueHead: this.modelHeadItems.val3
            }
        },
        additionalHead: this.modelHeadItems.val4,
        HeadValTotal: 0,
        focusInput: 0
      }
    },
    computed: {
        compTotal: function() {
            let a=this.helperHead.item_A.valueHead
            let b=this.helperHead.item_B.valueHead
            let c=this.helperHead.item_C.valueHead
            let sum=(a+c+0.2*(a+b+c)+18)+this.additionalHead
            this.HeadValTotal=sum
            this.$emit('onComputeDeliveryHead', this.HeadValTotal)
            return sum
        },
        compDiametr: function(){
            let dim={}           
            dim.min=18.81*Math.sqrt((this.volumeFlow)/1.5)
            dim.max=18.81*Math.sqrt((this.volumeFlow)/1)
            dim.min_around=(this.onFindeDimInArr(dim.min))
            dim.max_around=(this.onFindeDimInArr(dim.max))
            if  (dim.min_around===dim.max_around) {
                dim.equally=true
                }
                else
                {
                    dim.equally=false
                }

            return dim
        }
    },
    methods: {
        handleChange(value, id) {
            this.focusInput=id  
            this.$emit('onInputHeadItems', id, value)
            },
        onFocusInput(value) {
            this.focusInput=value
            },
        onFindeDimInArr(val) {
           let dimArr=[32, 40, 50, 65, 80, 90, 100, 125, 150]
                if (val <= dimArr[0]) {
                     return dimArr[0]
                }
                else {
                    for(let i=0; i< dimArr.length; i++) {
                        if ((val > dimArr[i]) && (val <= dimArr[i+1])) 
                            {
                                return dimArr[i+1];                     
                            }
                    }
                } 
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
    top: 325px;
    left: -215px;
}
.circle_number.number_B {
    top: 344px;
    left: -64px;
}
.circle_number.number_C {
    top: 211px;
    left: -1px;
}
.pos-img {
    width: 100%;
    margin: auto;
    position: relative;
    top: 0;
}
.numbers {
    width: 586px;
    height: 521px;
}
.side-right-helper {
    background-image: url(http://www.wiloexpert.com.ua/wilo/assets/head_scheme.jpg);
    background-repeat: no-repeat;
    min-height: 495px;
    background-position-y: 23px;
}
.row-item {
    margin: 20px 0;
}
.circle {
    fill: #febf00;
    stroke: transparent;
}
.circle_number {
    padding-top: 7px;
    margin: auto;
    width: 50px;
    height: 50px;
    display: inline-table;
    vertical-align: top;
}
.circle_number .symbolInCircle {
    position: relative;
    top: -34px;
    left: -2px;
    font-size: 20px;
    color: #fff;
    z-index: 6;
}
.side-right-helper .circle_number {
    padding-top: 45px
}
.side-left-helper .circle_number .symbolInCircle
{
    top: -32px;
    left: -1px;
}
.side-left-helper {
    margin-top: 30px;
}
.item {
    width: 260px;
    text-align: left;
    display: inline-table;
    margin: 0 5px 15px 0px;
}
.additional-volume-flow {
    display: inline-table;
    padding: 0px 43px 15px 0px;
    text-align: left;
    margin-left: 48px;
}
.additional-volume-flow .link{
    color: #222222;
}
.computed-deliveryHead {
    font-size: 20px;
    text-align: left;
    text-align: center;
    margin-top: 17px;
    color: #171717;
    padding: 15px 7px;
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

