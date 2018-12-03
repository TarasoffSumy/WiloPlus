<template>
<div>
    <h2>Помічник визначення напору насоса</h2>
    <el-row>
        <el-col :span="12" class="side-side2-helper">
            <div class="row-item" :class="[{ active: focusInput==1}]">
                <div class="circle_numder">
                    <svg height="36" width="36" class="circle">
                    <circle cx="17" cy="17" r="17" stroke="" stroke-width="2" fill="" />
                    </svg><div class="symbolInCircle">A </div>            
                </div>
                <span class="item"> Висота від землі до рівня води в свердловині </span>    
                <el-input-number  @focus="onFocusInput_1" v-model="volumeFlow.Val1" @change="handleChange" :min="0" :max="17"></el-input-number>
                м 
            </div>
            <div class="row-item" :class="[{ active: focusInput==2}]">
                <div class="circle_numder">
                    <svg height="36" width="36" class="circle">
                    <circle cx="17" cy="17" r="17" stroke="" stroke-width="2" fill="" />
                    </svg> <div class="symbolInCircle">B </div>            
                </div>
                <span class="item">Відстань від будинку до свердловини </span>   
                <el-input-number  @focus="onFocusInput_2" v-model="volumeFlow.Val2" @change="handleChange" :min="0" :max="17"></el-input-number>
                м 
            </div>
            <div class="row-item" :class="[{ active: focusInput==3}]">
                <div class="circle_numder" >
                    <svg height="36" width="36" class="circle">
                    <circle cx="17" cy="17" r="17" stroke="" stroke-width="2" fill="" />
                    </svg> <div class="symbolInCircle">C </div>            
                </div>
                <span class="item">Висота між землею і найвище розташованим приладом водоспоживання </span>  
                <el-input-number :class="[{ active: focusInput==3}]"  @focus="onFocusInput_3"  v-model="volumeFlow.Val3" @change="handleChange" :min="0" :max="17"></el-input-number>
                м 
            </div>
            <div class="row-item"><div class="additional-volume-flow"><el-button type="text" class="link" @click="open">Додаткові витарти<i type="info" class="el-icon-question"></i> </el-button></div>  
                <el-input-number v-model="volumeFlow.Val7" @change="handleChange" :min="0" :max="17"></el-input-number>
                м             
            </div>
            <div class="row-item">
                <div class="computed-deliveryHead">
                <span class="label">Розрахований напір</span>
                <span class="number"> {{volumeFlowValTotal}}</span> м 
                </div>                
            </div>

        </el-col>
        <el-col :span="10" class="side-side2-helper">
            <el-button @click="onFocusInput_1"  class="circle_numder number_A" :class="[{ active: focusInput==1}]" type="text">
                    <svg height="36" width="36" class="circle">
                    <circle cx="17" cy="17" r="17" stroke="" stroke-width="2" fill="" />
                    </svg><div class="symbolInCircle">A </div>                            
            </el-button>
            <el-button @click="onFocusInput_2"  class="circle_numder number_B"  type="text" :class="[{ active: focusInput==2}]">
                    <svg height="36" width="36" class="circle">
                    <circle cx="17" cy="17" r="17" stroke="" stroke-width="2" fill="" />
                    </svg><div class="symbolInCircle">B </div>                            
            </el-button>
            <el-button @click="onFocusInput_3"   class="circle_numder number_C"  type="text" :class="[{ active: focusInput==3}]">
                    <svg height="36" width="36" class="circle">
                    <circle cx="17" cy="17" r="17" stroke="" stroke-width="2" fill="" />
                    </svg><div class="symbolInCircle">C </div>                            
            </el-button>
            <img class="pos-img" src="assets/head_scheme.jpg" alt="">
        </el-col>
    </el-row> 
    <el-row >    
    </el-row> 
</div>
</template>
<script>
  export default {
    data() {
      return {
          volumeFlow: {
              
          },         
        volumeFlowValTotal: 0,
        focusInput:1
      };
    },
    methods: {
      handleChange(value) {
        var source=Object.values(this.volumeFlow);
        var result=source.reduce(function(sum, current) {
            return sum + current ;
        });
        this.volumeFlowValTotal=result
        this.$emit('onComputevolumeFlow', this.volumeFlowValTotal)
      },
      onFocusInput_1() {
          this.focusInput=1  
      },
      onFocusInput_2() {
          this.focusInput=2  
      },
        onFocusInput_3() {
          this.focusInput=3  
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
.circle_numder.number_A, .circle_numder.number_B, .circle_numder.number_C {
    position: relative; 
    z-index: 5
}
.active {
    background: #009c82;
}

.circle_numder.number_A .symbolInCircle, 
.circle_numder.number_B .symbolInCircle,
.circle_numder.number_C .symbolInCircle
{
    top: -34px;
    left: -1px;
}
.circle_numder.number_A {
    top: 355px;
    left: -176px;
}
.circle_numder.number_B {
    top: 344px;
    left: -34px;
}
.circle_numder.number_C {
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
.circle_numder {
    padding-top: 20px;
    margin: auto;
    width: 50px;
    height: 50px;
    display: inline-table;
    vertical-align: middle;
}
.circle_numder .symbolInCircle {
    position: relative;
    top: -38px;
    left: -2px;
    font-size: 20px;
    color: #fff;
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

