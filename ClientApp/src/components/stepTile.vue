<template>
    <div>        
        <el-col :xs="12" :sm="6" :lg="6"> 
            <div class="rect">           
            <div class="circle_number">
            <svg height="55" width="53" class="circle">
            <circle cx="26" cy="26" r="24" stroke="" stroke-width="2" fill="" />
            </svg> <span>{{number}}</span>            
            </div> 
            <p class="title" :class="'title_'+number">{{title}}</p>     
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

