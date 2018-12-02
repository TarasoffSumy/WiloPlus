<template>
  <div>  <p>Step {{ current  }} </p>
      <div style="width: 1200px; margin: auto;">
 
        <el-row :gutter="20" >
        
        <a href="#"  class="first" @click="step(1, $event)" ><stepTile title="Витрата насоса" number="1" :class="[{ active: current==1}]" /></a>        
        <a href="#" @click="step(2, $event)"><stepTile title="Напір насоса" number="2" :class="[{ active: current==2}]"/></a> 
        <a href="#" @click="step(3, $event)"><stepTile title="Підбір насоса та приладдя" number="3"  :class="[{ active: current==3}]"/></a>
        <a href="#" @click="step(4, $event)"><stepTile slot="first" title="Пропозиції" number="4" :class="[{ active: current==4}]"/></a>
        </el-row>
        homeData {{volumeFlow}}


    
        <transition name="flip" mode="out-in">
        <Step1 v-if='current==1'  
                :volumeFlow="volumeFlow"
                @inputData="inputData"
                class="transition-box"/>              
        <Step2 v-else-if='current==2' class="transition-box"/>         
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

        <ul v-for="item in posts" :value="item" :key="item.id" >
            <li>{{item.name}}</li>
        </ul>
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
                posts:"",
                current: 1,
                showStep: 0,
                activeClass: 'active',
                errorClass: 'text-danger',
                isActive: false,
                helperStep1: false,
                deliveryHead:0,
                volumeFlow:0
            }
        },
        created: function() {
            this.fetchData();
        },
        methods: {           
            inputData(val) {
                this.volumeFlow=val
            },
            fetchData: function() {
                const getPromise = Axios.get('http://wilocore/name/getAllNames');
                getPromise.then(response => {
                this.posts = response.data;
                });
                return getPromise;
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
h1, h2, p {
    color: #363640
}
.first .rect::after {
    display: none
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
    padding: 40px 20px;
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
.navigation-footer button.el-button.el-button--primary {
    background: #363640;
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
</style>
