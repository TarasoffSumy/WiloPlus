<template>
<div>
    <h2>Підбір приладдя до свердловинного насосу</h2>
    <el-row>
        <el-col :span="12" class="side-left-helper">
            <el-button  v-for="item in selectedAccessories" @click="onFocusInput(item.id)" :key='item.id' :class="['circle_numder number_'+item.id, {green: focusInput==item.id}]" type="text">                   
                    <svg height="36" width="36" class="circle" >
                    <circle cx="17" cy="17" r="17" stroke="" stroke-width="2" fill="" />
                    </svg><div class="symbolInCircle">{{item.id}}</div>
                    <div :class="[{ active: focusInput==item.id}]"></div>                            
            </el-button>
        <img style="margin-top:-20px;text-align: left; position: absolute; left: 54px;" :src="url+'assets/accessories.jpg'" width="450" alt="">
        </el-col>
        <el-col :span="10" class="side-right-helper">
            <div v-for="item in selectedAccessories" class="row-item" :class="[{activeLeftCircle: focusInput==item.id}]">
                        <div class="circle_numder">                   
                            <svg height="36" width="36" class="circle">
                            <circle cx="17" cy="17" r="17" stroke="" stroke-width="2" fill="" />
                            </svg><div class="symbolInCircle">{{item.id}} </div>  
                        </div>
                    <el-button type="text"><span class="item"  @click="onFocusInput(item.id)">{{item.title}}</span></el-button>         
            </div>           
        </el-col>
    </el-row> 
    <el-row>
        <h4>{{activeAccessories}}</h4>
        <div v-if="focusInput==1">
        <div class="block-accessoreis"  v-for="item in controllers" :key="item.id">
            <el-row>                     
                    <el-col :span="4" >
                     <el-radio  v-model="selectedAccessories.item1.idController"  @change="handleChange(item.id)" :label="item.id">
                         <span class="name-item">{{item.name}}</span></el-radio>                    
                    </el-col>
                    <el-col :span="5">
                    <img :src="url+'assets/controller.jpg'" width="100px" alt="">
                    </el-col>
                    <el-col :span="12" :offset="2">
                        <p>Ціна <strong>{{item.price}} грн</strong></p>                           
                        <p>Ток мінімальний  <strong>{{item.features.current_min}}</strong> </p>
                        <p>Ток максимальний <strong>{{item.features.current_max}}</strong> </p>
                        <el-button type="primary">Детальніше</el-button>                       
                    </el-col>                    
                </el-row>               
        </div>
        </div>
        <div  v-if="focusInput==2" class="Accessories-cable">
        <p> Довжина кабелю <el-input-number v-model="accessories.cablelength" @change="handleChange(accessories.cablelength)" :min="0" ></el-input-number> м</p>
        <p class="detail-title"> Перетин кабелю <span>4 х 1.5 мм<sup>2</sup></span> </p>
        </div>     
    </el-row>
</div>
</template>

<script>
import Axios from 'axios';
  export default {
    props: ['url', 'selectedPumpCurrent', "selectedAccessories"],
    data() {
      return {
        accessories :{
            cablelengtch:''
        },
        HeadValTotal: 0,
        focusInput: 0,
        activeAccessories:'',
        controllers:'',
        selectedController:'456'
      }
    },
    computed: {
    },
    created:  function(){
        console.log(this.selectedPumpCurrent)
        this.postDataControllers('11A')
    },
    methods: {
    handleChange(id){
        this.onSelectController(id)
    },
    onFocusInput(value) {
        this.focusInput=value  
        this.activeAccessories=this.selectedAccessories['item'+value].title
    },
    onSelectController(id){
        let sourse=this.controllers
        let dataControlBox=sourse.filter( function(el) {
              return el.id==id
            }
        )
        console.log(dataControlBox)
        this.$emit('onSelectController', id, dataControlBox )
    },
    postDataControllers: function(current) {
                const getPromise = Axios.post('http://www.wiloexpert.com.ua/wilo/db/controlSelect', {"current" : current});
                getPromise.then(response => {
                this.controllers = response.data;
                console.log(this.controllers );
                })
                .catch(error => {
                    console.log(error);
                });
    }
    }
  };
</script>
<style scoped>
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
p.detail-title {
    font-size: 18px;
    font-weight: 600;
}
.detail-title span {
    background: #eee;
    padding: 6px 14px;
}
.circle_numder.number_1, .circle_numder.number_2, .circle_numder.number_3, .circle_numder.number_4 {
    position: relative; 
    z-index: 6;    
}
.side-left-helper  .active {
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
.side-right-helper .activeLeftCircle .circle, .side-left-helper .green .circle   {
    fill: #009c82;
    z-index: 5;
    position: relative;
}
.circle_numder.number_1 {
    top: 132px;
    left: 116px;
}
.circle_numder.number_2 {
    top: 214px;
    left: 101px;
}
.circle_numder.number_3 {
    top: 305px;
    left: 23px;
}
.circle_numder.number_4 {
    top: 160px;
    left: 216px;
}
.pos-img {
    position: relative;
    top: -27px;
}
.side-right-helper{
    padding-top: 20px;
    height: 380px;
}
.row-item {
    padding: 0;
    height: 60px;
    text-align: left;
}
.circle {
    fill: #febf00;
    stroke: transparent;
}
.circle_numder {
    padding-top: inherit;
    margin-top: 10px;
}
.circle_numder .symbolInCircle {
    position: relative;
    top: -38px;
    left: 12px;
    font-size: 20px;
    color: #fff;
    z-index: 6;
}

.side-left-helper .circle_numder .symbolInCircle
{
    top: -33px;
    left: -1px;
}
.item {
    text-align: left;
    margin: 4px 5px 15px 0px;
    vertical-align: middle;
    float: left;
    color: #222;
    font-weight: 600;
}
.additional-volume-flow {
    display: inline-table;
    padding: 17px 55px 0 0px;
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
.block-accessoreis {
    display: inline-block;
    margin: auto;
    padding: 20px;
}
.block-accessoreis p {
    text-align: left    
}
span.name-item {
    font-size: 18px;
    font-weight: 600;
    color: #222;
}
</style>

