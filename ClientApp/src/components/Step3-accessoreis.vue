<template>
<div>
    <h2>Підібране приладдя</h2>
    <el-row>       
        <div class="item-selected">    
                <el-row  v-if="controllers.selected"> 
                    <h3>
                        {{controllers.title}}
                    </h3>
 
                    <el-col :span="2" :offset="1"><el-button @click="onDelete()" type="text"><i class="el-icon-circle-close-outline"></i></el-button> </el-col>
                    <el-col :span="20">
                         <ControlBox 
                        :controllers="controllers"
                        :url="url"
                        /> 
                    </el-col>                   
                </el-row> 
                <el-row v-if="cable.selected"> 
                    <h3>
                         {{cable.title}}
                    </h3>
                    <el-col :span="2" :offset="1"><el-button @click="onDelete()" type="text"><i class="el-icon-circle-close-outline"></i></el-button> </el-col>
                    <el-col :span="20">
                         <Cable 
                        :cable="cable"
                        :url="url"
                        /> 
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
        cable: this.selectedAccessories.item2,
        controllers: this.selectedAccessories.item1,
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
<style >

</style>

