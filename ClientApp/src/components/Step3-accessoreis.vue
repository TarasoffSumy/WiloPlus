<template>
<div>
    <h2>Підібране приладдя</h2>
    <el-row>       
        <div class="item">    
                <el-row v-if="selectedAccessories.selected"> 
                    <h3>
                        {{selectedAccessories.title}}
                    </h3>
                    <el-col :span="2" :offset="6"><el-button @click="onDelete()" type="text"><i class="el-icon-circle-close-outline"></i></el-button> </el-col>
                    <!-- <el-col :span="5"><img :src="url+item.img" width="100px" alt=""></el-col> -->
                <el-col :span="3">
                                <img :src="url+'assets/controller.jpg'" width="100px" alt="">
                </el-col>
                <el-col :span="9" :offset="1">
                                    <p>Ціна <strong>{{selectedAccessories.price}} грн</strong></p>                           
                                    <p>Ток мінімальний  <strong>{{selectedAccessories.features.current_min}}</strong> </p>
                                    <p>Ток максимальний <strong>{{selectedAccessories.features.current_max}}</strong> </p>
                                    <el-button type="primary">Детальніше</el-button>                       
                </el-col>                    
                </el-row> 
        </div>
    </el-row> 
</div>
</template>

<script>
  export default {
    props: ['url', 'selectedAccessories' ],
    data() {        
      return {
        newData: this.selectedAccessories,
        HeadValTotal: 0,
        focusInput: 0
      }
    },
    computed: {
        
    },
    created:  function(){
    },
    methods: {
    onDelete(){
        // this.selectedAccessories['item'+id].selected=false
        // this.selectedAccessories['item'+id].idController=undefined

        }
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

