<template>

<div class="accessories">
  <!-- {{controllers}} -->
    <el-col :span="5">
                    <img :src="url+'assets/controller.jpg'" width="100px" alt="">
    </el-col>
    <el-col :span="17" :offset="2" class="text" v-html="description"></el-col>
    <el-row>{{phase}}
                        <p><strong>Ціна: {{price}} грн з ПДВ </strong></p>  
                        <p><strong>Тип пуску насоса:</strong> {{start}}  </p> 
                        <p><strong>Управління:</strong> {{operation}}  </p> 
                        <p><strong>Ток максимальний:</strong> {{current_max}} A </p>
                        <p><strong>Розміри:</strong> {{dim}}  </p>
                        <p><strong>Захист від сухого ходу:</strong> {{dry_running}}  </p> 
                        <a src="#">Завантажити інструкцію з експлуатаціЇ</a>        
    </el-row>
                           
</div>
</template>

<script>
  export default {
    props: ['url', 'controllers'],
    data() {
      return {
          price: this.controllers.price,
          current_max: this.controllers.features.current_max,
          start: this.controllers.features.start,
          operation: this.controllers.features.operation,
          dim: this.controllers.features.dim,
          dry_running: this.controllers.features.dry_running,
          description: this.controllers.features.description,
          phase:this.controllers.features.phase
           
      }
    },
    computed: {        
    },
    created:  function(){
      
      this.description=(this.description)
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
.accessories p{
  margin: 5px;
}
</style>