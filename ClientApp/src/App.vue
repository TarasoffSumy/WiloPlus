<template>
  <div id="app">
    <Home msg="Welcome to Willo App" />
  </div>
</template>

<script>
export default {
  name: "app"
};
</script>

<style>
body {
  font-family: "wilo-font", sans-serif;
}
#app {
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  font-family: "wilo-font", sans-serif;
}

.el-card {
  margin: 5px;
}
.el-collapse-item__content {
  padding: 0 10px;
}
.el-radio-button__inner,
.el-checkbox-button__inner {
  border: 1px solid #009c81 !important;
  min-width: 135px;
  color: #009c81 !important;
}
.el-checkbox-button.is-checked .el-checkbox-button__inner {
  color: #ffffff !important;
}
.el-radio-button:first-child .el-radio-button__inner,
.el-checkbox-button:first-child .el-checkbox-button__inner {
  border-left: 1px solid #009c81 !important;
}
.el-popover--plain {
  background-color: #f8e19d !important;
}
.popper__arrow {
  border: 2px solid #f8e19d;
}
.el-popover {
  text-align: left !important;
}
.el-radio-button:first-child:last-child .el-radio-button__inner {
  border-radius: 0 !important;
}
.el-radio-button:first-child .el-radio-button__inner {
  border: 1px solid #009c81;
}
.el-checkbox-button:last-child .el-checkbox-button__inner {
  border-radius: 0 !important;
}
.el-collapse-item__header {
  font-size: 15px !important;
  padding: 5px 15px;
}
.el-tabs__item {
  font-size: 16px !important;
}
.el-form-item__label {
  line-height: 30px !important;
}
.el-tabs__header {
  margin: 0 !important;
}
.accesorias-item-mufts {
  width: 47%;
  margin: 0px 1.5%;
  float: left;
}
.el-tabs__content {
  background: #f7f6f6;
  padding: 10px;
}
img.calc-bg {
  background: #009c81;
  position: relative;
  top: 7px;
  left: -1px;
  width: 16px;
  padding: 1px;
}
.title {
  font-size: 20px;
  line-height: 1.1;
  color: #4d4d4d;
  height: 30px;
  padding: 0 10px;
  text-align: center;
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
.rect {
  width: 90%;
  height: 140px;
  margin-bottom: 20px;
  background: #ebebeb;
  cursor: pointer;
}
.rect:after {
  width: 20px;
  height: 10px;
  content: "\E613";
  display: block;
  top: -84px;
  left: -39px;
  position: relative;
  font-family: element-icons;
  font-size: 33px;
  color: #555;
}
img.logo-img {
  cursor: pointer;
  padding: 10px;
}
span.name-equipment {
  padding-left: 10px;
}
span.sub-title.point {
  min-height: 40px;
  padding: 5px 0;
  display: block;
  margin: 0 5px 0 5px;
  border-bottom: solid 1px #c4c0c0;
}
@media (max-width: 575px) {
  .lang-container {
    position: absolute;
    top: 17px;
    right: 9.5%;
  }
  canvas#line-chart {
    margin-left: -20px;
  }
  span.sub-title.point {
    min-height: 50px;
  }
  .name-equipment {
    font-weight: bold;
    padding-left: 5px;
    text-transform: uppercase;
    font-size: 15px;
  }
  svg.circle {
    width: 38px;
    height: 38px;
  }
  circle {
    cx: 19px;
    cy: 19px;
    r: 18;
  }
  .circle_number span {
    top: -36px;
  }
  .circle_number{
    height: 30px;
  }
  .header-bg {
    background: transparent;
  }
  img.logo-img {
    width: 90px;
    padding: 0;
    margin-top: 7px;
  }
  h1 {
    font-size: 20px;
  }
  .header-bg {
    background: #eee;
    margin-bottom: 5px;
  }
  .rect {
    width: 99%;
    height: 120px;
    margin-bottom: 5px;
  }
  .rect:after {
    display: none;
  }
  .title {
    font-size: 18px;
    line-height: 1.1;
    padding: 0px 5px;
  }
  .radio-jackets {
    text-align: center;
    margin: 5px;
  }
  .mobile {
    display: block;
  }
  .mobile .row-item {
    height: 130px;
  }
  .desktop,
  .mobile .side-right-helper,
  .accesorias-top {
    display: none;
  }
  .container,
  .container .transition-box {
    width: 100%;
  }
  .greyBoxes-container {
    display: block;
    float: left;
  }
  .greyBox {
    width: 99%;
  }
  .box-helper-info {
    padding: 20px;
    width: 100%;
    margin-left: -20px;
  }
  .accesorias-item-mufts {
    width: 100%;
  }
}
/* // Medium devices (tablets, 768px and up) */
@media (min-width: 576px) and (max-width: 767px) {
  .lang-container {
    position: absolute;
    top: 17px;
    right: 9.5%;
  }
  .header-bg {
    background: #eee;
    margin-bottom: 5px;
  }
  h1 {
    font-size: 20px;
  }
  .title {
    font-size: 16px;
    line-height: 1;
    height: 20px;
    padding: 10px;
  }
  .radio-jackets {
    text-align: center;
    margin: 5px;
  }
  .container,
  .container .transition-box {
    width: 100%;
  }
  .mobile {
    display: block;
  }
  .desktop,
  .mobile .side-right-helper,
  .accesorias-top {
    display: none;
  }
  .box-helper-info {
    padding: 20px;
    width: 100%;
    margin-left: -20px;
  }
  .accesorias-item-mufts {
    width: 100%;
  }
}
/*// Medium devices (tablets, 768px and up)*/
@media (min-width: 768px) and (max-width: 1024px) {
  .title {
    font-size: 18px;
    }
  .lang-container {
    position: absolute;
    top: 17px;
    right: 9.5%;
  }
  .mobile {
    display: block;
  }
  .desktop,
  .mobile .side-right-helper,
  .accesorias-top {
    display: none;
  }
  .container,
  .container .transition-box {
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
  .accesorias-item-mufts {
    width: 47%;
  }
}

/* // Large devices (desktops, 992px and up) */
@media (min-width: 992px) and (max-width: 1199px) {
  .lang-container {
    position: absolute;
    top: 53px;
    right: 15.5%;
  }
  .mobile {
    display: none;
  }
  .desktop {
    display: block;
  }
  .container {
    width: 75%;
    margin: auto;
  }
  .greyBoxes-container {
    display: flex;
    flex-direction: row;
  }
  .greyBox {
    width: 46%;
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
  }
  .radio-jackets {
    display: inline-block;
    margin: 5px;
  }
}

/* // Extra large devices (large desktops, 1200px and up) */

@media (min-width: 1200px) {
  .rect {
    width: 90%;
    height: 160px;
    }
  .lang-container {
    position: absolute;
    top: 53px;
    right: 16%;
  }
  .mobile {
    display: none;
  }
  .desktop {
    display: block;
  }
  .container {
    width: 75%;
    margin: auto;
  }
  .greyBoxes-container {
    display: flex;
    flex-direction: row;
  }
  .greyBox {
    width: 46%;
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
