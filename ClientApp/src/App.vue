<template>
  <div id="app">
  
    <HeaderPart />
    <Home msg="Welcome to Willo App"/>
     
 
  </div>
</template>

<script>



export default {
  name: 'app',
 }
</script>

<style>
#app {
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  /* font-family: 'Open Sans', sans-serif; */
  font-family: 'wilo-font', sans-serif;
}
.el-step__title.is-process {
    background: #ebebeb
}
.el-step__title {
  display: block;
  background: #ddd
}
.el-step__line {
    display: none;
}
.el-step__icon.is-icon {
    left: 139px;
    top: 20px;
}
.el-step.is-horizontal.is-center {
    margin: 45px;
    background: #ebebeb;
    height: 140px;
}
.el-step.is-horizontal.is-center::before {
    width: 20px;
    height: 10px;
    content: "\E613";
    display: block;
    top: 51px;
    left: -34px;
    position: relative;
    font-family: element-icons;
    font-size: 28px;
    color: #555;
}
.el-step.is-horizontal.is-center:first-child::before{
  display: none;
}
.el-step__icon.is-icon {
    right: -45px;
    top: 20px;
    position: absolute;
}
.el-step__icon.is-text {
    display: none;
}
.el-step__title {
    width: 20px;
    /* height: 20px; */
    padding: 0 9px;
    border-radius: 50%;
    margin: auto;
    font-size: 20px;
    border: 2px solid #555;
    margin-top: 20px;
}
.is-horizontal .el-step__description {
    font-size: 20px;
    margin-top: 21px;
}
.el-steps--horizontal .is-process{
  background: #009c81
}

/* .el-row .rect :first-child ::before{
    display: none;
} */

</style>
