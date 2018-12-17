<template>
    <div>        
        <el-col :span="6"> 
            <div class="rect" >           
            <div class="circle_numder">
            <svg height="55" width="53" class="circle">
            <circle cx="26" cy="26" r="24" stroke="" stroke-width="2" fill="" />
            </svg> <span>{{number}} </span>            
            </div> 
            <p class="title">{{title}}</p>     
            </div>
        </el-col>
    </div>
</template>
<script>
export default {
  props: ['title', 'number']
}
</script>
<style>
.rect {
    width: 240px;
    height: 140px;
    background: #eee;
}
.circle {
    fill: #ebebeb;
    stroke: #686868
}
.circle_numder {
    padding-top: 20px;
    margin: auto;
    width: 50px;
    height: 50px;
}
.circle_numder span {
    position: relative;
    top: -53px;
    left: 0px;
    font-size: 25px;
    color: #686868;
}
.title{
    font-size: 19px;
    line-height: 1.1;
    color: #4d4d4d;
    height: 30px;    
}
.active .circle {
    fill: #009c81;
    stroke: #fff
}
.active .rect {
      background: #009c81
  }
.active .title {
    color: #fff
}
.active .circle_numder span{
    color: #fff
}

</style>

