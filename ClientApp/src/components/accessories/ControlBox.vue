<template>

<div>
  <!-- {{controllers}} -->
    <el-col :span="5">
                    <img :src="url+'assets/controller.jpg'" width="100px" alt="">
    </el-col>
    <el-col :span="12" :offset="2">
                        <p>Ціна <strong>{{price}} грн</strong></p>                           
                        <p>Ток мінімальний  <strong>{{current_min}}</strong> </p>
                        <p>Ток максимальний <strong>{{current_max}}</strong> </p>
                        <el-button type="primary">Детальніше</el-button>                       
    </el-col>                    
</div>
</template>

<script>
  export default {
    props: ['url', 'controllers'],
    data() {
      return {
          price: this.controllers.price,
          current_min: this.controllers.features.current_min,
          current_max: this.controllers.features.current_max
      }
    },
    computed: {        
    },
    created:  function(){
    },
    methods: {
    }
  };
</script>
<style scoped >
.item {
    width: 50%;
    float: left;
    text-align: left
}
</style>