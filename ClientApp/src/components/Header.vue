<template>
<div class="header-bg">
    <el-alert class="my-alert" v-if="markIe"
    title="Заваньтажте сучасний веб-переглядач"
    type="error"
    description="З"
    show-icon>
    <br><a href="https://www.google.com/intl/ru_ALL/chrome/">Google Chrome для Windows</a>
    </el-alert> 

    <el-row :gutter="10">
        <el-col  :xs="24" :sm="24" :md="4" :lg="3" :xl="4">
            <img class="logo-img" @click="reload" width="120" src="https://www.wiloexpert.com.ua/wilo/assets/header_logo.png" alt=""> 
        </el-col>
        <el-col justify="center" :xs="24" :sm="24" :md="20" :lg="17" :xl="20">
            <h1> Підбір свердловинних насосів</h1>
        </el-col>   
    </el-row>  
</div>
</template>

<script>
export default {
    data() {
      return {
          markIe: false
      }
      },
    created: function() {
        var msie = document.documentMode;
        if (navigator.userAgent.indexOf('MSIE') !== -1 || navigator.appVersion.indexOf('Trident/') > 0) {
            this.markIe=true
            }
    },
    methods: {
        reload() {
            location.reload()
        }
    }
}
</script>
<style scoped>
 .el-alert.my-alert.el-alert--error {
    height: 200px;
    text-align: center;
    margin: 1% 0;
}
</style>


