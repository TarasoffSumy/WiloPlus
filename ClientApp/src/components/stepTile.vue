<template>
    <div>        
        <el-col :xs="12" :sm="6" :lg="6"> 
            <div class="rect">           
            <div class="circle_number">
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
    width: 90%;
    height: 140px;
    margin-bottom: 20px;
    background: #eee;
}
.rect:hover, .active .rect:hover {
    box-shadow: 0 2px 12px 0 rgba(0,0,0,.1);
    box-shadow: 0 2px 12px 0 #eee;
}
 .active .rect:hover, .active .circle:hover {
     background: #04b193
 }
.active .rect:hover  .circle {
     fill: #04b193
 }
.circle {
    fill: #ebebeb;
    stroke: #686868
}
.circle_number {
    padding-top: 20px;
    margin: auto;
    width: 50px;
    height: 50px;
}
.circle_number span {
    position: relative;
    top: -48px;
    left: 0px;
    font-size: 25px;
    color: #686868;
}
.title{
    font-size: 20px;
    line-height: 1.1;
    color: #4d4d4d;
    height: 30px;    
    padding: 0 10px
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
.active .circle_number span{
    color: #fff
}

</style>

