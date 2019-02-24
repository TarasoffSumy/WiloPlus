<template>
  <div id="app">
  
   
    <Home msg="Welcome to Willo App"/>
     
 
  </div>
</template>

<script>



export default {
  name: 'app',
 }
</script>

<style>
body {
    font-family: 'wilo-font', sans-serif;
}
#app {
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  font-family: 'wilo-font', sans-serif;
}
.el-radio-button__inner, .el-checkbox-button__inner {
    border: 1px solid #009c81!important;
    min-width: 135px;
    color: #009c81!important;
}
.el-checkbox-button.is-checked .el-checkbox-button__inner {
    color: #ffffff!important;
}
.el-radio-button:first-child .el-radio-button__inner, .el-checkbox-button:first-child .el-checkbox-button__inner {
    border-left: 1px solid #009c81!important;
}
.el-popover--plain {
    background-color: #f8e19d!important;    
}
 .popper__arrow {
    border: 2px solid  #f8e19d; 
 }
.el-popover{
      text-align: left!important;
}
.el-radio-button:first-child:last-child .el-radio-button__inner {
    border-radius: 0!important;
}
.el-radio-button:first-child .el-radio-button__inner {
    border: 1px solid #009c81;
}
.el-checkbox-button:last-child .el-checkbox-button__inner {
    border-radius: 0!important;
}
.el-form-item__label {
    line-height: 30px!important;
}


@media (max-width: 575px)  {
    .radio-jackets {
        text-align: center;
        margin: 5px;
    }
    .mobile{
        display:block;
    }  
    .mobile .row-item {
        height: 130px;
    }
    .desktop, .mobile .side-right-helper, .accesorias-top {
        display:none;
    } 
    .container, .container .transition-box { 
        width: 100%;
    }
    .greyBoxes-container {
        display: block;
        float: left
    }
    .greyBox {
        width: 88%;
    }
    .box-helper-info {
        padding: 20px;
        width: 100%;
        margin-left: -20px;
    }

 }
/* // Medium devices (tablets, 768px and up) */
@media (min-width: 576px) and (max-width: 767px) {
    .radio-jackets {
        text-align: center;
        margin: 5px;
    }
    .container, .container .transition-box  {
        width: 100%;
    }
    .mobile,{
        display:block;
    }
    .desktop, .mobile .side-right-helper, .accesorias-top  {
        display:none;
    }
    .box-helper-info {
        padding: 20px;
        width: 100%;
        margin-left: -20px;
    }

 }
 /*// Medium devices (tablets, 768px and up)*/
 @media (min-width: 768px) and (max-width: 991px) {
    .mobile{
        display:block;
    }
    .desktop, .mobile .side-right-helper, .accesorias-top  {
        display:none;
    }
    .container, .container .transition-box  {
        width: 100%;
    }
    .box-helper-info {
        padding: 20px;
        width: 100%;
        margin-left: -20px;
    }
    .radio-jackets {
        text-align: center;
        margin: 5px;
    }
 }

/* // Large devices (desktops, 992px and up) */
@media (min-width: 992px) and (max-width: 1199px) {
    .mobile{
        display:none;
    }
    .desktop {
        display:block;
    }
    .container {
        width: 70%;
        margin: auto;
    }
    .greyBoxes-container {
        display: flex;
        flex-direction: row;
        }
    .greyBox {
        width: 46%
    }
    .box-helper-info {
        padding: 20px;
        width: 104%;
        margin-left: 0;
    }
    .accesorias-item {
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
    }
    .accesorias-item-mufts {
        width: 47%; 
        margin: 0px 1.5%; float: left;
    }
    .radio-jackets {
        display: inline-block;
        margin: 5px;
    }
 }

/* // Extra large devices (large desktops, 1200px and up) */

@media (min-width: 1200px) {

    .mobile {
        display:none;
    }
    .desktop {
        display:block;
    }
    .container {
        width: 70%;
        margin: auto;
    }
    .greyBoxes-container {
        display: flex;
        flex-direction: row;
    }
    .greyBox {
        width: 46%
    }
    .box-helper-info {
        padding: 20px;
        width: 104%;
        margin-left: 0;
    }
    .accesorias-item {
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        margin-bottom: 10px;
    }
    .radio-jackets {
    display: inline-block;
    margin: 5px;
    }
 }
</style>
