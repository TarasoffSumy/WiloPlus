<template>
  <div>
      <div style="width: 1200px; margin: auto;">
        <el-row :gutter="20" >        
        <a href="#"  class="first" @click="step(1, $event)" ><stepTile title="Витрата насоса" number="1" :class="[{ active: current==1}]" /></a>        
        <a href="#" @click="step(2, $event)"><stepTile title="Напір насоса" number="2" :class="[{ active: current==2}]"/></a> 
        <a href="#" @click="step(3, $event)"><stepTile title="Підбір насоса та приладдя" number="3"  :class="[{ active: current==3}]"/></a>
        <a href="#" @click="step(4, $event)"><stepTile slot="first" title="Пропозиції" number="4" :class="[{ active: current==4}]"/></a>
        </el-row>
   
        <transition name="flip" mode="out-in">
        <Step1 v-if='current==1'  
                :volumeFlow="volumeFlow"
                :modelFlowItems="modelFlowItems"
                :maxVolumeFlow="maxVolumeFlow"
                @onInputDataVolume="onInputDataVolume"
                @onInputFlowItems="onInputFlowItems"
                class="transition-box"/>              
        <Step2 v-else-if='current==2' 
                :deliveryHead="deliveryHead"
                :modelHeadItems="modelHeadItems"
                @onInputDataHead="onInputDataHead"
                @onInputHeadItems="onInputHeadItems"
                class="transition-box"/>         
        <Step3 v-else-if='current==3' class="transition-box"/>
        <Step4 v-else-if='current==4' class="transition-box"/> 
        </transition>     

        <el-row class="navigation-footer">
        <el-col :span="12">
             <el-button  @click="back" type="primary" icon="el-icon-d-arrow-left">Назад </el-button>
        </el-col>
        <el-col :span="12">
            <el-button @click="next" type="primary">Далі <i class="el-icon-d-arrow-right el-icon-right"></i></el-button>
        </el-col>
        </el-row>       
    </div>

        <!-- <ul v-for="item in posts" :value="item" :key="item.id" >
            <li>{{item}}</li>
        </ul> -->
  </div>
</template>

<script>
import Axios from 'axios';
export default {
  name: 'Home',
  props: {
    msg: String
  }, 
  data () {
        return {
                url:'',
                posts:[],
                current: 1,
                showStep: 0,
                activeClass: 'active',
                errorClass: 'text-danger',
                isActive: false,
                helperStep1: false,
                deliveryHead: 0,
                volumeFlow:0,
                maxVolumeFlow: 17,
                modelFlowItems: {
                    val1:0,
                    val2:0,
                    val3:0,
                    val4:0,
                    val5:0,
                    val6:0,
                    val7:0
                },
                modelHeadItems: {
                    val1:0,
                    val2:0,
                    val3:0,
                    val4:0
                }
            }
        },
        created: function() {
            this.fetchData();
        },
        methods: {           
            onInputDataVolume(val) {
                this.volumeFlow=val
            },
            onInputFlowItems(id, val){
                this.modelFlowItems['val'+id]=val;
            },
            onInputHeadItems(id, val){
                this.modelHeadItems['val'+id]=val;
            },
            onInputDataHead(val) {
                this.deliveryHead=val
            },
            fetchData: function() {
                const getPromise = Axios.get('http://www.wiloexpert.com.ua/wilo/db/getAllPumps');
                getPromise.then(response => {
                this.posts = response.data;
                });
                return getPromise;
                },
            postData: function(id) {
                const getPromise = Axios.post('http://www.wiloexpert.com.ua/wilo/db/getHelp', {"help_id" : 1});
                getPromise.then(response => {
                console.log(response);
                })
                .catch(error => {
                    console.log(error);
                });
                },
            next () {
                if (this.current == 4) {
                    this.current = 1;
                } else {
                    this.current+= 1;
                    this.isActive=true
                    this.showStep=this.current
                }
            },
            back () {
                if (this.current == 0) {
                    this.current = 0;
                } else {
                    this.current -= 1;
                }
            },
            step (n) {
               this.current = n               
            },
            onGetvolumeFlow(value) {
                this.volumeFlow=value
            }
        }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>
.el-message-box {
    width: 800px;
}
.el-message-box__title {
    font-weight: 600;
}
h1, h2, p {
    color: #363640
}
span {
    font-size: 16px;
}
.first .rect::after {
    display: none
}
.exeption-validation{
    color: #f16262;
    font-size: 14px;
}
.rect:after {
    width: 20px;
    height: 10px;
    content: "\E613";
    display: block;
    top: -84px;
    left: -47px;
    position: relative;
    font-family: element-icons;
    font-size: 33px;
    color: #555;
}

  .transition-box {
    margin-bottom: 10px;
    width: 100%;
    border-radius: 4px;
    background-color: #ffffff;
    text-align: center;
    color: #fff;
    padding: 20px 20px;
    box-sizing: border-box;
    margin-right: 20px;
  }

.flip-enter{}
.flip-enter-active {
  animation: flipInX 0.3s linear ;
}
.flip-leave{}
.flip-leave-active {
  animation: flipOutX 0.3s linear ;
}

@keyframes flipInX {
  from {transform: rotateX(90deg);}
  to {transform: rotateX(0deg);}  
}

@keyframes flipOutX {
  from {transform: rotateX(0deg);}
  to {transform: rotateX(90deg);}  
}

button.el-button.el-button--primary {
 
    border-radius: 0;
    min-width: 190px;
    font-size: 18px
}
.navigation-footer button.el-button.el-button--primary, .navigation-footer button.el-button.el-button--default  {
    background: #363640;
    color: #fff;
    border-radius: 0;
    font-size: 16px;
}
i.el-icon-info, i.el-icon-question {
    color: #fbc002;
    padding: 0 5px;
    font-size: 20px;
}

svg.svg-inline--fa.fa-lightbulb.fa-w-11 {
    float: left;
    font-size: 34px;
    color: #febf00;
    height: 50px;
    padding: 12px 15px;
}
.el-input-number {
    width: 150px;
    margin: 0 5px;
}
.el-dialog__body {
    padding: 0
}
.el-dialog__footer {
    text-align: center;
    padding: 20px 0
}
.transition-box .title {
    display: inline-block;
    float: left;
    padding: 15px;
}
.transition-box .circle {
    fill: #009c81;
    stroke: transparent
}
.transition-box .circle_numder {
    padding-top: 20px;
    margin: auto;
    width: 50px;
    height: 50px;
    float: left;
}
.transition-box .circle_numder span {
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
    line-height: 1.5;
    font-size: 15px;
}
</style>
